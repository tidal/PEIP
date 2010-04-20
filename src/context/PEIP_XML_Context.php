<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_XML_Context 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 * @implements PEIP_INF_Context, PEIP_INF_Channel_Resolver
 */


class PEIP_XML_Context 
    implements 
        PEIP_INF_Context,
        PEIP_INF_Channel_Resolver {

    protected 
        $services = array(),
        $configs = array(),
        $gateways = array(),
        $nodeBuilders = array(),
        $channelRegistry;
    
       
    /**
     * @access public
     * @param $xml 
     * @return 
     */
    public function __construct($xml){
        $this->simpleXML = new SimpleXMLIterator($xml);
        $this->initNodeBuilders();
        $this->init();
    }

    public static function createFromString($xml){
        return new PEIP_XML_Context($xml);
    }
    
    public static function createFromFile($file){
        if(file_exists($file)){
            return self::createFromString(file_get_contents($file));
        }else{
            throw new RuntimeException('Cannot open file  "'.$file.'".');
        }
    }

    
    /**
     * @access public
     * @param $nodeName 
     * @param $callable 
     * @return 
     */
    public function registerNodeBuilder($nodeName, $callable){
        $this->nodeBuilders[$nodeName] = $callable;     
    }

    
    /**
     * @access public
     * @param $plugin 
     * @return 
     */
    public function addPlugin(PEIP_INF_Context_Plugin $plugin){
        $plugin->init($this);   
    }

    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createPlugin($config){
        $plugin = $this->createService($config);    
        $this->addPlugin($plugin);
    }
    
    
    private function initNodeBuilders(){
        $builders = array(
            'plugin' => 'createPlugin',
            'channel' => 'createChannel',
            'publish_subscribe_channel' => 'createSubscribebalChannel',
            'service' => 'initService',
            'service_activator' => 'createServiceActivator',
            'gateway' => 'createGateway',
            'splitter' => 'createSplitter',
            'router' => 'createRouter',
            'aggregator' => 'createAggregator',
            'wiretap' => 'createWiretap'
                
        );
        foreach($builders as $nodeName => $method){
            $this->registerNodeBuilder($nodeName, array($this, $method));   
        }       
    }

    /**
     * @static
     * @access protected
     * @param $className 
     * @param $arguments 
     * @return 
     */
    protected function buildNode($node){
        $nodeName = $node->getName();
        if(array_key_exists($nodeName, $this->nodeBuilders)){
            call_user_func($this->nodeBuilders[$nodeName], $node);
        }           
    }
     
    /**
     * @access protected
     * @return 
     */
    protected function init(){
        $xml = $this->simpleXML;
        $this->channelRegistry = PEIP_Channel_Registry::getInstance();
        if($xml['id']){
            $this->services[(string)$xml['id']] = $this;    
        }
        foreach($xml->children() as $entry){
            $this->buildNode($entry);
        }
    }
   
    /**
     * @access public
     * @param $channelName 
     * @return 
     */
    public function resolveChannelName($channelName){
        return $this->channelRegistry->get($channelName);
    }   
    
    
    /**
     * @access public
     * @param $id 
     * @return 
     */
    public function getService($id){    
        return $this->hasService($id)  
            ? $this->services[$id]
            : NULL;
    }

    
    /**
     * @access public
     * @param $id 
     * @return 
     */
    public function hasService($id){
        return isset($this->services[$id]);
    }
    
    
    /**
     * @access protected
     * @param $id 
     * @return 
     */
    protected function requestService($id){
        $service = $this->getService($id);
        if($service === NULL){
            throw new RuntimeException('Service "'.$id.'" not found.');
        } 
        return $service;
    }
    
    /**
     * @access protected
     * @param $config 
     * @return 
     */
    protected function initService($config){
        $id = trim((string)$config['id']);
        if($id != ''){
            return $this->services[$id] = $this->createService($config);    
        }   
    }

                
    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createService($config){
        $args = array();
        if($config->constructor_arg){
            foreach($config->constructor_arg as $arg){
                $args[] = $this->buildArg($arg);
            }
        }
        return $this->buildAndModify($config, $args);        
    }

    
    /**
     * @access protected
     * @param $service 
     * @param $config 
     * @return 
     */
    protected function modifyService($service, $config){
        if($config->property){          
            foreach($config->property as $property){
                $setter = self::getSetter($property);
                if($setter){                
                    $arg = $this->buildArg($property);
                    if($arg){
                        $service->{$setter}($arg);  
                    }
                }
            }
        }   
        if($config->action){            
            foreach($config->action as $action){
                if($action['method'] && method_exists($service, (string)$action['method'])){
                    $args = array();
                    foreach($action->children() as $argument){ print_r($argument);
                        $args[] = $this->buildArg($argument);
                    }
                    call_user_func_array(array($service, (string)$action['method']), $args);
                }
            }
        }       
        if($service instanceof PEIP_INF_Connectable){
            if($config->listener){
                foreach($config->listener as $listenerConf){
                    $event = (string)$listenerConf['event'];
                    $listener = $this->provideService($config);  
                    $service->connect($event, $listener);   
                }
            }
        }
        return $service;
    }   
    
    
    /**
     * @access public
     * @param $id 
     * @return 
     */
    public function getGateway($id){
        return $this->gateways[$id];
    }   

    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createChannel($config){
        return $this->doCreateChannel($config, 'PEIP_Pollable_Channel');        
    }

    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createSubscribebalChannel($config){
        return $this->doCreateChannel($config, 'PEIP_Publish_Subscribe_Channel');       
    }   

    
    /**
     * @access public
     * @param $config 
     * @param $defaultChannel 
     * @param $additionalArguments 
     * @return 
     */
    public function doCreateChannel($config, $defaultChannel, array $additionalArguments = array()){
        $id = (string)$config['id'];
        if($id != ''){
            array_unshift($additionalArguments, $id);
            $channel = $this->buildAndModify($config, array($id), $defaultChannel);
            $this->channelRegistry->register($channel);
            return $channel;
        }
    }
    
    
    
    /**
     * @access public
     * @param $config 
     * @param $defaultClass 
     * @return 
     */
    public function createGateway($config, $defaultClass = false){
        $args = array(
            $this->getRequestChannel($config), 
            $this->getReplyChannel($config)
        );
        $defaultClass = $defaultClass ? $defaultClass : 'PEIP_Simple_Messaging_Gateway';
        $gateway = $this->buildAndModify($config, $args, $defaultClass);
        $id = (string)$config["id"];
        $this->gateways[$id] = $gateway;
        return $gateway;    
    }

    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createRouter($config){
        $resolver = $config['channel_resolver'] ? (string)$config['channel_resolver'] : $this->channelRegistry;
        return $this->buildAndModify($config, array(
            $resolver,
            $this->doGetChannel('input', $config)
        ));
    }
    
    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createSplitter($config){
        return $this->createReplyMessageHandler($config);           
    }   
    
    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createAggregator($config){
        return $this->createReplyMessageHandler($config);       
    }

    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    public function createWiretap($config){
        return $this->createReplyMessageHandler($config, 'PEIP_Wiretap');       
    }

    
    /**
     * @access public
     * @param $config 
     * @param $defaultClass 
     * @return 
     */
    public function createReplyMessageHandler($config, $defaultClass = false){
        return $this->buildAndModify($config, $this->getReplyHandlerArguments($config), $defaultClass); 
    }
    
    
    
    /**
     * @access public
     * @param $config 
     * @return 
     */
    
    /**
     * @access public
     * @param $config 
     * @param $defaultClass 
     * @return 
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
            $defaultClass = $defaultClass ? $defaultClass : 'PEIP_Service_Activator';
            return $this->buildAndModify($config, $args, $defaultClass);                
        }
    }   
    
    
    /**
     * @access protected
     * @param $config 
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
       
    protected static function getSetter($config){
        if($config['setter']){
            $setter = (string)$config['setter'];
        }elseif($config['name']){
            $setter = 'set'.ucfirst((string)$config['name']);   
        }
        return $setter;     
    }
    
    /**
     * @static
     * @access protected
     * @param $className 
     * @param $arguments 
     * @return 
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
     * @access protected
     * @param $config 
     * @return 
     */
    protected function getReplyHandlerArguments($config){
        $args = array(
            $this->doGetChannel('input', $config),
            $this->doGetChannel('output', $config)
        );
        if($args[0] == NULL){
            throw new RuntimeException('Could not receive input channel.');
        }
        return $args;
    }
    
    
    /**
     * @access protected
     * @param $config 
     * @return 
     */
    protected function getRequestChannel($config){
        return $this->doGetChannel('request', $config); 
    }
    
    
    /**
     * @access protected
     * @param $config 
     * @return 
     */
    protected function getReplyChannel($config){
        return $this->doGetChannel('reply', $config);   
    }
    
    
    /**
     * @access public
     * @param $type 
     * @param $config 
     * @return 
     */
    public function doGetChannel($type, $config){
        $channelName = $config[$type."_channel"] 
            ? $config[$type."_channel"] 
            : $config["default_".$type."_channel"]; 
        $channel =  $this->services[trim((string)$channelName)];
        if($channel instanceof PEIP_INF_Channel){
            return $channel;    
        }else{
            return NULL;
        }       
    }

    
    /**
     * @access public
     * @param $config 
     * @param $arguments 
     * @param $defaultClass 
     * @return 
     */
    public function buildAndModify($config, $arguments, $defaultClass = false){
    	if($config["class"]  || $defaultClass){
        	 $service = self::doBuild($config, $arguments, $defaultClass);	
        }elseif($config["ref"]){
        	$service = $this->getService((string)$config['ref']);
        }else{
        	throw new RuntimeException('Could not create Service. no class or reference given.');
        }
		if($config["ref_property"]){
			$service = $service->{(string)$config["ref_property"]};	
		}elseif($config["ref_method"]){
			$service = $service->{(string)$config["ref_method"]}();	
		}       
        if(!is_object($service)){
        	throw new RuntimeException('Could not create Service.'); 
        }
    	$service = $this->modifyService($service, $config);
        $id = trim((string)$config['id']);
        if($service && $id != ''){
            $this->services[$id] = $service;    
        }
        return $service;
    }
    
    protected static function doBuild($config, $arguments, $defaultClass = false){
        $cls = $config["class"] ? trim((string)$config["class"]) : (string)$defaultClass;
        if($cls != ''){
            try {
                $service = self::build($cls, $arguments);       
            }catch(Exception $e){
                throw new RuntimeException('Could not create Service "'.$cls.'" -> '.$e->getMessage());
            }           
        }
        if(is_object($service)){
        	return $service;
        }       
        throw new RuntimeException('Could not create Service "'.$cls.'". Class does not exist.');           
    }   
    
    protected static function build($className, $arguments){
        return PEIP_Generic_Builder::getInstance($className)->build($arguments);
    }


} 