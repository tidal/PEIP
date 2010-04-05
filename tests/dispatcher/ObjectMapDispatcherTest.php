<?php

require_once __DIR__.'/../../misc/bootstrap.php';

class ObjectMapDispatcherTest 
	extends PHPUnit_Framework_TestCase {

	protected $dispatcher;
	
	public function setup(){
		$this->dispatcher = new PEIP_Object_Map_Dispatcher; 
	}

	public function testConnect(){		
		$object = new stdClass;
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object));
		$handler = new PEIP_Callable_Handler(function(){});
		$this->dispatcher->connect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hasListeners('foo', $object)); 
	}

	public function testDisconnect(){		
		$object = new stdClass;
		$handler = new PEIP_Callable_Handler(function(){});
		$this->assertFalse($this->dispatcher->disconnect('foo', $object, $handler));
		$this->dispatcher->connect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hasListeners('foo', $object));
		$this->dispatcher->disconnect('foo', $object, $handler);
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object)); 
		$this->assertFalse($this->dispatcher->disconnect('foo', $object, $handler));
	}	

	public function testHadListener(){
		$object = new stdClass;
		$handler = new PEIP_Callable_Handler(function(){});
		$this->assertFalse($this->dispatcher->hadListeners('foo', $object));
		$this->dispatcher->connect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hadListeners('foo', $object));
		$this->dispatcher->disconnect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hadListeners('foo', $object)); 
	}

	public function testGetEventNames(){
		$object = new stdClass;
		$handler = new PEIP_Callable_Handler(function(){});
		$this->assertEquals(array(), $this->dispatcher->getEventNames($object));
		$events = array('foo', 'bar', 'test');
		foreach($events as $event){
			$this->dispatcher->connect($event, $object, $handler);	
		}
		$this->assertEquals($events, $this->dispatcher->getEventNames($object));
	}

	public function testGetListeners(){
		$object = new stdClass;
		$this->assertEquals(array(), $this->dispatcher->getListeners('foo', $object));
		$listeners = array(
			new PEIP_Callable_Handler(function(){echo 'foo';}),
			new PEIP_Callable_Handler(function(){echo 'bar';}),
			new PEIP_Callable_Handler(function(){echo 'bar';})			
		);
		foreach($listeners as $listener){
			$this->dispatcher->connect('foo', $object, $listener);	
		}
		$this->assertEquals($listeners, $this->dispatcher->getListeners('foo', $object));		
	}

	public function testNotify(){
		$object = new stdClass;
		$test = $this;
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object));
		$listener = new PEIP_Callable_Handler(function($subject) use ($test, $object){
			$test->assertSame($object, $subject);			
		});	
		$this->dispatcher->connect('foo', $object, $listener);
		$this->dispatcher->notify('foo', $object); 
	}
	
	public function testNotifyUntil(){
		$object = new stdClass;
		$test = $this;
		$listeners = array();
		$listener1 = new PEIP_Callable_Handler(function($subject) use ($test, $object){
			$test->assertSame($object, $subject);			
		});	
		$this->dispatcher->connect('foo', $object, $listener1);
		$breaker = $this->dispatcher->notifyUntil('foo', $object);
		$listener2 = new PEIP_Callable_Handler(function($subject){
			return true;			
		});	
		$this->dispatcher->connect('foo', $object, $listener2);
		$breaker = $this->dispatcher->notifyUntil('foo', $object);
		$listener3 = new PEIP_Callable_Handler(function($subject){
			$test->fail('Dispatcher should have stopped on last listener');			
		});	
		$this->dispatcher->connect('foo', $object, $listener3);
		$breaker = $this->dispatcher->notifyUntil('foo', $object); 
		$this->assertSame($listener2, $breaker);	
		// test to get full code-coverage
		
		
	}	
}