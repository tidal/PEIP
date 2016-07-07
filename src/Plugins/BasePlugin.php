<?php

namespace PEIP\Plugins;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BasePlugin.
 *
 * @author timo
 */
class BasePlugin extends \PEIP\ABS\Context\ContextPlugin implements \PEIP\INF\Context\ContextPlugin
{
    protected $builders = [
        'include'                   => 'createContext',
        'plugin'                    => 'createPlugin',
        'channel'                   => 'createChannel',
        'publish_subscribe_channel' => 'createSubscribableChannel',
        'service_activator'         => 'createServiceActivator',
        'gateway'                   => 'createGateway',
        'splitter'                  => 'createSplitter',
        'transformer'               => 'createTransformer',
        'router'                    => 'createRouter',
        'aggregator'                => 'createAggregator',
        'wiretap'                   => 'createWiretap',
    ];

    /**
     * Creates a pollable channel from a configuration object.
     *
     * @see XMLContext::doCreateChannel
     *
     * @param object $config configuration object for the pollable channel.
     *
     * @return \PEIP\INF\Channel\Channel the created pollable channel instance
     */
    public function createChannel($config)
    {
        return $this->doCreateChannel($config, '\PEIP\Channel\PollableChannel');
    }

    /**
     * Creates a subscribable channel from a configuration object.
     *
     * @see XMLContext::doCreateChannel
     *
     * @param object $config configuration object for the subscribable channel.
     *
     * @return \PEIP\INF\Channel\Channel the created subscribable channel instance
     */
    public function createSubscribableChannel($config)
    {
        return $this->doCreateChannel($config, '\PEIP\Channel\PublishSubscribeChannel');
    }

    /**
     * Creates and registers arbitrary channel from a configuration object and additional information.
     *
     * @param object $config              configuration object for the channel.
     * @param string $defaultChannelClass the channel class to use if none is set in config
     * @param $additionalArguments additional arguments for the channel constructor (without first arg = id)
     *
     * @return \PEIP\INF\Channel\Channel the created channel instance
     */
    public function doCreateChannel($config, $defaultChannelClass, array $additionalArguments = [])
    {
        $id = (string) $config['id'];
        if ($id != '') {
            array_unshift($additionalArguments, $id);
            $channel = $this->buildAndModify($config, $additionalArguments, $defaultChannelClass);
            //$this->channelRegistry->register($channel);

            return $channel;
        }
    }

    /**
     * Creates and registers gateway from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     *
     * @param object $config       configuration object for the gateway.
     * @param string $defaultClass the class to use if none is set in config.
     *
     * @return object the gateway instance
     */
    public function createGateway($config, $defaultClass = false)
    {
        $args = [
            $this->getRequestChannel($config),
            $this->getReplyChannel($config),
        ];
        $defaultClass = $defaultClass ? $defaultClass : '\PEIP\Gateway\SimpleMessagingGateway';
        $gateway = $this->buildAndModify($config, $args, $defaultClass);
        $id = (string) $config['id'];
        $this->gateways[$id] = $gateway;

        return $gateway;
    }

    /**
     * Creates and registers router from a configuration object.
     * Adds this context instance as channel-resolver to the router if
     * none is set in config.
     *
     * @see XMLContext::resolveChannelName
     * @see XMLContext::initNodeBuilders
     *
     * @param object $config       configuration object for the gateway.
     * @param string $defaultClass the class to use if none is set in config.
     *
     * @return object the router instance
     */
    public function createRouter($config, $defaultClass = false)
    {
        $resolver = $config['channel_resolver'] ? (string) $config['channel_resolver'] : $this->channelRegistry;

        return $this->buildAndModify($config, [
            $resolver,
            $this->doGetChannel('input', $config),
        ], $defaultClass);
    }

    /**
     * Creates and registers splitter from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     *
     * @param object $config configuration object for the splitter.
     *
     * @return object the splitter instance
     */
    public function createSplitter($config)
    {
        return $this->createReplyMessageHandler($config);
    }

    /**
     * Creates and registers transformer from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     *
     * @param object $config configuration object for the transformer.
     *
     * @return object the transformer instance
     */
    public function createTransformer($config)
    {
        return $this->createReplyMessageHandler($config);
    }

    /**
     * Creates aggregator from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     *
     * @param object $config configuration object for the aggregator.
     *
     * @return object the aggregator instance
     */
    public function createAggregator($config)
    {
        return $this->createReplyMessageHandler($config);
    }

    /**
     * Creates wiretap from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     *
     * @param object $config configuration object for the wiretap.
     *
     * @return object the wiretap instance
     */
    public function createWiretap($config)
    {
        return $this->createReplyMessageHandler($config, '\PEIP\Listener\Wiretap');
    }

    /**
     * Creates a reply-message-handler from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     *
     * @param object $config       configuration object for the reply-message-handler.
     * @param string $defaultClass the class to use if none is set in config.
     *
     * @return object the reply-message-handler instance
     */
    public function createReplyMessageHandler($config, $defaultClass = false)
    {
        return $this->buildAndModify($config, $this->getReplyHandlerArguments($config), $defaultClass);
    }

    /**
     * Creates and registers service-activator from a configuration object.
     *
     * @see XMLContext::initNodeBuilders
     *
     * @param object $config       configuration object for the service-activator.
     * @param string $defaultClass the class to use if none is set in config.
     *
     * @return object the service-activator instance
     */
    public function createServiceActivator($config, $defaultClass = false)
    {
        $method = (string) $config['method'];
        $service = $this->context->getServiceProvider()->provideService((string) $config['ref']);
        if ($method && $service) {
            $args = $this->getReplyHandlerArguments($config);
            array_unshift($args, [
                $service,
                $method,
            ]);
            $defaultClass = $defaultClass ? $defaultClass : '\PEIP\Service\ServiceActivator';

            return $this->buildAndModify($config, $args, $defaultClass);
        }
    }

    /**
     * Utility method to create arguments for a reply-handler constructor from a config-obect.
     *
     * @param object $config configuration object to create arguments from.
     *
     * @return mixed build arguments
     */
    protected function getReplyHandlerArguments($config)
    {
        $args = [
            $this->doGetChannel('input', $config),
            $this->doGetChannel('output', $config),
        ];
        if ($args[0] == null) {
            throw new \RuntimeException('Could not receive input channel.');
        }

        return $args;
    }

    /**
     * Utility method to return a request-channel from a config-obect.
     *
     * @see XMLContext::doGetChannel
     *
     * @param object $config configuration object to return request-channel from.
     *
     * @return \PEIP\INF\Channel\Channel request-channel
     */
    protected function getRequestChannel($config)
    {
        return $this->doGetChannel('request', $config);
    }

    /**
     * Utility method to return a reply-channel from a config-obect.
     *
     * @see XMLContext::doGetChannel
     *
     * @param object $config configuration object to return reply-channel from.
     *
     * @return \PEIP\INF\Channel\Channel reply-channel
     */
    protected function getReplyChannel($config)
    {
        return $this->doGetChannel('reply', $config);
    }

    /**
     * Utility method to return a certainn channel from a config-obect.
     *
     * @param string the configuration type ofthe channel (e.g.: 'reply', 'request')
     * @param object $config configuration object to return channel from.
     *
     * @return \PEIP\INF\Channel\Channel reply-channel
     */
    public function doGetChannel($type, $config)
    {
        $channelName = isset($config[$type.'_channel'])
            ? $config[$type.'_channel']
            : $config['default_'.$type.'_channel'];

        return $this->context->getServiceProvider()->provideService(trim((string) $channelName));
    }
}
