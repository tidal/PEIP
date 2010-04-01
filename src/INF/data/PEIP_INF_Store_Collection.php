<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Store_Collection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */



interface PEIP_INF_Store_Collection {

  public function setValues($namespace, array $parameters);
  
  public function addValues($namespace, array $parameters);
  
  public function getValues($namespace);
  
  public function getValue($namespace, $name);
  
  public function setValue($namespace, $name, $value);
  
  public function hasValue($namespace, $name);

  public function deleteValue($namespace, $name);

  public function setStore($namespace, PEIP_Store_Interface $store); 

  public function getStore($namespace);

  public function hasStore($namespace);

  public function deleteStore($namespace);

}