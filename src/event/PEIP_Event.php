<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Event 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @extends PEIP_Generic_Message
 * @implements PEIP_INF_Buildable, PEIP_INF_Message, PEIP_INF_Container, PEIP_INF_Event
 */




class PEIP_Event 
    extends 
        PEIP_Generic_Message 
    implements 
        PEIP_INF_Event {
            
    protected
        $value      = null,
        $processed  = false,
        $subject    = null,
        $name       = '',
        $parameters = null;

  
    /**
     * constructor
     * 
     * @access public
     * @param mixed $subject the subject for the event
     * @param string $name the name of the event
     * @param array|ArrayAccess $headers the headers for the event 
     */
    public function __construct($subject, $name, $parameters = array()){
    	if(is_array($parameters)){
    		$parameters = new ArrayObject($parameters);	
    	}elseif(!($parameters instanceof ArrayAccess)){
    		throw new InvalidArgumentException('third parameter for PEIP_Event::__construct must either be array or implement ArrayAccess');
    	}    	
    	parent::__construct($subject, $parameters);
    	$this->name = $name;
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

}
    

