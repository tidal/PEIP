<?php
require_once __DIR__.'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(__DIR__.'/../_files/InterceptableMessageChannel.php');
PHPUnit_Util_Fileloader::checkAndLoad(__DIR__.'/../_files/MessageChannelInterceptor.php');

class InterceptableMessageChannelTest extends PHPUnit_Framework_TestCase {

	
	public function testMessageChannelInterceptor(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$interceptor = new MessageChannelInterceptor(1);
		$message = new PEIP_Generic_Message(321);
		$interceptor->postSend($message, $channel, true);
		$this->assertEquals($message, $interceptor->message);
	}
	
	
	public function testConstruction(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$this->assertTrue($channel instanceof InterceptableMessageChannel);
	}	

	public function testGetName(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$this->assertEquals('TestChannel', $channel->getName());
	}	
	
	public function testSetInterceptorDispatcher(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$dispatcher = new PEIP_Interceptor_Dispatcher();
		$channel->setInterceptorDispatcher($dispatcher);
		$this->assertEquals($dispatcher, $channel->getInterceptorDispatcher());
	}

	public function testAddInterceptor(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$iterceptor = new MessageChannelInterceptor;
		$channel->addInterceptor($iterceptor);
		$this->assertEquals(array($iterceptor), $channel->getInterceptors());
		$channel->addInterceptor($iterceptor);
		$this->assertEquals(array($iterceptor), $channel->getInterceptors());
		$iterceptor2 = new MessageChannelInterceptor;
		$channel->addInterceptor($iterceptor2);
		$this->assertEquals(array($iterceptor, $iterceptor2), $channel->getInterceptors());		
	}
	
	public function testSetInterceptors(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$iterceptor1 = new MessageChannelInterceptor(1);
		$iterceptor2 = new MessageChannelInterceptor(2);
		$channel->setInterceptors(array($iterceptor1, $iterceptor2));
		$this->assertEquals(array($iterceptor1, $iterceptor2), $channel->getInterceptors());		
		$iterceptor3 = new MessageChannelInterceptor(3);
		$iterceptor4 = new MessageChannelInterceptor(4);
		$channel->setInterceptors(array($iterceptor3, $iterceptor4));
		$this->assertEquals(array($iterceptor3, $iterceptor4), $channel->getInterceptors());
		$this->assertNotEquals(array($iterceptor1, $iterceptor2), $channel->getInterceptors());
	}	
	
	public function testDeleteInterceptors(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$iterceptor1 = new MessageChannelInterceptor(1);
		$iterceptor2 = new MessageChannelInterceptor(2);
		$channel->setInterceptors(array($iterceptor1, $iterceptor2));
		$this->assertEquals(array($iterceptor1, $iterceptor2), $channel->getInterceptors());
		$channel->clearInterceptors();		
		$iterceptor3 = new MessageChannelInterceptor(3);
		$this->assertEquals(array(), $channel->getInterceptors());
	}	
	
	public function testSend(){
		$channel = new InterceptableMessageChannel('TestChannel');
		$iterceptor1 = new MessageChannelInterceptor(1);
		$channel->addInterceptor($iterceptor1);
		$message = new PEIP_Generic_Message(321);	
		$channel->send($message);
	}
	
	
}