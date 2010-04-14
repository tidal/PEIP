<?php

require_once __DIR__.'/../../misc/bootstrap.php';
require_once __DIR__.'/../message/GenericMessageTest.php';

class EventTest 
	extends PHPUnit_Framework_TestCase {

	protected $testClass = 'PEIP_Event';	


	public function setUp()
    {
    	//$this->setName('MessageTest');
    	$this->payloadObject = new PayloadMock();
    	
    	$this->payloads = array(
    		'null' => NULL,
    		'int' => 123,
    		'float' => 123.123,
    		'string' => 'Test',
    		'array' => array('foo', 'bar'),
    		'object' => $this->payloadObject	
    	);
 
    	foreach($this->payloads as $type=>$payload){
    		$this->messages[$type] = new $this->testClass($payload, $type);	
    	}
		$this->assertEquals(count($this->messages), count($this->payloads));
    
    }	

    public function testGetName(){
    	foreach($this->messages as $type=>$event){
    		$this->assertEquals($type, $event->getName());
    	}
    }
    
	public function testReturnValue(){
    	$event = new PEIP_Event($this->payloadObject, 'foo');
    	$event->setReturnValue(321);	
    	$this->assertEquals(321, $event->getReturnValue());
    }

	public function testProcessed(){
    	$event = new PEIP_Event($this->payloadObject, 'foo');
    	$event->setProcessed(false);	
    	$this->assertFalse($event->isProcessed());
    	$event->setProcessed(true);	
    	$this->assertTrue($event->isProcessed());
	}
    
	public function testGetHeaders(){
        $headers = $this->getHeaders();
        $message = new $this->testClass($payload, 'foo', $headers);
		foreach($headers as $name=>$header){
    		$this->assertEquals($headers[$name], $message->getHeader($name));		
    	} 		
	}    
    
	public function testHasHeaders(){
        $headers = $this->getHeaders();
        $message = new $this->testClass($payload, 'foo', $headers);
		foreach($headers as $name=>$header){
    		$this->assertTrue($message->hasHeader($name));		
    	} 		
	}
	
	public function testHeaders(){
        $headers = $this->getHeaders();
		foreach($this->payloads as $type=>$payload){
        	$message = new $this->testClass($payload, 'foo', $headers);
        	$this->assertMessage($message);
    		$this->assertPayloads($message, $type);
    		$this->assertEquals($headers, $message->getHeaders());		
    	} 		
	}    

	public function testHeadersArray(){
        $headers = array('foo'=>'bar');
		foreach($this->payloads as $type=>$payload){
        	$message = new $this->testClass($payload, 'foo', $headers);
        	$this->assertMessage($message);
    		$this->assertPayloads($message, $type);
    		$this->assertEquals(new ArrayObject($headers), $message->getHeaders());		
    	} 		
	} 	
	
	public function testFailWrongHeader(){
        try {
			new $this->testClass($this->payload, 'foo', 123); 
        }
        catch(InvalidArgumentException $e){
        	return ;
        }
        $this->fail('An InvalidArgumentException should have been raised');			
	}


	protected function assertPayloads($message, $type){
		$this->assertEquals($this->payloads[$type], $message->getContent());
	} 	
	
	protected function assertMessage($message){
        $this->assertTrue(is_object($message));
    	$this->assertTrue($message instanceof PEIP_Generic_Message);
    	$this->assertTrue($message instanceof PEIP_INF_Message); 
    	$this->assertTrue($message instanceof PEIP_INF_Event);    
    }	

	protected function getHeaders(){
    	return new ArrayObject(array(
        	'foo' => 'bar',
        	'message' => 'test'
        ));
    }    
    
}
