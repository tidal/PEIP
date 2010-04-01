<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Message_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 */


interface PEIP_INF_Message_Dispatcher {

  public function connect($name, PEIP_INF_Message_Handler $handler);

  public function disconnect($name, PEIP_INF_Message_Handler $handler);

  public function notify(PEIP_Event_Inf $event);

  public function notifyUntil(PEIP_Event_Inf $event);

  public function filter(PEIP_Event_Inf $event, $value);

  public function hasListeners($name);

  public function getListeners($name);  

}

