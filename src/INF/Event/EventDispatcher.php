<?php

namespace PEIP\INF\Event;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Event\EventDispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements \PEIP\INF\Event\Connectable
 */




interface EventDispatcher 
    extends \PEIP\INF\Event\Connectable {

  public function notify($subject);

  public function notifyUntil($subject);

  public function filter($subject);

    
}