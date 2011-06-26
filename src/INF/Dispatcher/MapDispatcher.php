<?php

namespace PEIP\INF\Dispatcher;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Dispatcher\MapDispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements \PEIP\INF\Event\Connectable
 */



interface MapDispatcher 
    extends \PEIP\INF\Event\Connectable { 


  /**
   * Notifies all listeners of a given event.
   *
   * @param  $event A  instance
   *
   * @return  The  instance
   */
    public function notify($name, $subject);
  

}


