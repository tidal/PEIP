<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Context 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 */


interface PEIP_INF_Context {

    public function registerNodeBuilder($nodeName, $callable);
    
    public function getService($id);
    
    public function addPlugin(PEIP_INF_Context_Plugin $plugin);
    
    public function buildAndModify($config, $arguments, $defaultClass = false);

}