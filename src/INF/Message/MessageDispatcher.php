<?php

namespace PEIP\INF\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Message\MessageDispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 */



interface MessageDispatcher {

  public function connect($name, \PEIP\INF\Message\MessageHandler $handler);

  public function disconnect($name, \PEIP\INF\Message\MessageHandler $handler);

  public function notify( $event);

  public function notifyUntil( $event);

  public function filter( $event, $value);

  public function hasListeners($name);

  public function getListeners($name);  

}

