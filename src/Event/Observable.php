<?php

namespace PEIP\Event;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Observable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements \PEIP\INF\Event\Observable
 */




class Observable implements \PEIP\INF\Event\Observable {

    protected $observedObject;
    
    protected $observers = array();

    protected $hasChanged = false;
    
    
    /**
     * @access public
     * @param $observedObject 
     * @return 
     */
    public function __construct($observedObject) {
        $this->setObserved($observedObject);
    }

    protected function setObserved($observedObject) {
        if (!is_object($observedObject)) {
            throw new \InvalidArgumentException("$observedObject must be an object. ".gettype($var)." given.");
        }
        
        $this->observedObject = $observedObject;      
    }

        /**
         * @access public
         * @param $observer 
         * @return 
         */
    public function addObserver(\PEIP\INF\Event\Observer $observer){
        $this->observers[] = $observer;     
    }

    
    /**
     * @access public
     * @param $observer 
     * @return 
     */
    public function deleteObserver(\PEIP\INF\Event\Observer $observer) {
        foreach ($this->observers as $key=>$obs) {
            if ($obs == $observer) {
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
    public function notifyObservers(array $arguments = array()) {
        if ($this->hasChanged()) {
            foreach ($this->observers as $observer) {
                $observer->update($this->observedObject);
            }       
        }
    }

    
    /**
     * @access public
     * @return 
     */
    public function countObservers() {
        return count($this->obeservers);
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function hasChanged() {
        return $this->hasChanged();
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function setChanged() {
        $this->hasChanged = true;
    }

    
    /**
     * @access public
     * @return 
     */
    public function clearChanged() {
        $this->hasChanged = true;   
    }




}