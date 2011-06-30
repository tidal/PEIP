<?php

namespace PEIP\Autoload;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\Autoload\SimpleAutoload
 * Autolad class
 * 
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage autoload 
 * @extends \PEIP\Autoload\SimpleAutoload
 */


class Autoload {

    protected
        $baseDir;

    static protected
        $instance;
    
    /**
     * Constructor.
     * Loads class-paths from AutoloadPaths::$paths
     * 
     * @access protected
     */ 
    protected function __construct(){
        $this->init();
    }

    /**
     * Retrieves Singleton instance
     *
     * @access public
     * @static
     * @return Autoload
     */
    static public function getInstance($new = false){
        if (!isset(self::$instance) || $new){
            self::$instance = new Autoload();
        }
        return self::$instance;
    }
    
    /**
     * Initialization method.
     * Registers autoload with this class.
     *
     * @access protected
     */
    protected function init(){
        $this->baseDir = self::getBaseDirectory();
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        if (false === spl_autoload_register(array($this, 'autoload'))){
            // @codeCoverageIgnoreStart
            throw new \RuntimeException(sprintf('Unable to register %s::autoload as an autoloading method.', get_class($this)));
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * returns the autoload base directory.
     * Registers autoload with this class.
     *
     * @access protected
     * @return string the base directory
     */
    protected static function getBaseDirectory(){
        return str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'));
    }

    /**
     * handles the autoloading of classes
     * 
     * @access public
     * @param string $class the class to load
     * @return path to the class-file 
     */     
    public function autoload($class){
        $res = false;
        if(!class_exists($class, false)){
            $path = str_replace('PEIP\\', '', $class);
            $path = $this->baseDir.DIRECTORY_SEPARATOR
                .str_replace('\\', DIRECTORY_SEPARATOR, $path).'.php';
            if (is_file($path)){
                require $path;
                if(class_exists($class) || interface_exists($class)){
                    $res = true;
                }
            }
        }
        return $res;
    }   

}
