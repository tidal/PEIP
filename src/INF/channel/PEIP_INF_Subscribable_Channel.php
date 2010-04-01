<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Subscribable_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage channel 
 */


interface PEIP_INF_Subscribable_Channel {

    public function subscribe(PEIP_INF_Handler $handler);
    
    public function unsubscribe(PEIP_INF_Handler $handler);
    
}