<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Connectable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */


interface PEIP_INF_Connectable {

    public function connect($name, PEIP_INF_Handler $listener);
    
    public function disconnect($name, PEIP_INF_Handler $listener);
    
    public function hasListeners($name);
    
    public function getListeners($name);
    
}