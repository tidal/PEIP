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
     * @access public
     * @param $context 
     * @return 
     */
    public function init(PEIP_INF_Context $context){
        $this->context = $context;
        foreach(static::$builders as $node=>$method){
            $context->registerNodeBuilder($node, array($this, $method));        
        }   
    }

}
