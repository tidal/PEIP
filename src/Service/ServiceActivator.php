<?php

namespace PEIP\Service;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ServiceActivator 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 * @extends \PEIP\ABS\Service\ServiceActivator
 * @implements \PEIP\INF\Message\MessageBuilder, \PEIP\INF\Handler\Handler, \PEIP\INF\Channel\Channel, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Event\Connectable
 */



class ServiceActivator
    extends \PEIP\ABS\Service\ServiceActivator {
            
    
    /**
     * @access public
     * @param $serviceCallable 
     * @param $inputChannel 
     * @param $outputChannel 
     * @return 
     */
    public function __construct($serviceCallable, \PEIP\INF\Channel\Channel $inputChannel = NULL, \PEIP\INF\Channel\Channel $outputChannel = NULL){
        $this->serviceCallable = $serviceCallable;
        if(is_object($inputChannel)){
            $this->setInputChannel($inputChannel);
        }
        if(is_object($outputChannel)){
            $this->setOutputChannel($outputChannel);    
        }   
    }       


}
