<?php

namespace PEIP\INF\Handler;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\INF\Handler\Handler 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage handler 
 */


interface Handler {

    /**
     * Handles a subject. 
     * 
     * @abstract 
     * @access public
     * @param object $subject the subject to handle
     */
    public function handle($subject);
    
}