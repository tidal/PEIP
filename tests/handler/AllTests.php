<?php

require_once dirname(__FILE__).'/CallableHandlerTest.php';


 class Handler_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('message');
		$suite->addTestSuite('CallableHandlerTest');
		return $suite;
	}
}
