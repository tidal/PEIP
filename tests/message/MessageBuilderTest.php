<?php 

use \PEIP\INF\Message\Message as PEIP_INF_Message;
use \PEIP\Message\StringMessage as PEIP_String_Message;
require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class MessageBuilderTest 
	extends PHPUnit_Framework_TestCase {

	protected $builder;

	public function setup(){
		$this->builder = new PEIP\Message\MessageBuilder;
	}

	public function testCopyHeaders(){
		$headers = array('foo'=>'bar', 'do'=>'test');
		$this->assertEquals(array(), $this->builder->getHeaders());
		$this->builder->copyHeaders($headers);
		$this->assertEquals($headers, $this->builder->getHeaders());
	}
	
	public function testCopyHeadersIfAbsent(){
		$headers1 = array('foo'=>'bar', 'do'=>'test');
		$this->builder->copyHeaders($headers1);
		$this->assertEquals($headers1, $this->builder->getHeaders());
		$headers2 = array('bar'=>'foo', 'do'=>'it');
		$this->builder->copyHeadersIfAbsent($headers2);
		$this->assertEquals(array('foo'=>'bar', 'do'=>'test', 'bar'=>'foo'), $this->builder->getHeaders());
	}	
		
	public function testRemoveHeader(){
		$headers = array('foo'=>'bar', 'do'=>'test');
		$this->builder->copyHeaders($headers);
		$this->assertEquals($headers, $this->builder->getHeaders());
		$this->builder->removeHeader('foo');
		$this->assertEquals(array('do'=>'test'), $this->builder->getHeaders());
	}	
	
	public function testSetHeader(){
		$headers = array('foo'=>'bar');
		$this->assertEquals(array(), $this->builder->getHeaders());
		$this->builder->setHeader('foo', 'bar');
		$this->assertEquals($headers, $this->builder->getHeaders());
	}	
		
	public function testSetHeaders(){
		$headers1 = array('foo'=>'bar', 'do'=>'test');
		$this->builder->SetHeaders($headers1);
		$this->assertEquals($headers1, $this->builder->getHeaders());
		$headers2 = array('bar'=>'foo', 'do'=>'it');
		$this->builder->SetHeaders($headers2);
		$this->assertEquals($headers2, $this->builder->getHeaders());
	}	

	public function testBuild(){
		$this->assertTrue($this->builder->build() instanceof PEIP_INF_Message);	
	}
	
	public function testBuildHeaders(){		
		$headers1 = array('foo'=>'bar', 'do'=>'test');
		$this->builder->setHeaders($headers1);
		$message1 = $this->builder->build();
		$this->assertEquals('bar', $message1->getHeader('foo'));
		$headers2 = array('bar'=>'foo', 'do'=>'it');
		$message2 = $this->builder->build($headers2);
		$this->assertEquals('foo', $message2->getHeader('bar'));
	}	
	
	public function testSetContent(){
		$this->builder->setContent(321);
		$message = $this->builder->build();
		$this->assertEquals(321, $message->getContent());	
	}
	
	public function testSetMessageClass(){
		$this->builder->setMessageClass('\PEIP\Message\StringMessage');
		$this->assertTrue($this->builder->build() instanceof \PEIP\Message\StringMessage);
	}

	public function testGetMessageClass(){
		$this->builder->setMessageClass('PEIP_String_Message');
		$this->assertEquals('PEIP_String_Message', $this->builder->getMessageClass());
	}

	public function testGetInstance(){
		$this->assertTrue(PEIP\Message\MessageBuilder::getInstance() instanceof PEIP\Message\MessageBuilder);
	}
	
	public function testGetInstanceFromMessage(){
		$message = new PEIP\Message\StringMessage('test');
		$builder = PEIP\Message\MessageBuilder::getInstanceFromMessage($message);
		$this->assertEquals('PEIP\Message\StringMessage', $builder->getMessageClass());
	}	
} 