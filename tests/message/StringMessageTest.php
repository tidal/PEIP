<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

require_once dirname(__FILE__).'/GenericMessageTest.php';
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/PayloadMock.php');

class StringMessageTest extends GenericMessageTest { 

	protected $testClass  = 'PEIP_String_Message';

	
	protected function setUp()
    {
    	$this->testClass = 'PEIP_String_Message';
    	//$this->setName('MessageTest');
    	$this->payloadObject = new PayloadMock();
    	
    	$this->payloads = array(
    		'null' => NULL,
    		'int' => 123,
    		'float' => 123.123,
    		'string' => 'Test',
    		'object' => $this->payloadObject	
    	);
 
    	foreach($this->payloads as $type=>$payload){
    		$this->messages[$type] = new $this->testClass($payload);	
    	}
		$this->assertEquals(count($this->messages), count($this->payloads));
    
    }

    public function testGetContents(){
        foreach($this->messages as $type=>$message){
        	$this->assertEquals($message->getContent(), $message->getContent());
    		$this->assertTrue(is_string($message->getContent()), 'payload != string -> '.$type.' : '.print_r($message->getContent(), 1));       	
        	$this->assertEquals((string)$this->payloads[$type], $message->getContent());	
    	}     
    }      

	public function testHeaders(){
        $headers = $this->getHeaders();
		foreach($this->payloads as $type=>$payload){
        	$message = new $this->testClass($payload, $headers);
        	$this->assertMessage($message);
    		$this->assertPayloads($message, $type);
    		$this->assertEquals($headers, $message->getHeaders());		
    	} 		
	}    

    public function testToString(){
    	$text = 'foo';
    	$message = new PEIP_String_Message($text);
    	$this->assertEquals($text, (string)$message);  
    }
	
	
	protected function assertMessage($message){
        $this->assertTrue(is_object($message));
    	$this->assertTrue($message instanceof PEIP_Generic_Message, 'message (with class:"'.get_class($message).'")not instanceof PEIP_Generic_Message');
    	$this->assertTrue($message instanceof PEIP_String_Message, 'message (with class:"'.get_class($message).'")not instanceof PEIP_String_Message');
    	$this->assertTrue($message instanceof PEIP_INF_Message, 'message (with class:"'.get_class($message).'")not instanceof PEIP_Message_Interface');    
    }
    
	protected function assertPayloads($message, $type){
		$this->assertEquals((string)$this->payloads[$type], $message->getContent());
	}  	
  
       
	
	protected function build($parameter){
		return call_user_func(array('PEIP_String_Message', 'build'), $parameter);
	}
	
}