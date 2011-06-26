<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Event\Listener 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */



namespace PEIP\INF\Event;

interface Listener {

    public function listen(\PEIP\INF\Event\Connectable $connectable);
    
    public function unlisten(\PEIP\INF\Event\Connectable $connectable);

    public function getConnected();
    
}