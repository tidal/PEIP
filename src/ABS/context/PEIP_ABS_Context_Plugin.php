<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_ABS_Context_Plugin 
 * Abstract base class for all context plugins.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 * @implements PEIP_INF_Context_Plugin
 */

abstract class PEIP_ABS_Context_Plugin 
    implements PEIP_INF_Context_Plugin {

    protected $context;
    
    protected static $builders = array();
      
    /**
     * Initializes the plugin with given context.
     * Registers node-builders of the plugin in with the given context.
     * 
     * @access public
     * @param PEIP_INF_Context $context context instance to register the plugin with
     * @return 
     */
    public function init(PEIP_INF_Context $context){
        $this->context = $context;
        foreach(static::$builders as $node=>$method){
            $context->registerNodeBuilder($node, array($this, $method));        
        }   
    }

}
