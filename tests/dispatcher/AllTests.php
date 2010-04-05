<?php

require_once __DIR__.'/ObjectMapDispatcherTest.php';

 class Dispatcher_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('dispatcher');
		$suite->addTestSuite('ObjectMapDispatcherTest');
		return $suite;
	}
}
