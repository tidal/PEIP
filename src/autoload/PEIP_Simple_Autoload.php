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
    	
	protected function __construct(){
		$this->init();
	}	

	protected function init(){
		$this->baseDir = realpath(dirname(__FILE__).'/..');
	    ini_set('unserialize_callback_func', 'spl_autoload_call');
    	if (false === spl_autoload_register(array($this, 'autoload'))){
      		throw new RuntimeException(sprintf('Unable to register %s::autoload as an autoloading method.', get_class($this)));
    	}	
	}
	
	static public function getInstance(){
	    if (!isset(self::$instance)){
	      static::doGetInstance();
	    }
	    return self::$instance;
	}

	protected static function doGetInstance(){
		self::$instance = new PEIP_Simple_Autoload();;	
	}
	
	public function setClassPath($class, $path){
		$this->classPaths[$class] = $path;
	}
	
	public function setClassPaths(array $classPaths){
		$this->classPaths = $classPaths;	
	}	

	public function getClassPath($class){
   	 	if (!isset($this->classPaths[$class])){
      		return null;
    	}
    	return $this->baseDir.'/'.$this->classPaths[$class];
	}	

  	public function autoload($class){
  		if ($path = $this->getClassPath($class)){
  			require $path;
      		if(class_exists($class)){
      			return true;
      		}
    	}
    	return false;
  	}	
	
	
}


