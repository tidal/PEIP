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
     * @access public
     * @param $subject 
     * @param $name 
     * @param $parameters 
     * @return 
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
     * @access public
     * @return 
     */
    public function getName(){
    	return $this->name;
  	}

  
    /**
     * @access public
     * @param $value 
     * @return 
     */
    public function setReturnValue($value){
    	$this->value = $value;
  	}
  
    /**
     * @access public
     * @return 
     */
    public function getReturnValue(){
    	return $this->value;
  	}
  
    /**
     * @access public
     * @param $processed 
     * @return 
     */
    public function setProcessed($processed){
    	$this->processed = (boolean) $processed;
  	}

    /**
     * @access public
     * @return 
     */
    public function isProcessed(){
    	return $this->processed;
  	}

}
    

