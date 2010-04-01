<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Intercabtable_Message_Channel 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @implements PEIP_INF_Message_Channel, PEIP_INF_Message_Sender
 */



interface PEIP_INF_Intercabtable_Message_Channel extends PEIP_INF_Message_Channel {

    public function addInterceptor(PEIP_Abstract_Message_Channel_Interceptor $interceptor);

    public function deleteInterceptor(PEIP_Abstract_Message_Channel_Interceptor $interceptor);
    
    public function getInterceptors() ;
    
    public function setInterceptors(array $interceptors);
        
    public function clearInterceptors();

}