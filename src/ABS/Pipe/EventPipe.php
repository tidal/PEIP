<?php

namespace PEIP\ABS\Pipe;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP\ABS\Pipe\EventPipe 
 * Abstract base class for all event handling Pipes.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage pipe 
 * @extends \PEIP\Pipe\Pipe
 * @abstract
 * @implements \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */

use \PEIP\Pipe\Pipe;

abstract class EventPipe  
    extends \PEIP\Pipe\Pipe {
   
    protected 
        $connections = array(); 
            
    /**
     * Connects the event-pipe to a given \PEIP\INF\Event\Connectable instance by listening
     * to a given event on the connectable.
     * 
     * @access protected
     * @param string $eventName name of the event to listen to 
     * @param \PEIP\INF\Event\Connectable $connectable instance of \PEIP\INF\Event\Connectable to listen to 
     */
    protected function doListen($eventName, \PEIP\INF\Event\Connectable $connectable){
        if(!$connectable->hasListener($eventName, $this)){
            $connectable->connect($eventName, $this);
            $this->connections[spl_object_hash($connectable)] = $connectable;   
        }   
    }
        
    /**
     * Disonnects the event-pipe from listening to a given event on a \PEIP\INF\Event\Connectable instance.
     * 
     * @access protected
     * @param string $eventName name of the event to unlisten 
     * @param \PEIP\INF\Event\Connectable $connectable instance of \PEIP\INF\Event\Connectable to unlisten to 
     */
    protected function doUnlisten($eventName, \PEIP\INF\Event\Connectable $connectable){
        if(!$connectable->hasListener($eventName, $this)){
            $connectable->disconnect($eventName, $this);
            unset($this->connections[spl_object_hash($connectable)]);   
        }   
    }
   
    /**
     * Returns the instances of \PEIP\INF\Event\Connectable the event-pipe is litening to
     * 
     * @access public
     * @return array array of \PEIP\INF\Event\Connectable instances
     */
    public function doGetConnected(){
        return array_values($this->connections);
    }
    
}