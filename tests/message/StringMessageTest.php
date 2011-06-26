<?php 

use \PEIP\Message\GenericMessage as PEIP_Generic_Message;
use \PEIP\INF\Message\Message as PEIP_INF_Message;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

require_once dirname(__FILE__).'/GenericMessageTest.php';
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/PayloadMock.php');

class StringMessageTest extends GenericMessageTest { 

	protected $testClass  = '\PEIP\Message\StringMessage'; 

	
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
    		$this->messages[$type] = new \PEIP\Message\StringMessage($payload);
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
        	$message = new \PEIP\Message\StringMessage($payload, $headers);
        	$this->assertMessage($message);
    		$this->assertPayloads($message, $type);
    		$this->assertEquals($headers, $message->getHeaders());		
    	} 		
	}    

    public function testToString(){
    	$text = 'foo';
    	$message = new \PEIP\Message\StringMessage($text);
    	$this->assertEquals($text, (string)$message);  
    }
	
    
    public function testBuild(){
        foreach($this->payloads as $type=>$payload){
        	$message = $this->build(array($payload));
        	$this->assertMessage($message);
    		$this->assertPayloads($message, $type);	
    	}    	    		   
    }   

    public function testBuildHeader(){
        $headers = $this->getHeaders();
    	foreach($this->payloads as $type=>$payload){
        	$message = $this->build(array($payload, $headers));
        	$this->assertMessage($message);
    		$this->assertPayloads($message, $type);
    		$this->assertEquals($headers, $message->getHeaders());	
    	}    	    		   
    } 
    


	protected function assertMessage($message){
        $this->assertTrue(is_object($message));
    	$this->assertTrue($message instanceof \PEIP\Message\GenericMessage, 'message (with class:"'.get_class($message).'")not instanceof PEIP_Generic_Message');
    	$this->assertTrue($message instanceof \PEIP\Message\StringMessage, 'message (with class:"'.get_class($message).'")not instanceof PEIP_String_Message');
    	$this->assertTrue($message instanceof \PEIP\INF\Message\Message, 'message (with class:"'.get_class($message).'")not instanceof PEIP_Message_Interface');
    }
    
	protected function assertPayloads($message, $type){
		$this->assertEquals((string)$this->payloads[$type], $message->getContent());
	}  	
  
       
	
	protected function build($parameter){ 
		return call_user_func(array('\PEIP\Message\StringMessage', 'build'), $parameter);
	}
	
}