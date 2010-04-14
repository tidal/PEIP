<?php

require_once __DIR__.'/EventTest.php';
require_once __DIR__.'/EventBuilderTest.php';

 class Event_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('event');
		$suite->addTestSuite('EventTest');
		$suite->addTestSuite('EventBuilderTest');
		return $suite;
	}
}
