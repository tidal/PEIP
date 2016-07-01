<?php

namespace PEIP\ABS\Context;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Context\ContextPlugin 
 * Abstract base class for all context plugins.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 * @implements \PEIP\INF\Context\ContextPlugin
 */

use PEIP\Context\XMLContext;
use PEIP\Factory\ServiceFactory;

abstract class ContextPlugin 
    implements \PEIP\INF\Context\ContextPlugin {

    protected $context;

    protected $builders = array();

    //protected static $builders = array();
      
    /**
     * Initializes the plugin with given context.
     * Registers node-builders of the plugin in with the given context.
     * 
     * @access public
     * @param \PEIP\INF\Context\Context $context context instance to register the plugin with
     * @return 
     */
    public function init(\PEIP\INF\Context\Context $context){
        $this->context = $context;
        foreach($this->builders as $node=>$method){
            $context->registerNodeBuilder($node, array($this, $method));        
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
}
