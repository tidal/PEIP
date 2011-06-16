<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_List_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements PEIP_INF_Dispatcher
 */



interface PEIP_INF_List_Dispatcher extends PEIP_INF_Dispatcher {

  public function connect(PEIP_Event_Handler_Interface $handler);

  public function disconnect(PEIP_Event_Handler_Interface $handler);

  public function hasListeners();

  public function getListeners();

}