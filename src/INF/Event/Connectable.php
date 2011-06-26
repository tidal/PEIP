<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Event\Connectable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */



namespace PEIP\INF\Event;

interface Connectable {

    public function connect($name, $listener);
    
    public function disconnect($name, $listener);

    public function disconnectAll($name);
    
    public function hasListeners($name);
    
    public function getListeners($name);
    
}