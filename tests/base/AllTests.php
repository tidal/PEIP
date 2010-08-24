<?php

require_once dirname(__FILE__).'/DynamicAdapterTest.php';
require_once dirname(__FILE__).'/GenericBuilderTest.php';
require_once dirname(__FILE__).'/ReflectionClassBuilderTest.php';
require_once dirname(__FILE__).'/SealerTest.php';

 class Base_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('base');
		$suite->addTestSuite('DynamicAdapterTest');
		$suite->addTestSuite('GenericBuilderTest');
		$suite->addTestSuite('ReflectionClassBuilderTest');
		$suite->addTestSuite('SealerTest');
		return $suite;
	}
}
