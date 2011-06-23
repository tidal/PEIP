<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_INF_Header_Enricher 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 */


interface PEIP_INF_Header_Enricher {
   
    /**
     * @access public
     * @param PEIP_INF_Message $message
     * @return 
     */
    public function enrich(PEIP_INF_Message $message);

}

