<?php

require_once dirname(__FILE__).'/PipeTest.php';

 class pipe_AllTests extends PHPUnit_Framework_TestSuite
 {
     public static function suite()
     {
         $suite = new PHPUnit_Framework_TestSuite('pipe');
         $suite->addTestSuite('PipeTest');

         return $suite;
     }
 }
