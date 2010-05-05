<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Sealer 
 * Class to act as a implementation of the Selaer/Usealer pattern.
 * Used to give a reference to an arbitrary value without referencing the value itself.
 * By sealing an value the sealer will return a 'box'-object, which can later be used
 * to receive the sealed value. By passing an arbitrary object as second argument to the 
 * 'seal' method, any object can act as the 'box' for the sealed value.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements PEIP_INF_Sealer, PEIP_INF_Unsealer
 */

// PHP5.3

class PEIP_Sealer implements PEIP_INF_Sealer, PEIP_INF_Unsealer{

    protected $store;
      
    /**
     * constructor
     * 
     * @access public
     * @param SplObjectStorage $store an instane of SplObjectStorage to act as the internal object-store
     * @return 
     */
    public function __construct(SplObjectStorage $store = NULL){
        $this->store = (bool)$store ? $store : new SplObjectStorage;    
    }   
      
    /**
     * Seals a given value and returns a 'box' object as reference.
     * If method is called with an object instance as second argument,
     * the given object is used as the box. Otherwise a simple stdClass object
     * will be created as the 'box'.
     * 
     * @access public
     * @param mixed $value the value to seal. 
     * @param object $box an object to act as the 'box'  
     * @return object the 'box' for the sealed value
     */
    public function seal($value, $box = false){
        $box = (bool)$box ? $box : new stdClass;
        $this->store[$box] = $value;        
        return $box;
    }
  
    /**
     * Unseals and returns a value refernced by the given box-object. 
     * 
     * @access public
     * @param object $box the box-object to return the value for. 
     * @return 
     */
    public function unseal($box){
        return $this->store[$box];
    }
}
