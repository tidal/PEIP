<?php

require_once __DIR__.'/ServiceActivatorTest.php';

 class Service_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('service');
		$suite->addTestSuite('ServiceActivatorTest');
		return $suite;
	}
}
