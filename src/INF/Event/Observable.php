<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Event\Observable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */




namespace PEIP\INF\Event;

interface Observable {

    public function addObserver(\PEIP\INF\Event\Observer $observer);

    public function deleteObserver(\PEIP\INF\Event\Observer $observer);
    
    public function notifyObservers(array $arguments = array());

    public function countObservers();
    
    public function hasChanged();
    
    public function setChanged();
    
    public function clearChanged();

}