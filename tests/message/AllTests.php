<?php

require_once dirname(__FILE__).'/CallableMessageHandlerTest.php';
require_once dirname(__FILE__).'/GenericMessageTest.php';
require_once dirname(__FILE__).'/MessageBuilderTest.php';
require_once dirname(__FILE__).'/StringMessageTest.php';

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
