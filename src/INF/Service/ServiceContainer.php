<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Service\ServiceContainer 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage service 
 */



namespace PEIP\INF\Service;

interface ServiceContainer {

    public function setService($id, $service);
    
    public function getService($id);
    
    public function hasService($id);

}

