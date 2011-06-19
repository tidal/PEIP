<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/CallableObject.php';

class MapDispatcherTest
	extends PHPUnit_Framework_TestCase {

	protected $dispatcher;

	public function setup(){
		$this->dispatcher = new PEIP_Map_Dispatcher;
	}

	public function testConnect(){
        $eventName = 'foo';
		$listener = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
		$this->assertFalse($this->dispatcher->hasListeners($eventName));
		$this->dispatcher->connect($eventName, $listener);
		$this->assertTrue($this->dispatcher->hasListeners($eventName));
	}

	public function testDisconnect(){
        $eventName = 'foo';
		$listener = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
		$this->assertFalse($this->dispatcher->hasListeners($eventName));
        $this->assertFalse($this->dispatcher->disconnect($eventName, $listener));
		$this->dispatcher->connect($eventName, $listener);
		$this->assertTrue($this->dispatcher->hasListeners($eventName));
        $this->assertTrue($this->dispatcher->disconnect($eventName, $listener));
        $this->assertFalse($this->dispatcher->hasListeners($eventName));
	}

	public function testDisconnectAll(){
        $eventName = 'foo';
		$listener = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
		$this->assertFalse($this->dispatcher->hasListeners($eventName));
        $this->assertFalse($this->dispatcher->disconnectAll($eventName));
        for($x = 1; $x <=3; $x++){
            $this->dispatcher->connect($eventName, $listener);
        }
		$this->assertTrue($this->dispatcher->hasListeners($eventName));
        $this->assertTrue($this->dispatcher->disconnectAll($eventName));
        $this->assertFalse($this->dispatcher->hasListeners($eventName));
	}

    public function testNotify(){
        $eventName = 'foo';
        $handlersCalled = array();
        $handlerNr = 3;
        $subject = 'foo';
        $test = $this;
        $test->assertFalse($this->dispatcher->notify($eventName, $subject));
        for($x = 1; $x < $handlerNr; $x++){
            $handlersCalled[$x] = false;
            $this->dispatcher->connect($eventName, function($sub)use($test, $x, $subject){
                $test->assertEquals($subject, $sub);
                $test->handlersCalled[$x] = true;
            });
        }       
        $this->handlersCalled = $handlersCalled;
        $test->assertTrue($this->dispatcher->notify($eventName, $subject));
        for($x = 1; $x < $handlerNr; $x++){
            $test->assertTrue($test->handlersCalled[$x]);
        } 

    }

    public function testNotifyUntil(){
        $eventName = 'foo';
        $handlersCalled = array();
        $handlerNr = 3;
        $subject = 'foo';
        $test = $this;
        $test->assertFalse((boolean)$this->dispatcher->notifyUntil($eventName, $subject));
        for($x = 1; $x < $handlerNr; $x++){
            $handlersCalled[$x] = false;
            $this->dispatcher->connect($eventName, function($sub)use($test, $x, $subject){
                $test->assertEquals($subject, $sub);
                $test->handlersCalled[$x] = true;
                return true;
            });
        }
        $this->handlersCalled = $handlersCalled;
        $test->assertTrue(is_callable($this->dispatcher->notifyUntil($eventName, $subject)));
        for($x = 1; $x < $handlerNr; $x++){
            if($x === 1){
                $test->assertTrue($test->handlersCalled[$x]);
            }else{
                $test->assertFalse($test->handlersCalled[$x]);
            }       
        }

    }

    public function testGetListeners(){
        $eventName = 'foo';
        $handlerNr = 3;
        $handlers = array();
        $test = $this;
        $test->assertEquals(array(), $this->dispatcher->getListeners($eventName));
        for($x = 1; $x < $handlerNr; $x++){
            $handlersCalled[$x] = false;
            $handlers[$x] = function(){};
            $this->dispatcher->connect($eventName, $handlers[$x]);
        }
        $test->assertEquals($handlers, $this->dispatcher->getListeners($eventName));

    }

}

