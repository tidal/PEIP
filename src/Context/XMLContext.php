<?php

namespace PEIP\Context;

namespace PEIP\Context;

/*
 * This file is part of the PEIP package.oBuild
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * XMLContext 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 * @implements \PEIP\INF\Context\Context, \PEIP\INF\Channel\ChannelResolver
 */


use PEIP\Service\HeaderServiceActivator;
use PEIP\Channel\ChannelRegistry;
use PEIP\Service\ServiceProvider;
use PEIP\Plugins\BasePlugin;
use PEIP\Factory\ServiceFactory;
use PEIP\Base\GenericBuilder;
use PEIP\Context\XMLContextReader;

class XMLContext 
    implements 
        \PEIP\INF\Context\Context,
        \PEIP\INF\Channel\ChannelResolver {

    protected 
        $services = array(),
        $configs = array(),
        $gateways = array(),
        $nodeBuilders = array(),
        $channelRegistry,
        $serviceProvider;
          
    /**
     * constructor
     * 
     * @access public
     * @param string $string the configuration string 
     * @return 
     */
    public function __construct($string){
        $this->initNodeBuilders();
        $reader = new XMLContextReader($string);
 

        $serviceActivator = new HeaderServiceActivator(array($this, 'addConfig'), 'NODE');

        $reader->connect('read_node',  $serviceActivator);
        $reader->read();

       
    }

    public function addConfig($config){ 
        return $this->getServiceProvider()->addConfig($config);
    }

    public function handleReadConfig(\PEIP\INF\Event\Event $event){
        $this->addConfig($event->getHeader('NODE'));
    }

    /**
     * Creates and returns a XMLContext instance from a given config-string.
     * 
     * @access public
     * @param string $string the configuration string 
     * @return XMLContext the context instance
     * @throws RuntimeException 
     */      
    public static function createFromString($string){
        return new XMLContext($string);
    }

    /**
     * Creates and returns a XMLContext instance from a given config-file.
     * 
     * @access public
     * @param string $file the path to the configuration file 
     * @return XMLContext the context instance
     * @throws RuntimeException 
     */    
    public static function createFromFile($file){
        if(file_exists($file)){
            return self::createFromString(file_get_contents($file));
        }else{
            throw new \RuntimeException('Cannot open file  "'.$file.'".');
        }
    }
           
    /**
     * Initializes the context.
     * 
     * @access protected
     * @return void
     */
    protected function init(){
        $xml = $this->simpleXML;
        $this->channelRegistry = ChannelRegistry::getInstance();
        // register this context as a service if id is set.
        if($xml['id']){
            $this->services[(string)$xml['id']] = $this;    
        }
        // build services
        foreach($xml->children() as $entry){
            $this->buildNode($entry);
        }
    }    
     
    /**
     * Registers a callable as builder for given node-name
     * 
     * @implements \PEIP\INF\Context\Context
     * @access public
     * @param string $nodeName the name of the node 
     * @param callable $callable a callable which creates instances for node-name 
     */
    public function registerNodeBuilder($nodeName, $callable){
       return  $this->getServiceProvider()->registerNodeBuilder($nodeName, $callable);
    }
   
    /**
     * Registers a context-plugin instance.
     * 
     * @implements \PEIP\INF\Context\Context
     * @access public
     * @param \PEIP\INF\Context\Context_Plugin $plugin a plugin instance
     */
    public function addPlugin(\PEIP\INF\Context\ContextPlugin $plugin){ 
        $plugin->init($this);   
    }
  
    /**
     * Creates a registers a context-plugin instance from a config object.
     * 
     * @access public
     * @param object $config configuration object for the plugin 
     * @return 
     */
    public function createPlugin($config){
        $plugin = $this->createService($config);    
        $this->addPlugin($plugin);
    }
  
    /**
     * Adds a context instance to the services stack.
     * Note: Object instances registered with the included context will
     * overwrite any instance with the same id on the including context.
     * If you need a different behavior, please, make use
     * of an include-tag in your configuration before your main
     * configuration part. 
     * eg.:
     * <config>
     *    <include file="path/to/include/context/config.xml"/>
     *    <!-- main configuration -->
     * </config>     
     * 
     * @access public
     * @param XMLContext $config the config to include
     */    
    public function includeContext(XMLContext $context){
        $this->services = array_merge($this->services, $context->getServices());
    }

    /**
     * Creates and adds a context from file. 
     * 
     * @see XMLContext::includeContext
     * @access public
     * @param XMLContext $context the config to include
     */    
    public function includeContextFromFile($filePath){
        if(file_exists($filePath)){
            $this->includeContextFromString(file_get_contents($filePath));
        }           
    }

    /**
     * Creates and adds a context from string. 
     * 
     * @see XMLContext::includeContext
     * @access public
     * @param string $configString the config to include
     */    
    public function includeContextFromString($configString){
        $context = new XMLContext($configString);
        $this->includeContext($context);            
    }   
    
    /**
     * Creates a context instance from a config object and includes it. 
     * 
     * @see XMLContext::includeContext
     * @access protected
     * @param object $config the configuration for the context
     */    
    protected function createContext($config){
        if((string)$config['file'] != ''){
            $this->includeContextFromFile((string)$config['file']);
        }           
    }   
     

    public function getServiceProvider(){
        return isset($this->serviceProvider)
            ? $this->serviceProvider
            : $this->serviceProvider = new ServiceProvider();
    }

    /**
     * Registers the build-methods for the main-components with this context.
     * Note: This method and subsequent registered methods of this class are
     * candidates for refactoring. Because this class has grown much to large
     * and for better design and flexibility the core builder-methods should be
     * put into a core context-plugin. 
     * 
     * @see XMLContext::includeContext
     * @access protected
     */     
    protected function initNodeBuilders(){
        $builders = array(
            'include' => 'createContext',
            'plugin' => 'createPlugin',
            'channel' => 'createChannel',
            'publish_subscribe_channel' => 'createSubscribableChannel',
            'service' => 'initService',
            'service_activator' => 'createServiceActivator',
            'gateway' => 'createGateway',
            'splitter' => 'createSplitter',
            'transformer' => 'createTransformer',
            'router' => 'createRouter',
            'aggregator' => 'createAggregator',
            'wiretap' => 'createWiretap'
                
        );
        $plugin = new BasePlugin();
        $this->addPlugin($plugin); 
        foreach($builders as $nodeName => $method){
            $this->registerNodeBuilder($nodeName, array($this, $method));   
        }       
    }

    /**
     * Builds a specific configuration-node. Calls the build-method which
     * is registered with the node-name. If none is registered does nothing. 
     * 
     * @see XMLContext::doCreateChannel
     * @access protected
     * @param object $node configuration-node
     * @return void
     */
    protected function buildNode($node){
        $nodeName = $node->getName();
        // call the builder method registered for the node.
        if(array_key_exists($nodeName, $this->nodeBuilders)){
            call_user_func($this->nodeBuilders[$nodeName], $node);
        }           
    }
   
    /**
     * Resolves a channel-name and returns channel-instace if found.
     * Main purpose is to allow the context to act as a channel-resolver for 
     * mainly routers, hence implement the \PEIP\INF\Channel\ChannelResolver pattern.
     * Note: Channels are registerd globally in a registry per thread/process.
     * This allows to connect many context instances through channels without
     * coupling them by in a include in configuration.  
     * 
     * @see \PEIP\INF\Channel\ChannelResolver
     * @implements \PEIP\INF\Channel\ChannelResolver
     * @access public
     * @param string $channelName the name/id of the channel to return 
     * @return \PEIP\INF\Channel\Channel
     */
    public function resolveChannelName($channelName){
        return $this->channelRegistry->get($channelName);
    }   
     
    /**
     * returns a service for a given id
     * 
     * @implements \PEIP\INF\Context\Context
     * @access public
     * @param mixed $id the id for the service
     * @return object the service instance if found
     */
    public function getService($id){     
        return $this->getServiceProvider()->provideService($id);
    }
             
    /**
     * returns all registered services
     * 
     * @access public
     * @return array registered services
     */
    public function getServices(){    
        return $this->getServiceProvider()->getServices();
    }  
    
    /**
     * Checks wether a service with a given id is registered
     * 
     * @access public
     * @param mixed $id the id for the service 
     * @return boolean wether service is registered
     */
    public function hasService($id){
        return isset($this->services[$id]);
    }
      
    /**
     * Tries to receive a service for a given id.
     * Throws RuntimeException if no service is found
     * 
     * @access protected
     * @throws RuntimeException
     * @param mixed $id the id for the service 
     * @return object the service instance if found
     * 
     */
    protected function requestService($id){
        $service = $this->getService($id);
        if($service === NULL){
            throw new \RuntimeException('Service "'.$id.'" not found.');
        } 
        return $service;
    }
    
    /**
     * Creates and initializes service instance from a given configuration.
     * Registers instance if id is set in config.
     * 
     * @access protected
     * @param object $config 
     * @return object the initialized service instance
     */
    protected function initService($config){
        $id = trim((string)$config['id']);
        if($id != ''){
            return $this->services[$id] = $this->createService($config);    
        }   
    }
 
    /**
     * Creates and initializes service instance from a given configuration. 
     * 
     * @access public
     * @param $config 
     * @return object the initialized service instance
     */
    public function createService($config){
        return ServiceFactory::createService($config);      
    }
 
    /**
     * Modifies a service instance from configuration.
     *  - Sets properties on the instance.
     *  -- Calls a public setter method if exists.
     *  -- Else sets a public property if exists.
     *  - Calls methods on the instance.
     *  - Registers listeners to events on the instance
     * 
     * @access protected
     * @param object $service the service instance to modify 
     * @param object $config configuration to get the modification instructions from. 
     * @return object the modificated service
     */
    protected function modifyService($service, $config){ 
        // set instance properties
        if($config->property){          
            foreach($config->property as $property){                          
                $arg = $this->buildArg($property);
                if($arg){
                    $setter = self::getSetter($property);               
                    if($setter &&  self::hasPublicProperty($service, 'Method', $setter)){
                        $service->{$setter}($arg);  
                    }elseif(in_array($property, self::hasPublicProperty($service, 'Property', $setter))){
                        $service->$setter = $arg;
                    }                   
                }
            }
        }   
        // call instance methods
        if($config->action){            
            foreach($config->action as $action){
                $method = (string)$action['method'] != '' ? (string)$action['method'] : NULL;
                if($method && self::hasPublicProperty($service, 'Method', $method)){
                    $args = array(); 
                    foreach($action->children() as $argument){
                        $args[] = $this->buildArg($argument);
                    } 
                    call_user_func_array(array($service, (string)$action['method']), $args);
                }
            }
        }       
        // register instance listeners
        if($service instanceof \PEIP\INF\Event\Connectable){
            if($config->listener){
                foreach($config->listener as $listenerConf){
                    $event = (string)$listenerConf['event'];
                    $listener = $this->provideService($listenerConf);  
                    $service->connect($event, $listener);   
                }
            }
        }
        return $service;
    }   
      
    /**
     * returns gateway instance forgiven id.
     * the use of this method is deprecated. Use getService instead.
     * 
     * @deprecated 
     * @access public
     * @param mixed $id the id ofthe gateway 
     * @return object the gateway instance
     */
    public function getGateway($id){ 
        return $this->getServiceProvider()->provideService($id); 
    }   
  
    /**
     * Creates a pollable channel from a configuration object.
     * 
     * @see XMLContext::doCreateChannel
     * @access public
     * @param object $config configuration object for the pollable channel. 
     * @return \PEIP\INF\Channel\Channel the created pollable channel instance
     */
    public function createChannel($config){
        return $this->doCreateChannel($config, 'PollableChannel');        
    }
  
    /**
     * Creates a subscribable channel from a configuration object.
     * 
     * @see XMLContext::doCreateChannel
     * @access public
     * @param object $config configuration object for the subscribable channel. 
     * @return \PEIP\INF\Channel\Channel the created subscribable channel instance
     */
    public function createSubscribableChannel($config){
        return $this->doCreateChannel($config, 'PublishSubscribeChannel');       
    }   
   
    /**
     * Creates and registers arbitrary channel from a configuration object and additional information.
     * 
     * @access public
     * @param object $config configuration object for the channel. 
     * @param string $defaultChannelClass the channel class to use if none is set in config 
     * @param $additionalArguments additional arguments for the channel constructor (without first arg = id)
     * @return \PEIP\INF\Channel\Channel the created channel instance
     */
    public function doCreateChannel($config, $defaultChannelClass, array $additionalArguments = array()){
        $id = (string)$config['id'];
        if($id != ''){ 
            array_unshift($additionalArguments, $id);
            $channel = $this->buildAndModify($config, $additionalArguments, $defaultChannelClass);
            $this->channelRegistry->register($channel);
            return $channel;
        }
    }
       
    /**
     * Creates and registers gateway from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @access public
     * @param object $config configuration object for the gateway. 
     * @param string $defaultClass the class to use if none is set in config. 
     * @return object the gateway instance
     */
    public function createGateway($config, $defaultClass = false){
        $args = array(
            $this->getRequestChannel($config), 
            $this->getReplyChannel($config)
        );
        $defaultClass = $defaultClass ? $defaultClass : 'SimpleMessagingGateway';
        $gateway = $this->buildAndModify($config, $args, $defaultClass);
        $id = (string)$config["id"];
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
     * @access public
     * @param object $config configuration object for the gateway. 
     * @param string $defaultClass the class to use if none is set in config. 
     * @return object the router instance
     */
    public function createRouter($config, $defaultClass = false){
        $resolver = $config['channel_resolver'] ? (string)$config['channel_resolver'] : $this->channelRegistry;
        return $this->buildAndModify($config, array(
            $resolver,
            $this->doGetChannel('input', $config)
        ), $defaultClass);
    }

    /**
     * Creates and registers splitter from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     * @access public
     * @param object $config configuration object for the splitter. 
     * @return object the splitter instance
     */    
    public function createSplitter($config){
        return $this->createReplyMessageHandler($config);           
    }   
 
    /**
     * Creates and registers transformer from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     * @access public
     * @param object $config configuration object for the transformer. 
     * @return object the transformer instance
     */    
    public function createTransformer($config){
        return $this->createReplyMessageHandler($config);           
    } 
      
    /**
     * Creates aggregator from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     * @access public
     * @param object $config configuration object for the aggregator. 
     * @return object the aggregator instance
     */  
    public function createAggregator($config){
        return $this->createReplyMessageHandler($config);       
    }
  
    /**
     * Creates wiretap from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @see XMLContext::createReplyMessageHandler
     * @access public
     * @param object $config configuration object for the wiretap. 
     * @return object the wiretap instance
     */ 
    public function createWiretap($config){
        return $this->createReplyMessageHandler($config, 'Wiretap');       
    }
  
    /**
     * Creates a reply-message-handler from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @access public
     * @param object $config configuration object for the reply-message-handler. 
     * @param string $defaultClass the class to use if none is set in config.
     * @return object the reply-message-handler instance
     */ 
    public function createReplyMessageHandler($config, $defaultClass = false){
        return $this->buildAndModify($config, $this->getReplyHandlerArguments($config), $defaultClass); 
    }
    
    /**
     * Creates and registers service-activator from a configuration object.
     * 
     * @see XMLContext::initNodeBuilders
     * @access public
     * @param object $config configuration object for the service-activator. 
     * @param string $defaultClass the class to use if none is set in config. 
     * @return object the service-activator instance
     */
    public function createServiceActivator($config, $defaultClass = false){
        $method = (string)$config['method'];
        $service = $this->getService((string)$config['ref']);
        if($method && $service){        
            $args = $this->getReplyHandlerArguments($config);
            array_unshift($args,array(
                $service,
                $method             
            )); 
            $defaultClass = $defaultClass ? $defaultClass : 'ServiceActivator';
            return $this->buildAndModify($config, $args, $defaultClass);                
        }
    }   
    
    
    /**
     * Provides a service for a configuration object.
     * Returns reference to a service if configured, otherwise
     * creates new service instance.
     * 
     * @see XMLContext::getService
     * @see XMLContext::createService
     * @access protected
     * @param object $config configuration object for the service. 
     * @return 
     */
    protected function provideService($config){
        $ref = trim((string)$config['ref']);
        if($ref != ''){
            $service = $this->getService($ref); 
        }else{
            $service = $this->createService($config);
        }
        return $service;
    }

    /**
     * Utility method to return a (camel-cased) setter method-name for a property of a config-obect.
     * Returns setter-name if set in configuration, otherwise if name of property is set, returns
     * camel-cased setter-name build from property-name.
     * 
     * @see XMLContext::getService
     * @see XMLContext::createService
     * @access protected
     * @param object $config configuration object for the setter-method. 
     * @return string camel-cased 
     */    
    protected static function getSetter($config){
        if($config['setter']){
            $setter = (string)$config['setter'];
        }elseif($config['name']){
            $setter = 'set'.ucfirst((string)$config['name']);   
        }
        return $setter;     
    }
    
    /**
     * Builds single argument (to call a method with later) from a config-obect.
     * 
     * @access protected
     * @param object $config configuration object to create argument from.  
     * @return mixed build argument 
     */
    protected function buildArg($config){ 
        if(trim((string)$config['value']) != ''){
            $arg = (string)$config['value'];
        }elseif($config->getName() == 'value'){
            $arg = (string)$config;
        }elseif($config->getName() == 'list'){
            $arg = array();
            foreach($config->children() as $entry){ 
                if($entry->getName() == 'value'){
                    if($entry['key']){
                        $arg[(string)$entry['key']] = (string)$entry;   
                    }else{
                        $arg[] = (string)$entry;
                    }
                }elseif($entry->getName() == 'service'){
                    $arg[] = $this->provideService($entry);
                }
            }
        }elseif($config->getName() == 'service'){
            $arg = $this->provideService($config);
        }elseif($config->list){
            $arg = $this->buildArg($config->list);
        }elseif($config->service){
            $arg = $this->buildArg($config->service);
        } 
        return $arg; 
    }       

    
    /**
     * Utility method to create arguments for a reply-handler constructor from a config-obect.
     * 
     * @access protected
     * @param object $config configuration object to create arguments from.  
     * @return mixed build arguments 
     */
    protected function getReplyHandlerArguments($config){
        $args = array(
            $this->doGetChannel('input', $config),
            $this->doGetChannel('output', $config)
        );
        if($args[0] == NULL){
            throw new \RuntimeException('Could not receive input channel.');
        }
        return $args;
    }
    
    
    /**
     * Utility method to return a request-channel from a config-obect.
     * 
     * @see XMLContext::doGetChannel
     * @access protected
     * @param object $config configuration object to return request-channel from. 
     * @return \PEIP\INF\Channel\Channel request-channel
     */
    protected function getRequestChannel($config){
        return $this->doGetChannel('request', $config); 
    }
    
    
    /**
     * Utility method to return a reply-channel from a config-obect.
     * 
     * @see XMLContext::doGetChannel
     * @access protected
     * @param object $config configuration object to return reply-channel from. 
     * @return \PEIP\INF\Channel\Channel reply-channel
     */
    protected function getReplyChannel($config){
        return $this->doGetChannel('reply', $config);   
    }
    
    
    /**
     * Utility method to return a certainn channel from a config-obect.
     * 
     * @access protected
     * @param string the configuration type ofthe channel (e.g.: 'reply', 'request')
     * @param object $config configuration object to return channel from. 
     * @return \PEIP\INF\Channel\Channel reply-channel
     */
    public function doGetChannel($type, $config){
        $channelName = $config[$type."_channel"] 
            ? $config[$type."_channel"] 
            : $config["default_".$type."_channel"];
        return $this->serviceProvider->provideService(trim((string)$channelName));
        $channel =  $this->services[trim((string)$channelName)];
        if($channel instanceof \PEIP\INF\Channel\Channel){
            return $channel;    
        }else{
            return NULL;
        }       
    }

    
    /**
     * Builds and modifies an arbitrary service/object instance from a config-obect.
     * 
     * @see XMLContext::doBuild
     * @see XMLContext::modifyService
     * @implements \PEIP\INF\Context\Context
     * @access public
     * @param object $config configuration object to build a service instance from. 
     * @param array $arguments arguments for the service constructor 
     * @param string $defaultClass class to create instance for if none is set in config 
     * @return object build and modified srvice instance
     */
    public function buildAndModify($config, $arguments, $defaultClass = false){   
        return ServiceFactory::buildAndModify($config, $arguments, $defaultClass);
    }

    /**
     * Builds an arbitrary service/object instance from a config-obect.
     * 
     * @static
     * @access protected
     * @param object $config configuration object to build a service instance from. 
     * @param array $arguments arguments for the service constructor 
     * @param string $defaultClass class to create instance for if none is set in config 
     * @return object build and modified srvice instance
     */    
    protected static function doBuild($config, $arguments, $defaultClass = false){
        $cls = $config["class"] ? trim((string)$config["class"]) : (string)$defaultClass;
        if($cls != ''){
            try {
                $constructor = (string)$config["constructor"];
        if($constructor != ''){
            $service = call_user_func_array(array($cls, $constructor), $arguments); 
        }else{
            $service = self::build($cls, $arguments); 
        }        
            }catch(\Exception $e){
                throw new \RuntimeException('Could not create Service "'.$cls.'" -> '.$e->getMessage());
            }           
        }
        if(is_object($service)){
            return $service;
        }       
        throw new \RuntimeException('Could not create Service "'.$cls.'". Class does not exist.');           
    }   

    /**
     * Utility function to build an object instance for given class with given constructor-arguments.
     * 
     * @see GenericBuilder
     * @static
     * @access protected
     * @param object $className name of class to build instance for. 
     * @param array $arguments arguments for the constructor 
     * @return object build and modified srvice instance
     */     
    protected static function build($className, $arguments){
        return GenericBuilder::getInstance($className)->build($arguments);
    }

    protected static function hasPublicProperty($service, $type, $name){
        $reflection = GenericBuilder::getInstance(get_class($service))->getReflectionClass();
        if($reflection->{'has'.$type}($name) && $reflection->{'get'.$type}($name)->isPublic()){
                return true;
        }
        return false;
    }

} 
