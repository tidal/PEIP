<?php

namespace PEIP\Event;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Event 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @extends \PEIP\Message\GenericMessage
 * @implements \PEIP\INF\Base\Buildable, \PEIP\INF\Message\Message, \PEIP\INF\Base\Container, \PEIP\INF\Event\Event
 */

use \PEIP\Message\GenericMessage;
use PEIP\Util\Test;

class Event 
    extends 
        \PEIP\Message\GenericMessage 
    implements 
        \PEIP\INF\Event\Event {
            
    protected
        $value      = null,
        $processed  = false,
        $subject    = null,
        $name       = '',
        $parameters = null,
        $type;

  
    /**
     * constructor
     * 
     * @access public
     * @param mixed $subject the subject for the event
     * @param string $name the name of the event
     * @param array|ArrayAccess $headers the headers for the event 
     */
    public function __construct($subject, $name, $parameters = array(), $type = false){
        parent::__construct($subject, Test::ensureArrayAccess($parameters));
        $this->name = $name;
        $this->type = $type ? $type : get_class($this);
    }
  
    /**
     * returns the name of the event
     * 
     * @access public
     * @return string the name of the event
     */
    public function getName(){
        return $this->name;
    }

    /**
     * returns the type of the event (Name of this Event-Class if no
     * event-type has been set in constructor)
     *
     * @access public
     * @return string the type of the event
     */
    public function getType(){
        return $this->type;
    }
  
    /**
     * sets the return-value of the event
     * 
     * @access public
     * @param mixed $value the return-value to set 
     */
    public function setReturnValue($value){
        $this->value = $value;
    }
  
    /**
     * returns the return-value of the event
     * 
     * @access public
     * @return mixed the return-value to set
     */
    public function getReturnValue(){
        return $this->value;
    }
  
    /**
     * sets wether the event is processed
     * 
     * @access public
     * @param boolean $processed 
     */
    public function setProcessed($processed){
        $this->processed = (boolean) $processed;
    }

    /**
     * checks wether the event is processed
     * 
     * @access public
     * @return boolean wether the event is processed 
     */
    public function isProcessed(){
        return $this->processed;
    }

    /**
     * Returns the subject/content of the container
     *
     * @access public
     * @return mixed the subject/content
     */
    public function getSubject(){
        return $this->getContent();
    }
}
    

