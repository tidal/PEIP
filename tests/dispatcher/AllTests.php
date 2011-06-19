<?php 

require_once dirname(__FILE__).'/DispatcherTest.php';
require_once dirname(__FILE__).'/ObjectEventDispatcherTest.php';
require_once dirname(__FILE__).'/ObjectMapDispatcherTest.php';
require_once dirname(__FILE__).'/IteratingDispatcherTest.php';
require_once dirname(__FILE__).'/MapDispatcherTest.php';
require_once dirname(__FILE__).'/ClassDispatcherTest.php';

 class Dispatcher_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('dispatcher');
		$suite->addTestSuite('DispatcherTest');
		$suite->addTestSuite('ObjectEventDispatcherTest');
		$suite->addTestSuite('ObjectMapDispatcherTest');
        $suite->addTestSuite('IteratingDispatcherTest');
        $suite->addTestSuite('MapDispatcherTest');
        $suite->addTestSuite('ClassDispatcherTest');
		return $suite;
	}
}
