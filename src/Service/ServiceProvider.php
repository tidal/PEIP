<?php

namespace PEIP\Service;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServiceProvider
 *
 * @author timo
 */
use PEIP\Context\XMLContext;

class ServiceProvider extends \PEIP\Service\ServiceContainer {

    const
        /* Headers */
        HEADER_KEY                      = 'KEY',
        HEADER_SERVICE                  = 'SERVICE',
        HEADER_MESSAGE                  = 'MESSAGE',
        HEADER_NODE                     = 'NODE',
        HEADER_NODE_CONFIG              = 'NODE_CONFIG',
        HEADER_NODE_NAME                = 'NODE_NAME',
        HEADER_NODE_ID                  = 'NODE_ID',
        HEADER_COUNT_CONFIG             = 'COUNT_CONFIG',
        /* Events */
        EVENT_BEFORE_BUILD_NODE         = 'before_build_node',
        EVENT_BUILD_NODE_SUCCESS        = 'success_build_node',
        EVENT_BUILD_NODE_ERROR          = 'error_build_node',
        EVENT_BEFORE_ADD_CONFIG         = 'before_add_config',
        EVENT_AFTER_ADD_CONFIG          = 'after_add_config',
        EVENT_BEFORE_PROVIDE_SERVICE    = 'before_provide_service',
        EVENT_AFTER_PROVIDE_SERVICE     = 'after_provide_service',
        EVENT_BEFORE_CREATE_SERVICE     = 'before_create_service',
        EVENT_CREATE_SERVICE_SUCCESS    = 'success_create_service',
        EVENT_CREATE_SERVICE_ERROR      = 'error_create_service';

    protected
        $config = array(),
        $ids = array(),
        $nodeBuilders = array(),
        $idAttribute;

    public function  __construct(array $config = array(), $idAttribute = 'id') {
        $this->idAttribute = $idAttribute;
        $this->initNodeBuilders();
        foreach ($config as $serviceConfig) {
            $this->addConfig($serviceConfig);
        }
        
    }
    /**
     * returns all registered services
     *
     * @access public
     * @return array registered services
     */
    public function getServices() {
        return $this->services;
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
        $this->nodeBuilders[$nodeName] = $callable;
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
            'service' => 'initService'
        );
        foreach($builders as $nodeName => $method){
            $this->registerNodeBuilder($nodeName, array($this, $method));
        }
    }

    public function addConfig($config){ 
        $this->doFireEvent(
            self::EVENT_BEFORE_ADD_CONFIG,
            array(
                self::HEADER_NODE_CONFIG=>$config
            )
        );
        $countConfig    = $this->doAddConfig($config);
        $id             = $this->doRegisterConfig($config);
        $this->doFireEvent(
            self::EVENT_AFTER_ADD_CONFIG,
            array(
                self::HEADER_NODE_CONFIG=>$config,
                self::HEADER_NODE_ID=>$id,
                self::HEADER_COUNT_CONFIG=>$countConfig
            )
        );
    }

    public function provideService($key) {
        $this->doFireEvent(self::EVENT_BEFORE_PROVIDE_SERVICE, array(
            self::HEADER_KEY=>$key)
        );

        if ($this->hasService($key)) {
            $service = $this->getService($key);
        }else {
            $service = $this->createService($key);
        }

        $this->doFireEvent(self::EVENT_AFTER_PROVIDE_SERVICE, array(
            self::HEADER_KEY=>$key,
            self::HEADER_SERVICE=>$service)
        );

        return $service;
    }

    protected function createService($key) {
        $this->doFireEvent(self::EVENT_BEFORE_CREATE_SERVICE, array(
            self::HEADER_KEY=>$key)
        );
        $errorMessage = '';
        $config = $this->getServiceConfig($key);

        if ($config) {
            $node = $this->buildNode($config);
            if ($node) {
                $this->setService(
                    $key,
                    $node
                );
                $this->doFireEvent(self::EVENT_CREATE_SERVICE_SUCCESS, array(
                    self::HEADER_KEY=>$key,
                    self::HEADER_SERVICE=>$node
                ));

                return $node;                
            }else {
                $errorMessage = 'COULD NOT BUILD NODE FOR KEY: '.$key;
            }

        }else {
            $errorMessage = 'NO CONFIG FOR KEY: '.$key;
        }
        $this->doFireEvent(self::EVENT_CREATE_SERVICE_ERROR, array(
            self::HEADER_KEY=>$key,
            self::HEADER_MESSAGE=>$errorMessage)
        );
        return NULL;
    }

    public function getServiceConfig($key) {
        if (!isset($this->ids[$key])) {
            return false;
        }
        return $this->config[$this->ids[$key]];
    }


    /**
     * Builds a specific configuration-node. Calls the build-method which
     * is registered with the node-name. If none is registered does nothing.
     *
     * @access protected
     * @param object $config configuration-node
     * @return void
     */
    protected function buildNode($config) {
        $nodeName = (string)$config['type'];

        $this->doFireEvent(self::EVENT_BEFORE_BUILD_NODE, array(
            self::HEADER_NODE_CONFIG=>$config,
            self::HEADER_NODE_NAME=> $nodeName
        ));
        // call the builder method registered for the node.
        if (array_key_exists($nodeName, $this->nodeBuilders)) {

            $nodeInstance = call_user_func($this->nodeBuilders[$nodeName], $config);
            if (is_object($nodeInstance)) {
                $this->doFireEvent(self::EVENT_BUILD_NODE_SUCCESS, array(
                    self::HEADER_NODE_CONFIG=>$config,
                    self::HEADER_NODE_NAME=> $nodeName,
                    self::HEADER_NODE => $nodeInstance
                ));
                return $nodeInstance;
            }else {
                $errorMessage = 'BUILDER RETURNED NO OBJECT FOR NODE-TYPE: '.$nodeName;
            }
        }else {
            $errorMessage = 'NO BUILDER FOUND FOR NODE-TYPE: '.$nodeName;
        }

        $this->doFireEvent(self::EVENT_BUILD_NODE_ERROR, array(
            self::HEADER_NODE_CONFIG=>$config,
            self::HEADER_NODE_NAME=>$nodeName,
            self::HEADER_MESSAGE=>'COULD NOT BUILD NODE: '.$errorMessage
        ));
    }

    protected function getIdFromConfig($config) {
        $id = '';
        if (isset($config[$this->idAttribute])) {
            $id = trim((string)($config[$this->idAttribute]));
        }
        return $id;
    }

    protected function getCountConfig() {
        return count($this->config);
    }

    protected function doAddConfig($config) {
        $countConfig = $this->getCountConfig();
        $this->config[$countConfig] = $config;
        return $countConfig;
    }

    protected function doRegisterConfig($config) {
        $id = $this->getIdFromConfig($config);
        if ($id != '') {
            $this->ids[$id] = $this->getCountConfig() - 1;
        }
        return $id;
    }
}

