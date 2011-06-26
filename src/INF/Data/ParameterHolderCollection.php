<?php

namespace PEIP\INF\Data;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Data\ParameterHolderCollection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */




interface ParameterHolderCollection {

  public function setParameters($namespace, array $parameters);
  
  public function addParameters($namespace, array $parameters);
  
  public function getParameters($namespace);
  
  public function getParameter($namespace, $name);
  
  public function setParameter($namespace, $name, $value);
  
  public function hasParameter($namespace, $name);

  public function deleteParameter($namespace, $name);

  public function setParameterHolder($namespace, \PEIP\INF\Data\ParameterHolder $holder); 

  public function getParameterHolder($namespace);

  public function hasParameterHolder($namespace);

  public function deleteParameterHolder($namespace);
  
}