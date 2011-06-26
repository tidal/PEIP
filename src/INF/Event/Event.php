<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Event\Event 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements \PEIP\INF\Message\Message, \PEIP\INF\Base\Container
 */



namespace PEIP\INF\Event;

interface Event extends \PEIP\INF\Message\Message {

  public function getName();

  public function setReturnValue($value);

  public function getReturnValue();

  public function setProcessed($processed);

  public function isProcessed();

}