<?php
require_once(__DIR__.'/PEIP_Simple_Autoload.php');


class PEIP_Autoload extends PEIP_Simple_Autoload {

	public function __construct(){
		$this->init();
		require_once(__DIR__.'/PEIP_Autoload_Paths.php');
		$this->setClassPaths(PEIP_Autoload_Paths::$paths);
	}
	
	protected static function doGetInstance(){
		self::$instance = new PEIP_Autoload();	
	}		
	
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