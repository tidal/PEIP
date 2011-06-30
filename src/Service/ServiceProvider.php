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
use
    \PEIP\Constant\Event,
    \PEIP\Constant\Header,
    \PEIP\Plugins\BasePlugin;

class ServiceProvider 
    extends \PEIP\Service\ServiceContainer
    implements \PEIP\INF\Service\ServiceProvider {

    protected
        $config = array(),
        $ids = array(),
        $nodeBuilders = array(),
        $idAttribute;

    public function  __construct(array $config = array(), $idAttribute = 'id') {
        $this->idAttribute = $idAttribute;
        $this->initNodeBuilders();
        foreach($config as $serviceConfig){
            $this->addConfig($serviceConfig);
        }
        
    }
    /**
     * returns all registered services
     *
     * @access public
     * @return array registered services
     */
    public function getServices(){
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
    protected function initNodeBuilders(){ return;
        $builders = array(
            'service' => 'initService'
        );
        $plugin = new BasePlugin();
        foreach($builders as $nodeName => $method){
           $this->registerNodeBuilder($nodeName, array($this, $method));
        }
    }

    public function addConfig($config){ 
        $this->doFireEvent(
            Event::BEFORE_ADD_CONFIG,
            array(
                Header::NODE_CONFIG=>$config
            )
        );
        $countConfig    = $this->doAddConfig($config);
        $id             = $this->doRegisterConfig($config);
        $this->doFireEvent(
            Event::AFTER_ADD_CONFIG,
            array(
                Header::NODE_CONFIG=>  $config,
                Header::NODE_ID=>      $id,
                Header::COUNT_CONFIG=> $countConfig
            )
        );
        return $id;

    }

    public function provideService($id){
        $this->doFireEvent(Event::BEFORE_PROVIDE_SERVICE, array(
            Header::KEY=>$id)
        );

        if($this->hasService($id)){ 
            $service =  $this->getService($id);
        }else{
            $service =  $this->createService($id);
        }

        $this->doFireEvent(Event::AFTER_PROVIDE_SERVICE, array(
            Header::KEY=>$id,
            Header::SERVICE=>$service)
        );

        return $service;
    }

    protected function createService($id){
        $this->doFireEvent(Event::BEFORE_CREATE_SERVICE, array(
            Header::KEY=>$id)
        );
        $errorMessage = '';
        $config = $this->getServiceConfig($id);

        if($config){
            $node = $this->buildNode($config);
            if($node){
                $this->setService(
                    $id,
                    $node
                );
                $this->doFireEvent(Event::CREATE_SERVICE_SUCCESS, array(
                    Header::KEY=>$id,
                    Header::SERVICE=>$node
                ));

                return $node;                
            }else{
                $errorMessage = 'COULD NOT BUILD NODE FOR KEY: '.$id;
            }

        }else{
            $errorMessage = 'NO CONFIG FOR KEY: '.$id;
        }
        $this->doFireEvent(Event::CREATE_SERVICE_ERROR, array(
            Header::KEY=>$id,
            Header::MESSAGE=>$errorMessage)
        );
        return NULL;
    }

    public function getServiceConfig($id){
        if(!isset($this->ids[$id])){
            return false;
        }
        return $this->config[$this->ids[$id]];
    }


    /**
     * Builds a specific configuration-node. Calls the build-method which
     * is registered with the node-name. If none is registered does nothing.
     *
     * @access protected
     * @param object $config configuration-node
     * @return void
     */
    protected function buildNode($config){
        $nodeName = (string)$config['type'];

        $this->doFireEvent(Event::BEFORE_BUILD_NODE, array(
            Header::NODE_CONFIG=>$config,
            Header::NODE_NAME=> $nodeName
        ));

        // call the builder method registered for the node.
        if(array_key_exists($nodeName, $this->nodeBuilders)){
            $nodeInstance = call_user_func($this->nodeBuilders[$nodeName], $config);
        }else{
            $factory = new \PEIP\Factory\ServiceFactory($this);
            $nodeInstance = $factory->createService($config);
        }


            //$nodeInstance = call_user_func($this->nodeBuilders[$nodeName], $config);
            if(is_object($nodeInstance)){
                $this->doFireEvent(Event::BUILD_NODE_SUCCESS, array(
                    Header::NODE_CONFIG=>$config,
                    Header::NODE_NAME=> $nodeName,
                    Header::NODE => $nodeInstance
                ));
                return $nodeInstance;
            }else{
                $errorMessage = 'BUILDER RETURNED NO OBJECT FOR NODE-TYPE: '.$nodeName;
            }
        

        $this->doFireEvent(Event::BUILD_NODE_ERROR, array(
            Header::NODE_CONFIG=>$config,
            Header::NODE_NAME=>$nodeName,
            Header::MESSAGE=>$errorMessage
        ));
    }

    protected function getIdFromConfig($config){
        $id = '';
        if(isset($config[$this->idAttribute])){
            $id = trim((string)($config[$this->idAttribute]));
        }
        return $id;
    }

    protected function getCountConfig(){
        return count($this->config);
    }

    protected function doAddConfig($config){
        $countConfig = $this->getCountConfig();
        $this->config[$countConfig] = $config;
        return $countConfig;
    }

    protected function doRegisterConfig($config){
        $id  = $this->getIdFromConfig($config);
        if($id != ''){
            $this->ids[$id] = $this->getCountConfig() - 1;
        }
        return $id;
    }
}

