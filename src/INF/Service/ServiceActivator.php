<?php

namespace PEIP\INF\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Service\ServiceActivator 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @implements \PEIP\INF\Message\MessageHandler, \PEIP\INF\Handler\Handler
 */



interface ServiceActivator 
    extends \PEIP\INF\Message\MessageHandler {
    
    public function setInputChannel(\PEIP\INF\Channel\Channel $inputChannel);
    
    public function setOutputChannel(\PEIP\INF\Channel\Channel $outputChannel);  
    
}
