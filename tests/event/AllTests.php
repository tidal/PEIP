<?php

require_once dirname(__FILE__).'/EventBuilderTest.php';
require_once dirname(__FILE__).'/EventTest.php';

 class event_AllTests extends PHPUnit_Framework_TestSuite
 {
     public static function suite()
     {
         $suite = new PHPUnit_Framework_TestSuite('event');
         $suite->addTestSuite('EventBuilderTest');
         $suite->addTestSuite('EventTest');

         return $suite;
     }
 }
