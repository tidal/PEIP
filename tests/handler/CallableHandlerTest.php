<?php
require_once __DIR__.'/../../misc/bootstrap.php';

class CallableHandlerTest 
	extends PHPUnit_Framework_TestCase {

	protected $handler;

	public function setup(){
		$test = $this;
		$this->handler = new PEIP_Callable_Handler(function($subject) use($test){
			$test->assertSame($test, $subject);
		});
	}
		
	public function testHandle(){
		$this->handler->handle($this);	
	}
	
	public function testInvoke(){
		$handle = $this->handler;
		$handle($this);	
	}	

	public function testGetCallable(){
		$callable = function(){};
		$handler = new PEIP_Callable_Handler($callable);
		$this->assertSame($callable, $handler->getCallable());		
	}
	
} 