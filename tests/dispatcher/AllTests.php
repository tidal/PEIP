<?php

require_once __DIR__.'/ObjectMapDispatcherTest.php';
require_once __DIR__.'/ObjectEventDispatcherTest.php';
require_once __DIR__.'/DispatcherTest.php';

 class Dispatcher_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('dispatcher');
		$suite->addTestSuite('ObjectMapDispatcherTest');
		$suite->addTestSuite('ObjectEventDispatcherTest');
		$suite->addTestSuite('DispatcherTest');
		return $suite;
	}
}
