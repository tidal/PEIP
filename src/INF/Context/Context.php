<?php

namespace PEIP\INF\Context;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
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



interface Context {

    public function registerNodeBuilder($nodeName, $callable);
    
    public function getService($id);
    
    public function addPlugin(\PEIP\INF\Context\Context_Plugin $plugin);
    
    public function buildAndModify($config, $arguments, $defaultClass = false);

}