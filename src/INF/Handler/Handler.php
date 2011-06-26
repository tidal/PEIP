<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
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


namespace PEIP\INF\Handler;

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