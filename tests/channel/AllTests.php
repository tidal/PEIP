<?php

require_once __DIR__.'/InterceptableMessageChannelTest.php';

 class Channel_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('channel');
		$suite->addTestSuite('InterceptableMessageChannelTest');
		return $suite;
	}
}
