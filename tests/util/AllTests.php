<?php
require_once dirname(__FILE__).'/ReflectionPoolTest.php';
require_once dirname(__FILE__).'/ReflectionTest.php';
require_once dirname(__FILE__).'/TestTest.php';
 class Util_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('util');
        $suite->addTestSuite('ReflectionPoolTest');
		$suite->addTestSuite('ReflectionTest');
        $suite->addTestSuite('TestTest');
		return $suite;
	}
}
