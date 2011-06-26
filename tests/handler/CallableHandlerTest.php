<?php 


use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;
require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/CallableObject.php';

class CallableHandlerTest 
	extends PHPUnit_Framework_TestCase {

	protected $handler;

	public function setup(){
		$callable = new CallableObject($this);
                $callable->setObject($this);
		$this->handler = new PEIP_Callable_Handler(array($callable, 'callNotify'));
	}
		
	public function testHandle(){
            $this->handler->handle($this);
	}
	
	public function testInvoke(){
		if(phpversion() >= '5.3.0'){
			$handle = $this->handler;
			$handle($this);	
		}
                $this->handler->__invoke($this);
	}	

	public function testGetCallable(){
		$callable = 'file_get_contents';
		$handler = new PEIP_Callable_Handler($callable);
		$this->assertSame($callable, $handler->getCallable());		
	}
	
} 
