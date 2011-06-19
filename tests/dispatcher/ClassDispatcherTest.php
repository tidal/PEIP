<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/MapDispatcherTest.php';
require_once dirname(__FILE__).'/../_files/ReflectionTestResources.php';

class ClassDispatcherTest
	extends PHPUnit_Framework_TestCase {

	protected $dispatcher;

	public function setup(){
		$this->dispatcher = new PEIP_Class_Dispatcher;
	}

    public function testConnect(){
        $subject = 'foo';
        $eventName = 'bar';
        $className = 'ReflectionTestClass4';
        $classesNotfied = array();
        $test = $this;

        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            $this->assertFalse($this->dispatcher->hasListeners($cls));
            $classesNotfied[$cls] = false;
            $handler = function(){};
            $this->dispatcher->connect($cls, $handler);
            $this->assertTrue($this->dispatcher->hasListeners($className));
            $this->dispatcher->disconnect($cls, $handler);
        }
    }

    public function testConnectExceptionOnNonClass(){
        $className = 321;

        try{
            $this->dispatcher->connect($className, function(){});
        }
        catch(Exception $e){
            return;
        }
        $this->fail('An Exception should have been thrown');

    }

    public function testNotify(){
        $subject = 'foo';
        $eventName = 'bar';
        $className = 'ReflectionTestClass4';
        $classesNotfied = array();
        $test = $this;
        $this->assertFalse($this->dispatcher->notify($className, $subject));
        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            $classesNotfied[$cls] = false;
            $this->dispatcher->connect($cls, function()use($test, $cls){
                $test->classesNotfied[$cls] = true;
            });
        }
        $this->classesNotfied = $classesNotfied;

        $this->assertTrue($this->dispatcher->notify($className, $subject));

        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            $this->assertTrue($this->classesNotfied[$cls]);
        }

    }

    public function testNotifyUntil(){
        $subject = 'foo';
        $eventName = 'bar';
        $className = 'ReflectionTestClass4';
        $classesNotfied = array();
        $test = $this;
        $this->assertFalse((boolean)$this->dispatcher->notifyUntil($className, $subject));
        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            $classesNotfied[$cls] = false;
            $this->dispatcher->connect($cls, function()use($test, $cls){
                $test->classesNotfied[$cls] = true;
                return true;
            });
        }
        $this->classesNotfied = $classesNotfied;

        $this->assertTrue((boolean)$this->dispatcher->notifyUntil($className, $subject));

        $notifiedOnce = false;
        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            if($test->classesNotfied[$cls] == 1){
                if($notifiedOnce){
                    $this->fail('Only one listener should return a value!');
                }
                $notifiedOnce = true;
            }
        }
        if(!$notifiedOnce){
            $this->fail('One listener should return a value!');
        }
    }

    public function testNotifyExceptionOnNonClass(){
        $subject = 'foo';
        $eventName = 'bar';
        $className = 'foobarclass';
        try{
            $this->assertFalse($this->dispatcher->notify($className, $subject));
        }
        catch(Exception $e){
            return;
        }

        $this->fail('An Exception should have been raised');	

    }


    public function testNotifyOfInstance(){
        $subject = 'foo';
        $eventName = 'bar';
        $instance = new ReflectionTestClass4('foo');
        $classesNotfied = array();
        $test = $this;
        $this->assertFalse($this->dispatcher->notifyOfInstance($instance, $subject));
        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            $classesNotfied[$cls] = false;
            $this->dispatcher->connect($cls, function()use($test, $cls){
                $test->classesNotfied[$cls] = true;
            });
        }
        $this->classesNotfied = $classesNotfied;

        $this->assertTrue($this->dispatcher->notifyOfInstance($instance, $subject));

        foreach(ReflectionTestClassUtils::$testInterfacesAndClasses as $cls){
            $this->assertTrue($this->classesNotfied[$cls]);
        }

    }


}

