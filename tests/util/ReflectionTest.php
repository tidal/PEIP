<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/ReflectionTestResources.php');



class ReflectionTest extends PHPUnit_Framework_TestCase  {

    protected static $testInterfacesAndClasses = array(
        'ReflectionTestInterface1',
        'ReflectionTestInterface2',
        'ReflectionTestClass1',
        'ReflectionTestClass2',
        'ReflectionTestClass3',
        'ReflectionTestClass4'
    );


    public function testReferenceClass(){
        $instance = new ReflectionTestClass4;

        foreach(self::$testInterfacesAndClasses as $i){
            $this->assertTrue(($instance instanceof $i));
        }

    }

    public function testGetImplementedClassesAndInterfaces(){
        $clsAndInfs = PEIP_Reflection::getImplementedClassesAndInterfaces('ReflectionTestClass4');
        print_r($clsAndInfs);
        $this->assertSame(count(self::$testInterfacesAndClasses), count($clsAndInfs));
        $this->assertSame(
            sort(self::$testInterfacesAndClasses),
            sort($clsAndInfs)
        );

    }

    public function testGetImplementedClassesAndInterfacesNotCached(){
        $clsAndInfs = PEIP_Reflection::getImplementedClassesAndInterfaces('ReflectionTestClass4', false);
        $this->assertSame(count(self::$testInterfacesAndClasses), count($clsAndInfs));
        $this->assertSame(
            sort(self::$testInterfacesAndClasses),
            sort($clsAndInfs)
        );

    }

}
