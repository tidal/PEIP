<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Data\Store 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */
 





namespace PEIP\INF\Data;

interface Store {

    public function setValue($key, $value);
    
    public function getValue($key);
    
    public function deleteValue($key);
    
    public function hasValue($key);

    public function setValues(array $values);
    
    public function getValues();    

    public function addValues(array $values);   
}