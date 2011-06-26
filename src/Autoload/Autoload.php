<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * \PEIP\Autoload\SimpleAutoload 
 * Extended Autoloading class. Loads class-paths from 
 * AutoloadPaths::$paths on startup.
 * Can (re)generate AutoloadPaths::$paths through method 'make'.
 * 
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage autoload 
 * @extends \PEIP\Autoload\SimpleAutoload
 */


namespace PEIP\Autoload;

require_once(dirname(__FILE__).'/SimpleAutoload.php');

class Autoload extends SimpleAutoload {
    
    /**
     * Constructor.
     * Loads class-paths from AutoloadPaths::$paths
     * 
     * @access protected
     */ 
    protected function __construct(){
        $this->init();
        require_once(dirname(__FILE__).'/AutoloadPaths.php');
        $this->setClassPaths(AutoloadPaths::$paths);
    }

    /**
     * Retrieves Singleton instance 
     * 
     * @access public
     * @static
     * @return Autoload
     */     
    static public function getInstance(){ 
        if (!isset(self::$instance)){
            self::$instance = new Autoload();
        }
        return self::$instance;
    }

    
    /**
     * @access protected
     * @return Autoload
     */
    protected static function doGetInstance(){
        return self::$instance = new Autoload();   
    }       
 
    /**
     * Scans a directory recursively for php-files and adds them to autoload
     * 
     * @access public
     * @param string directoy to scan
     * @return void
     */ 
    public function scanDirectory($dir){
        if(is_dir($dir)){ 
            $this->addClassPaths($this->findPaths(NULL, new RecursiveDirectoryIterator($dir)));
        }
    } 
        
    /**
     * Regenerates the class/files associations and replaces them in AutoloadPaths
     * 
     * @access public
     * @static
     * @return void
     */ 
    public static function make(){
        $baseDir = self::getBaseDirectory();
        $iterator = new RecursiveDirectoryIterator($baseDir);
        $paths = self::findPaths($baseDir, $iterator);
        $pathsFile = dirname(__FILE__).'/AutoloadPaths.php';
        $content = file_get_contents($pathsFile);
        $content = preg_replace('/public static \$paths = array *\(.*?\);/s', sprintf("public static \$paths = %s;", var_export($paths, true)), $content);
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
     * @return Autoload
     */ 
    protected static function findPaths($baseDir, RecursiveDirectoryIterator $iterator, array $paths = array()){
        $iterator->rewind();
        while($iterator->valid()){
            if($iterator->isDir() && !$iterator->isDot()){
                $paths = self::findPaths($baseDir, $iterator->getChildren(), $paths);
            }elseif($iterator->isFile() && strrchr($iterator->getFilename(), '.') == '.php'){
                $class = $iterator->getBasename('.php');
                $paths[$class] = str_replace($baseDir, '', $iterator->getPathName());                       
            }
            $iterator->next();
        }
        return $paths;
    }

    /**
     * handles the autoloading of classes
     * scans for files in extensions dir, if no class-path set
     * 
     * @access public
     * @param string $class the class to load
     * @return path to the class-file 
     */     
    public function autoload($class){ 
        if(!$this->getClassPath($class)){
            $this->scanDirectory(realpath(dirname(__FILE__).'/../extensions')); 
        }
        parent::autoload($class);
    }   

}
