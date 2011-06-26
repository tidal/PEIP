<?php 


use \PEIP\Dispatcher\ObjectMapDispatcher as PEIP_Object_Map_Dispatcher;
use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/CallableObject.php';

class ObjectMapDispatcherTest 
	extends PHPUnit_Framework_TestCase {

	protected $dispatcher;
	
	public function setup(){
		$this->dispatcher = new PEIP_Object_Map_Dispatcher; 
	}

	public function testConnect(){		
		$object = new stdClass;
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object));
		$handler = new PEIP_Callable_Handler(array('TestClass', 'TestMethod'));
		$this->dispatcher->connect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hasListeners('foo', $object)); 
	}

	public function testDisconnect(){		
		$object = new stdClass;
		$handler = new PEIP_Callable_Handler('TestClass', 'TestMethod');
		$this->assertFalse($this->dispatcher->disconnect('foo', $object, $handler));
		$this->dispatcher->connect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hasListeners('foo', $object));
		$this->dispatcher->disconnect('foo', $object, $handler);
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object)); 
		$this->assertFalse($this->dispatcher->disconnect('foo', $object, $handler));
	}


	public function testDisconnectAll(){
        $object = new stdClass;
        $key = 'foo';
        for($x = 1; $x <= 3; $x++){
            $object =
            $handler = function()use($x){return $x;};
            $this->dispatcher->connect($key, $object, $handler);
        }
        $this->dispatcher->disconnectAll($key, $object);

		$this->assertFalse($this->dispatcher->hasListeners($key, $object));
	}

	public function testHadListener(){
		$object = new stdClass;
		$handler = new PEIP_Callable_Handler('TestClass', 'TestMethod');
		$this->assertFalse($this->dispatcher->hadListeners('foo', $object));
		$this->dispatcher->connect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hadListeners('foo', $object));
		$this->dispatcher->disconnect('foo', $object, $handler);
		$this->assertTrue($this->dispatcher->hadListeners('foo', $object)); 
	}

	public function testGetEventNames(){
		$object = new stdClass;
		$handler = new PEIP_Callable_Handler('TestClass', 'TestMethod');
		$this->assertEquals(array(), $this->dispatcher->getEventNames($object));
		$events = array('foo', 'bar', 'test');
		foreach($events as $event){
			$this->dispatcher->connect($event, $object, $handler);	
		}
		$this->assertEquals($events, $this->dispatcher->getEventNames($object));
	}

	public function testGetListeners(){
        
		$object = new stdClass;
		$this->dispatcher
                ->disconnectAll(
                        'foo',
                        $object);

        $this->assertEquals(array(), $this->dispatcher->getListeners('foo', $object));
		$listeners = array(
			new PEIP_Callable_Handler('TestClass', 'TestMethod'),
			new PEIP_Callable_Handler('TestClass', 'TestMethod'),
			new PEIP_Callable_Handler('TestClass', 'TestMethod')			
		);
		foreach($listeners as $listener){
			$this->dispatcher->connect('foo', $object, $listener);
		}
		$this->assertEquals($listeners, $this->dispatcher->getListeners('foo', $object));
	}

	public function testNotify(){
		$object = new stdClass;
		$callable = new CallableObject($this);
                $callable->setObject($object);
		$this->assertFalse($this->dispatcher->hasListeners('foo', $object));
		$listener = new PEIP_Callable_Handler(array($callable, 'callNotify'));	
		$this->dispatcher->connect('foo', $object, $listener);
		$this->dispatcher->notify('foo', $object); 
	}
	
	public function testNotifyUntil(){
		$object = new stdClass;
		$callable = new CallableObject($this);
                $callable->setObject($object);
		$listeners = array();
		$listener1 = new PEIP_Callable_Handler(array($callable, 'callNotify'));	
		$this->dispatcher->connect('foo', $object, $listener1);
		$breaker = $this->dispatcher->notifyUntil('foo', $object);
		$listener2 = new PEIP_Callable_Handler(array($callable, 'callUntil'));	
		$this->dispatcher->connect('foo', $object, $listener2);
		$breaker = $this->dispatcher->notifyUntil('foo', $object);
		$listener3 = new PEIP_Callable_Handler(array($callable, 'callNoMore'));	
		$this->dispatcher->connect('foo', $object, $listener3);
		$breaker = $this->dispatcher->notifyUntil('foo', $object); 
		$this->assertSame($listener2, $breaker);	
		// test to get full code-coverage
		
		
	}	
}
