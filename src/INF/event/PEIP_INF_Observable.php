<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Observable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 */



interface PEIP_INF_Observable {

    public function addObserver(PEIP_INF_Observer $observer);

    public function deleteObserver(PEIP_INF_Observer $observer);
    
    public function notifyObservers(array $arguments = array());

    public function countObservers();
    
    public function hasChanged();
    
    public function setChanged();
    
    public function clearChanged();

}