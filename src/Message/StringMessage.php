<?php

namespace PEIP\Message;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * StringMessage 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends \PEIP\Message\GenericMessage
 * @implements \PEIP\INF\Base\Buildable, \PEIP\INF\Message\Message, \PEIP\INF\Base\Container
 */

use PEIP\Base\GenericBuilder;

class StringMessage 
    extends \PEIP\Message\GenericMessage {

    const CONTENT_CAST_TYPE = 'string';

    public function __toString(){
        return (string)$this->getContent();
    }

    public function getContent(){
        return (string)parent::getContent();
    }

    /**
     * Provides a static build method to create new Instances of this class.
     * Implements \PEIP\INF\Base\Buildable. Overwrites \PEIP\Message\GenericMessage::build.
     * 
     * @static
     * @access public
     * @implements \PEIP\INF\Base\Buildable
     * @param string $name the name of the header
     * @return boolean wether the header is set
     */     
    public static function build(array $arguments = array()){
        return GenericBuilder::getInstance(__CLASS__)->build($arguments);
    }
}