<?php

require_once dirname(__FILE__).'/DispatcherTest.php';
require_once dirname(__FILE__).'/ObjectEventDispatcherTest.php';
require_once dirname(__FILE__).'/ObjectMapDispatcherTest.php';

 class Dispatcher_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('dispatcher');
		$suite->addTestSuite('DispatcherTest');
		$suite->addTestSuite('ObjectEventDispatcherTest');
		$suite->addTestSuite('ObjectMapDispatcherTest');
		return $suite;
	}
}
