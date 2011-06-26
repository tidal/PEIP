<?php 


use \PEIP\Dispatcher\ObjectEventDispatcher as PEIP_Object_Event_Dispatcher;
use \PEIP\Event\Event as PEIP_Event;
use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;

require_once dirname(__FILE__).'/ObjectMapDispatcherTest.php';

class ObjectEventDispatcherTest 
	extends ObjectMapDispatcherTest {
	
	public function setup(){
		$this->dispatcher = new PEIP_Object_Event_Dispatcher; 
	}	
	
	public function testNotify(){
		$object = new stdClass;
		$event = new PEIP_Event($object, 'foo');
		$callable = new CallableObject($this);
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object));
		$listener = new PEIP_Callable_Handler(array($callable, 'callNotify'));	
		$this->dispatcher->connect('foo', $event, $listener);
		$this->dispatcher->notify('foo', $event); 
	}	
	
	public function testNotifyThrowExceptionOnWrongParameter(){
		$object = new stdClass;
		try {
			$this->dispatcher->notify('foo', $object);	
		}
		catch(Exception $e){
			return;
		}
		$this->fail('InvalidArgumentException should have been thrown.');	
	}		
		
	public function testNotifyThrowExceptionOnWrongEventSubject(){
		$object = new stdClass;
		$event = new PEIP_Event(array(), 'foo');
		try {
			$this->dispatcher->notify('foo', $event);	
		}
		catch(Exception $e){
			return;
		}
		$this->fail('InvalidArgumentException should have been thrown.');	
	}	
}
