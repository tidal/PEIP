<?php

require_once __DIR__.'/DynamicAdapterTest.php';
require_once __DIR__.'/GenericBuilderTest.php';
require_once __DIR__.'/ReflectionClassBuilderTest.php';
require_once __DIR__.'/SealerTest.php';

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
