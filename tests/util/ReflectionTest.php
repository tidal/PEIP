<?php 


use \PEIP\Util\Reflection as PEIP_Reflection;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/ReflectionTestResources.php');



class ReflectionTest extends PHPUnit_Framework_TestCase  {

    public function testReferenceClass(){
        $instance = new ReflectionTestClass4('foo');

        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $i){
            $this->assertTrue(($instance instanceof $i));
        }

    }

    public function testGetImplementedClassesAndInterfaces(){
        $clsAndInfs = PEIP_Reflection::getImplementedClassesAndInterfaces('ReflectionTestClass4');
        $this->assertSame(count(ReflectionTestClassUtils::$testInterfacesAndClasses), count($clsAndInfs));
        $this->assertSame(
            sort(ReflectionTestClassUtils::$testInterfacesAndClasses),
            sort($clsAndInfs)
        );

    }

    public function testGetImplementedClassesAndInterfacesNotCached(){
        $clsAndInfs = PEIP_Reflection::getImplementedClassesAndInterfaces('ReflectionTestClass4', false);
        $this->assertSame(count(ReflectionTestClassUtils::$testInterfacesAndClasses), count($clsAndInfs));
        $this->assertSame(
            sort(ReflectionTestClassUtils::$testInterfacesAndClasses),
            sort($clsAndInfs)
        );

    }

}
