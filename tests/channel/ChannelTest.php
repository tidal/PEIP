<?php 


use \PEIP\Dispatcher\ObjectEventDispatcher as PEIP_Object_Event_Dispatcher;
use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;
use \PEIP\Message\GenericMessage as PEIP_Generic_Message;
use \PEIP\INF\Event\Event as PEIP_INF_Event;
require_once dirname(__FILE__).'/../../misc/bootstrap.php';

require_once dirname(__FILE__).'/../_files/Channel.php';

class ChannelTest extends PHPUnit_Framework_TestCase {
 

	public function setUp(){
		$this->channel = new FooChannel('TestChannel');
        $dispatcher = new PEIP_Object_Event_Dispatcher;
		$this->channel->setEventDispatcher($dispatcher, false);
       }

	public function testGetName(){
		$this->assertEquals('TestChannel', $this->channel->getName());
	}



	public function testConnect(){
		$this->assertFalse($this->channel->hasListeners('preSend'));
		$handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
		$this->channel->connect('preSend', $handler);
		$this->assertTrue($this->channel->hasListeners('preSend'));
        $this->channel->disconnect('preSend', $handler);
	}

	public function testDisconnect(){
		$handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
		$this->channel->connect('preSend', $handler);
		$this->assertTrue($this->channel->hasListeners('preSend'));
		$this->channel->disconnect('preSend', $handler);
		$this->assertFalse($this->channel->hasListeners('preSend'));
	}

	public function testDisconnectAll(){
		$handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
		$this->channel->connect('preSend', $handler);
        $this->channel->connect('preSend', $handler);
        $this->channel->connect('preSend', $handler);
		$this->assertTrue($this->channel->hasListeners('preSend'));
		$this->channel->disconnectAll('preSend');
		$this->assertFalse($this->channel->hasListeners('preSend'));
	}

	public function testFireEvent(){
        $this->eventThrown = false;
		$message = new PEIP_Generic_Message(321);
        $dispatcher = new PEIP_Object_Event_Dispatcher;
		$this->channel->setEventDispatcher($dispatcher, false);
        $test = $this;
        $handler = function(PEIP_INF_Event $event)use($test, $message){
            $test->assertEquals($message, $event->getHeader('MESSAGE'));
            $test->eventThrown = true;
        };
        $this->channel->connect('preSend', $handler);
        $this->channel->send($message);
		$test->assertTrue($this->eventThrown);
        $this->channel->disconnect('preSend', $handler);
	}

	public function testGetListeners(){
		$handler1 = new PEIP_Callable_Handler(array('TestClass','TestMethod1'));
                $handler2 = new PEIP_Callable_Handler(array('TestClass','TestMethod2'));
		$this->channel->connect('postSend', $handler1);
                $this->channel->connect('postSend', $handler2);
		$this->assertEquals(array($handler1, $handler2), $this->channel->getListeners('postSend'));
	}

	public function testSetEventDispatcher(){
		$dispatcher = new PEIP_Object_Event_Dispatcher;
		$this->channel->setEventDispatcher($dispatcher);
		$this->assertEquals($dispatcher, $this->channel->getEventDispatcher());
	}


	public function testSetEventDispatcherTransferListners(){
                $handler1 = new PEIP_Callable_Handler(array('TestClass','TestMethod1'));
                $handler2 = new PEIP_Callable_Handler(array('TestClass','TestMethod2'));
                $this->channel->connect('test', $handler1);
                $this->channel->connect('test', $handler2);
		$dispatcher = new PEIP_Object_Event_Dispatcher;
		$this->channel->setEventDispatcher($dispatcher, true);
                $this->assertEquals(array($handler1, $handler2), $this->channel->getListeners('test'));
	}


}
