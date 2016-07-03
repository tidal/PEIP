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
 * GenericMessage 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage message 
 * @extends PEIP\ABS\Base\Container
 * @implements \PEIP\INF\Base\Container, \PEIP\INF\Message\Message, \PEIP\INF\Base\Buildable
 */

use PEIP\Util\Test;
use PEIP\Base\GenericBuilder;

class GenericMessage 
    implements 
        \PEIP\INF\Message\Message, 
        \PEIP\INF\Base\Buildable {

    const CONTENT_CAST_TYPE = '';

    private
        $content,
        $headers;
           
    /**
     * constructor
     * 
     * @access public
     * @param mixed $content The content/payload of the message 
     * @param array|ArrayAccess $headers headers as key/value pairs
     */
    public function __construct($content, $headers = array()) {
        $this->doSetContent($content);
        $this->doSetHeaders($headers);          
    }

    /**
     * Returns the content of the container
     *
     * @implements \PEIP\INF\Base\Container
     * @access public
     * @return
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * sets content/payload of message - to be overwritten by derived classes
     * 
     * @access protected
     * @param mixed $content The content/payload of the message 
     */
    protected function doSetContent($content) {
        $this->content = Test::castType($content, self::CONTENT_CAST_TYPE);
    }

    protected function doSetHeaders($headers) {
        $headers = Test::ensureArrayAccess($headers);
        if (is_array($headers)) {
            $headers = new \ArrayObject($headers);
        }
        $this->headers = $headers;
    }

        /**
         * returns all headers of the message
         * 
         * @access public
         * @return ArrayAccess ArrayAccess object of headers
         */
    public function getHeaders(){
        return (array) $this->headers;
    }
  
    /**
     * returns one specific header of the message
     * 
     * @access public
     * @param string $name the name of the header  
     * @return mixed the value of the header
     */
    public function getHeader($name) {
        $name = (string)$name;
        return isset($this->headers[$name]) ? $this->headers[$name] : NULL;
    }

    /**
     * adds a specific header to the message if that header
     * has not allready been set.
     *
     * @access public
     * @param string $name the name of the header
     * @return boolean wether the header has been successfully  set
     */
    public function addHeader($name, $value) {
        if (!$this->hasHeader($name)) {
            $this->headers[$name] = $value;
            return true;
        }
        return false;
    }

    /**
     * checks wether a specific header is set on the message
     * 
     * @access public
     * @param string $name the name of the header
     * @return boolean wether the header is set
     */
    public function hasHeader($name) {
        return isset($this->headers[$name]);
    }

    /**
     * returns content/payload of the message as string representation for the instance.
     *
     * @access public
     * @return string  content/payload of the message
     */
    public function __toString() {
        $res = false;
        try {
            $res = (string)$this->getContent();
        }
        catch (\Exception $e) {           
            try {
                $res = get_class($this->getContent());
            }
            catch (\Exception $e) {
                return "";
            }
        }     
        
        return $res;     
    }

    /**
     * Provides a static build method to create new Instances of this class.
     * Implements \PEIP\INF\Base\Buildable
     * 
     * @static
     * @access public
     * @implements \PEIP\INF\Base\Buildable
     * @param array $arguments argumends for the constructor
     * @return GenericMessage new class instance
     */    
    public static function build(array $arguments = array()) {
        return GenericBuilder::getInstance(__CLASS__)->build($arguments);
    }     
} 