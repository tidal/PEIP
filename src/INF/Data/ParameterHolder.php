<?php

namespace PEIP\INF\Data;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Data\ParameterHolder 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */



interface ParameterHolder {

  public function setParameters(array $parameters);
  
  public function addParameters(array $parameters);
  
  public function getParameters();
  
  public function getParameter($name);
  
  public function setParameter($name, $value);
  
  public function hasParameter($name);

  public function deleteParameter($name);   

}
