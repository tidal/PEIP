<?php

require_once __DIR__.'/CallableMessageHandlerTest.php';
require_once __DIR__.'/GenericMessageTest.php';
require_once __DIR__.'/MessageBuilderTest.php';
require_once __DIR__.'/StringMessageTest.php';

 class Message_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('message');
		$suite->addTestSuite('CallableMessageHandlerTest');
		$suite->addTestSuite('GenericMessageTest');
		$suite->addTestSuite('MessageBuilderTest');
		$suite->addTestSuite('StringMessageTest');
		return $suite;
	}
}
