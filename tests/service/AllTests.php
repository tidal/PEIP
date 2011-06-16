<?php

require_once dirname(__FILE__).'/ServiceActivatorTest.php';
require_once dirname(__FILE__).'/ServiceProviderTest.php';
 class Service_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('service');
		$suite->addTestSuite('ServiceActivatorTest');
        $suite->addTestSuite('ServiceProviderTest');
		return $suite;
	}
}
