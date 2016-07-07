<?php


require_once dirname(__FILE__).'/PublishSubscribeChanelTest.php';
require_once dirname(__FILE__).'/ChannelTest.php';

 class channel_AllTests extends PHPUnit_Framework_TestSuite
 {
     public static function suite()
     {
         $suite = new PHPUnit_Framework_TestSuite('channel');

         $suite->addTestSuite('PublishSubscribeChanelTest');
         $suite->addTestSuite('ChannelTest');

         return $suite;
     }
 }
