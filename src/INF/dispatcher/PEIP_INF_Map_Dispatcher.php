<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Map_Dispatcher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage dispatcher 
 * @implements PEIP_INF_Connectable
 */


interface PEIP_INF_Map_Dispatcher 
    extends PEIP_INF_Connectable { 


  /**
   * Notifies all listeners of a given event.
   *
   * @param PEIP_Event_Inf $event A PEIP_Event_Inf instance
   *
   * @return PEIP_Event_Inf The PEIP_Event_Inf instance
   */
    public function notify($name, $subject);
  

}


