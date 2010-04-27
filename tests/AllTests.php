<?php

require_once __DIR__.'/base/AllTests.php';
require_once __DIR__.'/channel/AllTests.php';
require_once __DIR__.'/command/AllTests.php';
require_once __DIR__.'/data/AllTests.php';
require_once __DIR__.'/dispatcher/AllTests.php';
require_once __DIR__.'/event/AllTests.php';
require_once __DIR__.'/handler/AllTests.php';
require_once __DIR__.'/message/AllTests.php';
require_once __DIR__.'/service/AllTests.php';

 class AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('');
		$suite->addTestSuite('Base_AllTests');
		$suite->addTestSuite('Channel_AllTests');
		$suite->addTestSuite('Command_AllTests');
		$suite->addTestSuite('Data_AllTests');
		$suite->addTestSuite('Dispatcher_AllTests');
		$suite->addTestSuite('Event_AllTests');
		$suite->addTestSuite('Handler_AllTests');
		$suite->addTestSuite('Message_AllTests');
		$suite->addTestSuite('Service_AllTests');
		return $suite;
	}
}
