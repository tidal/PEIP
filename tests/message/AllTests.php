<?php

require_once __DIR__.'/GenericMessageTest.php';
require_once __DIR__.'/StringMessageTest.php';
require_once __DIR__.'/CallableMessageHandlerTest.php';

 class Message_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('message');
		$suite->addTestSuite('GenericMessageTest');
		$suite->addTestSuite('StringMessageTest');
		$suite->addTestSuite('CallableMessageHandlerTest');
		return $suite;
	}
}
