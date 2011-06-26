<?php 


use \PEIP\Util\ReflectionPool as PEIP_Reflection_Pool;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/ReflectionTestResources.php');



class ReflectionPoolTest extends PHPUnit_Framework_TestCase  {

     public function testGetInstanceReturnsReflectionClass(){
         $cls = PEIP_Reflection_Pool::getInstance('ReflectionTestClass1');
         $this->assertTrue($cls instanceof  ReflectionClass);
         $cls = PEIP_Reflection_Pool::getInstance(new ReflectionTestClass1);
         $this->assertTrue($cls instanceof  ReflectionClass);
     }

     public function testGetInstanceCachesReflectionClassInstances(){
         $cls1 = PEIP_Reflection_Pool::getInstance('ReflectionTestClass1');
         $cls2 = PEIP_Reflection_Pool::getInstance(new ReflectionTestClass1);
         $this->assertEquals($cls1, $cls2);
     }
}
