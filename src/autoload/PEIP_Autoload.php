<?php
require_once(__DIR__.'/PEIP_Simple_Autoload.php');

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Simple_Autoload 
 * Extended Autoloading class. Loads class-paths from 
 * PEIP_Autoload_Paths::$paths on startup.
 * Can (re)generate PEIP_Autoload_Paths::$paths through method 'make'.
 * 
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage autoload 
 * @extends PEIP_Simple_Autoload
 */

class PEIP_Autoload extends PEIP_Simple_Autoload {
	
    /**
     * Constructor.
     * Loads class-paths from PEIP_Autoload_Paths::$paths
     * 
     * @access protected
     */	
	protected function __construct(){
		$this->init();
		require_once(__DIR__.'/PEIP_Autoload_Paths.php');
		$this->setClassPaths(PEIP_Autoload_Paths::$paths);
	}
	
    /**
     * @access protected
     * @return PEIP_Autoload
     */
	protected static function doGetInstance(){
		return self::$instance = new PEIP_Autoload();	
	}		

    /**
     * Regenerates the class/files associations and replaces them in PEIP_Autoload_Paths
     * 
     * @access public
     * @static
     * @return void
     */	
	public static function make(){
		$baseDir = str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'));
		$iterator = new RecursiveDirectoryIterator($baseDir);
		$paths = self::findPaths($baseDir, $iterator);
		//print_r($paths);
		$pathsFile = __DIR__.'/PEIP_Autoload_Paths.php';
		$content = file_get_contents($pathsFile);
		echo $content = preg_replace('/public static \$paths = array *\(.*?\);/s', sprintf("public static \$paths = %s;", var_export($paths, true)), $content);
		file_put_contents($pathsFile, $content);
	}

    /**
     * Traverses a directory to find class-files
     * 
     * @access protected
     * @static
     * @param string $baseDir the directory under which to look for classes.
     * @param RecursiveDirectoryIterator $iterator A RecursiveDirectoryIterator instance for the directory
     * @param array $paths the array to store the class/path associations in.
     * @return PEIP_Autoload
     */	
	protected static function findPaths($baseDir, RecursiveDirectoryIterator $iterator, array $paths = array()){
		$iterator->rewind();
		while($iterator->valid()){
			if($iterator->isDir()){
				$paths = self::findPaths($baseDir, $iterator->getChildren(), $paths);
			}else{
				$class = str_replace('.php', '', $iterator->getFilename());
				$paths[$class] = str_replace($baseDir, '', $iterator->getPathName()); 						
			}
			$iterator->next();
		}
		return $paths;
	}
	

}