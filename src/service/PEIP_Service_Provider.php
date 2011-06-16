<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_Service_Provider
 *
 * @author timo
 */
class PEIP_Service_Provider extends PEIP_Service_Container  {

    const
        /* Headers */
        HEADER_KEY                      = 'KEY',
        HEADER_SERVICE                  = 'SERVICE',
        HEADER_MESSAGE                  = 'MESSAGE',
        HEADER_NODE                     = 'NODE',
        HEADER_NODE_CONFIG              = 'NODE_CONFIG',
        HEADER_NODE_NAME                = 'NODE_NAME',
        /* Events */
        EVENT_BEFORE_BUILD_NODE         = 'before_build_node',
        EVENT_BUILD_NODE_SUCCESS        = 'success_build_node',
        EVENT_BUILD_NODE_ERROR          = 'error_build_node',
        EVENT_BEFORE_ADD_CONFIG         = 'before_add_config',
        EVENT_AFTER_ADD_CONFIG          = 'after_add_config',
        EVENT_BEFORE_PROVIDE_SERVICE    = 'before_provide_service',
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
     * Builds a specific configuration-node. Calls the build-method which
     * is registered with the node-name. If none is registered does nothing.
     *
     * @see PEIP_XML_Context::doCreateChannel
     * @access protected
     * @param object $node configuration-node
     * @return void
     */
    protected function buildNode($node){
        $nodeName = $node->getName();

        $this->doFireEvent(self::EVENT_BEFORE_BUILD_NODE, array(
            self::HEADER_NODE_CONFIG=>$node,
            self::HEADER_NODE_NAME=> $nodeName
        ));
        // call the builder method registered for the node.
        if(array_key_exists($nodeName, $this->nodeBuilders)){

            $nodeInstance = call_user_func($this->nodeBuilders[$nodeName], $node);
            if($nodeInstance){
                 $this->doFireEvent(self::EVENT_BUILD_NODE_SUCCESS, array(
                    self::HEADER_NODE_CONFIG=>$node,
                    self::HEADER_NODE_NAME=> $nodeName,
                    self::HEADER_NODE => $nodeInstance
                ));
            }
            return $nodeInstance;
        }
        
        $this->doFireEvent(self::EVENT_BUILD_NODE_ERROR, array(
            self::HEADER_NODE_CONFIG=>$node,
            self::HEADER_NODE_NAME=> $nodeName
        ));
    }
        /**
     * Registers a callable as builder for given node-name
     *
     * @implements PEIP_INF_Context
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
     * @see PEIP_XML_Context::includeContext
     * @access protected
     */
	protected function initNodeBuilders(){ return;
        $builders = array(
            'service' => 'initService'
        );
        $plugin = new PEIP_Base_Plugin();
        foreach($builders as $nodeName => $method){
           $this->registerNodeBuilder($nodeName, array($this, $method));
        }
    }

    public function addConfig( $config){ 
        $this->doFireEvent(self::EVENT_BEFORE_ADD_CONFIG, array(self::HEADER_NODE_CONFIG=>$config));
        $countConfig = count($this->config);
        $this->config[$countConfig] = $config;
        $id = trim((string)($config[$this->idAttribute]));
        if($id != ''){
            $this->ids[$id] = $countConfig;
        }
        $this->doFireEvent(self::EVENT_AFTER_ADD_CONFIG, array(
            self::HEADER_NODE_CONFIG=>$config)
        );
    }

    public function provideService($key){
        $this->doFireEvent('before_provide_service', array(
            self::HEADER_KEY=>$key)
        );
        if($this->hasService($key)){
            return $this->getService($key);
        }

        return $this->createService($key);
    }

    protected function createService($key){
        $this->doFireEvent('before_create_service', array(
            self::HEADER_KEY=>$key)
        );

        $config = $this->getServiceConfig($key);

        if($config){
            $node = self::buildNode($config);
            $this->setService(
                $key,
                $node
            );
            $this->doFireEvent(self::EVENT_CREATE_SERVICE_SUCCESS, array(
                self::HEADER_KEY=>$key,
                self::HEADER_SERVICE=>$node
            ));

            return $node;
        } 
        $this->doFireEvent(self::EVENT_CREATE_SERVICE_ERROR, array(
            self::HEADER_KEY=>$key,
            self::HEADER_MESSAGE=>'NO CONFIG FOR KEY: '.$key)
        );
        return NULL;
    }

    public function getServiceConfig($key){
        if(!isset($this->ids[$key])){
            return false;
        }
        return $this->config[$this->ids[$key]];
    }


    //put your code here
}

