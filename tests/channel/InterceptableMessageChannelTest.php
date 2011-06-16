<?php
require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/InterceptableMessageChannel.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/MessageChannelInterceptor.php');

class InterceptableMessageChannelTest extends PHPUnit_Framework_TestCase {

	
	public function setUp(){
		$this->channel = new InterceptableMessageChannel('TestChannel');
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

	public function testFireEvent(){
		$interceptor = new MessageChannelInterceptor(1);
		$message = new PEIP_Generic_Message(321);
                $handler = new PEIP_Callable_Handler(array($interceptor,'eventCallback'));
                $dispatcher = new PEIP_Object_Event_Dispatcher;
		$this->channel->setEventDispatcher($dispatcher, false);
                $this->channel->connect('preSend', $handler);
                $this->channel->send($message);
		$this->assertEquals($message, $interceptor->message->getHeader('MESSAGE'));
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
