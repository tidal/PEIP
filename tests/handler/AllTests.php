<?php

require_once dirname(__FILE__).'/CallableHandlerTest.php';


 class Handler_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
        $suite = new PHPUnit_Framework_TestSuite('handler');
        $iterator = new DirectoryIterator(__DIR__);
        $iterator->rewind();
        while($iterator->valid()){
            $file = $iterator->current();
            if($iterator->isFile() && $file != 'AllTests.php'){
                require_once __DIR__.'/'.$file;
                $suiteName = str_replace('.php', '', $file);
                $suite->addTestSuite(str_replace('.php', '', $file));
            }
            $iterator->next();
        }
		return $suite;
	}
}