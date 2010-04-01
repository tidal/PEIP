<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Text_Message 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends PEIP_String_Message
 * @implements PEIP_INF_Container, PEIP_INF_Message, PEIP_INF_Buildable
 */


class PEIP_Text_Message extends PEIP_String_Message {

    protected $title;
    
    
    /**
     * @access public
     * @param $content 
     * @param $title 
     * @return 
     */
    public function __construct($content, $title){
        $this->setContent((string)$content);
    }

    
    /**
     * @access public
     * @param $title 
     * @return 
     */
    public function setTitle($title){
        $this->title = (string)$title;
    }

    
    /**
     * @access public
     * @return 
     */
    public function getTitle(){
        return $this->title;
    }

}