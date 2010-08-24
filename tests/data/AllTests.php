<?php

require_once dirname(__FILE__).'/ParameterHolderTest.php';

 class Data_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('data');
		$suite->addTestSuite('ParameterHolderTest');
		return $suite;
	}
}
