<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Object_Map_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 */


interface PEIP_INF_Object_Map_Dispatcher {
        
    public function connect($name, $object, $listener);

    public function disconnect($name, $object, $listener);

    public function hasListeners($name, $object);
    
    public function getEventNames($object);

    public function notify($name, $object);
  
    public function getListeners($name, $object);   
    
}

