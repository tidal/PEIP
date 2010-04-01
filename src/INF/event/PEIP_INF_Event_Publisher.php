<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Event_Publisher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage event 
 * @implements PEIP_INF_Connectable
 */



interface PEIP_INF_Event_Publisher 
    extends PEIP_INF_Connectable {
    
    public function fireEvent(PEIP_INF_Event $event);
        
}