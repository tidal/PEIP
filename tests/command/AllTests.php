<?php

require_once dirname(__FILE__).'/CommandTest.php';

 class Command_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('command');
		$suite->addTestSuite('CommandTest');
		return $suite;
	}
}
