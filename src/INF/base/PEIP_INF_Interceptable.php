<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Interceptable 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 */


interface PEIP_INF_Interceptable {

    public function addInterceptor(PEIP_INF_Channel_Interceptor $interceptor);

    public function deleteInterceptor(PEIP_INF_Channel_Interceptor $interceptor);
    
    public function getInterceptors() ;
    
    public function setInterceptors(array $interceptors);
        
    public function clearInterceptors();

}
