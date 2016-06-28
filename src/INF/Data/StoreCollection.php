<?php

namespace PEIP\INF\Data;

namespace PEIP\INF\Data;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Data\StoreCollection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */




interface StoreCollection {

  public function setValues($namespace, array $parameters);
  
  public function addValues($namespace, array $parameters);
  
  public function getValues($namespace);
  
  public function getValue($namespace, $name);
  
  public function setValue($namespace, $name, $value);
  
  public function hasValue($namespace, $name);

  public function deleteValue($namespace, $name);

  public function setStore($namespace, \PEIP\INF\Data\Store $store);

  public function getStore($namespace);

  public function hasStore($namespace);

  public function deleteStore($namespace);

}