<?php

namespace PEIP\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\Service\ServiceActivator 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends PEIP\ABS\Service\ServiceActivator
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable
 */


use PEIP\Message\StringMessage;

class StringServiceActivator
    extends \PEIP\Service\ServiceActivator {
            
    protected 
        $messageClass = 'StringMessage';       
    
}
