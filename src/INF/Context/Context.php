<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Context\Context 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage context 
 */



namespace PEIP\INF\Context;

interface Context {

    public function registerNodeBuilder($nodeName, $callable);
    
    public function getService($id);
    
    public function addPlugin(\PEIP\INF\Context\Context_Plugin $plugin);
    
    public function buildAndModify($config, $arguments, $defaultClass = false);

}