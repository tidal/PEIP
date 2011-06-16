<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Observable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements PEIP_INF_Observable
 */



class PEIP_Observable implements PEIP_INF_Observable {

    protected $observedObject;
    
    protected $observers = array();

    protected $hasChanged = false;
    
    
    /**
     * @access public
     * @param $observedObject 
     * @return 
     */
    public function __construct(object $observedObject){
        $this->observedObject = $observedObject;
    }

    
    /**
     * @access public
     * @param $observer 
     * @return 
     */
    public function addObserver(PEIP_INF_Observer $observer){
        $this->observers[] = $observer;     
    }

    
    /**
     * @access public
     * @param $observer 
     * @return 
     */
    public function deleteObserver(PEIP_INF_Observer $observer){
        foreach($this->observers as $key=>$obs){
            if($obs == $observer){
                unset($this->observers[$key]);
                return true;
            }
        }
    }
    
    
    /**
     * @access public
     * @param $arguments 
     * @return 
     */
    public function notifyObservers(array $arguments = array()){
        if($this->hasChanged()){
            foreach($this->observers as $observer){
                $observer->update($this->observedObject);
            }       
        }
    }

    
    /**
     * @access public
     * @return 
     */
    public function countObservers(){
        return count($this->obeservers);
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function hasChanged(){
        return $this->hasChanged();
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function setChanged(){
        $this->hasChanged = true;
    }

    
    /**
     * @access public
     * @return 
     */
    public function clearChanged(){
        $this->hasChanged = true;   
    }




}