<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Parameter_Holder 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 */


interface PEIP_INF_Parameter_Holder {

  public function setParameters(array $parameters);
  
  public function addParameters(array $parameters);
  
  public function getParameters();
  
  public function getParameter($name);
  
  public function setParameter($name, $value);
  
  public function hasParameter($name);

  public function deleteParameter($name);   

}
