<?php
/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Simple_Autoload 
 * Class providing basic autoload features
 * 
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage autoload 
 */

class PEIP_Simple_Autoload {

	protected
    	$baseDir = null,
    	$classPaths = array();
	
  	static protected
    	$instance;    	
    	
    /**
     * Constructor.
     * 
     * @access protected
     */	        	
	protected function __construct(){
		$this->init();
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
      		throw new RuntimeException(sprintf('Unable to register %s::autoload as an autoloading method.', get_class($this)));
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
     * Retrieves Singleton instance 
     * 
     * @access public
     * @static
     * @return PEIP_Simple_Autoload
     */		
	static public function getInstance(){
	    if (!isset(self::$instance)){
	      static::doGetInstance();
	    }
	    return self::$instance;
	}

    /**
     * Retrieves Singleton instance
     * To be overwritten by subclasses 
     * 
     * @access protected
     * @return PEIP_Simple_Autoload
     */	
	protected static function doGetInstance(){
		return self::$instance = new PEIP_Simple_Autoload();;	
	}
		
    /**
     * Sets a single file-path for a class
     * 
     * @access public
     * @param string $class the class name
     * @param string $path the path to the class-file  
     * @return void
     */		
	public function setClassPath($class, $path){
		$this->classPaths[$class] = $path;
	}

    /**
     * Sets all class-paths as key(class)/value(path) pairs array
     * 
     * @access public
     * @param array $classPaths class-paths as key(class)/value(path) pairs array
     * @return void
     */		
	public function setClassPaths(array $classPaths){
		$this->classPaths = $classPaths;	
	}	

    /**
     * returns the path to a class-file (if registered)
     * 
     * @access public
     * @param string $class the class name
     * @return path to the class-file 
     */		
	public function getClassPath($class){
   	 	if (!isset($this->classPaths[$class])){
      		return null;
    	}
    	$file = $this->classPaths[$class];
    	if(!is_file($file)){
    		$file = $this->baseDir.DIRECTORY_SEPARATOR.$file;
    	}   	
    	return $file;
	}	
	
    /**
     * handles the autoloading of classes
     * 
     * @access public
     * @param string $class the class to load
     * @return path to the class-file 
     */		
  	public function autoload($class){
  		$path = $this->getClassPath($class);
  		if (is_file($path)){
  			require $path;
      		if(class_exists($class) || interface_exists($class)){
      			return true;
      		}
    	}
    	throw new RuntimeException('unable to load class '.$class);
  	}	
}


