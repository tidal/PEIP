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
    
    
    /**
     * @access protected
     * @param $content 
     * @return 
     */
    protected function doSetContent($content){
        $this->content = (bool)$content ? (string)$content : '';    
    }
    
    
    /**
     * @access public
     * @return 
     */
    public function __toString(){
        return $this->getContent();
    }
    
    public static function build(array $arguments = array()){
        return PEIP_Generic_Builder::getInstance('PEIP_String_Message')->build($arguments); 
    }
}