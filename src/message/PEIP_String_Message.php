<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_String_Message 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends PEIP_Generic_Message
 * @implements PEIP_INF_Buildable, PEIP_INF_Message, PEIP_INF_Container
 */

class PEIP_String_Message 
    extends PEIP_Generic_Message {

    const CONTENT_CAST_TYPE = 'string';

    public function __toString(){
        return (string)$this->getContent();
    }

    public function getContent(){
        return (string)parent::getContent();
    }

    /**
     * Provides a static build method to create new Instances of this class.
     * Implements PEIP_INF_Buildable. Overwrites PEIP_Generic_Message::build.
     * 
     * @static
     * @access public
     * @implements PEIP_INF_Buildable
     * @param string $name the name of the header
     * @return boolean wether the header is set
     */     
    public static function build(array $arguments = array()){
        return PEIP_Generic_Builder::getInstance('PEIP_String_Message')->build($arguments); 
    }
}