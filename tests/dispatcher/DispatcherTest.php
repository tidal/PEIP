<?php

require_once __DIR__.'/../../misc/bootstrap.php';

class DispatcherTest 
	extends PHPUnit_Framework_TestCase {

	protected $dispatcher;
	
	public function setup(){
		$this->dispatcher = new PEIP_Dispatcher; 
	}

	public function testConnect(){
		$listener = new PEIP_Callable_Handler(function(){});
		$this->assertFalse($this->dispatcher->hasListeners());
		$this->dispatcher->connect($listener);
		$this->assertTrue($this->dispatcher->hasListeners());
	}
	
	
	public function testDisconnect(){
		$listener = new PEIP_Callable_Handler(function(){});
		$this->dispatcher->connect($listener);
		$this->assertTrue($this->dispatcher->hasListeners());
		$this->dispatcher->disconnect($listener);
		$this->assertFalse($this->dispatcher->hasListeners());
	}	
	
	public function testNotify(){
		$object = new stdClass;
		$test = $this;
		$this->assertFalse($this->dispatcher->hasListeners());
		$listener = new PEIP_Callable_Handler(function($subject) use ($test, $object){
			$test->assertSame($object, $subject);			
		});	
		$this->dispatcher->connect($listener);
		$this->dispatcher->notify($object); 
	}	

		
	public function testNotifyUntil(){
		$object = new stdClass;
		$test = $this;
		$listeners = array();
		$listener1 = new PEIP_Callable_Handler(function($subject) use ($test, $object){
			$test->assertSame($object, $subject);			
		});	
		$this->dispatcher->connect($listener1);
		$breaker = $this->dispatcher->notifyUntil($object);
		$listener2 = new PEIP_Callable_Handler(function($subject){
			return true;			
		});	
		$this->dispatcher->connect($listener2);
		$breaker = $this->dispatcher->notifyUntil($object);
		$listener3 = new PEIP_Callable_Handler(function($subject){
			$test->fail('Dispatcher should have stopped on last listener');			
		});	
		$this->dispatcher->connect($listener3);
		$breaker = $this->dispatcher->notifyUntil($object); 
		$this->assertSame($listener2, $breaker);		
	}	
	
}