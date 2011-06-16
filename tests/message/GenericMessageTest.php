<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/PayloadMock.php');
 


class GenericMessageTest extends PHPUnit_Framework_TestCase {

	protected $message;
	
	protected $messages = array();
	
	protected $payloadObject;

	protected $payloads = array();
	
	protected $testClass = 'PEIP_Generic_Message';
	
	public function MessageTest(){
	
	}

	
	
	protected function setUp()
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
    		$this->messages[$type] = new $this->testClass($payload);	
    	}
		$this->assertEquals(count($this->messages), count($this->payloads));
    
    }

    protected function getHeaders(){
    	return array(
        	'foo' => 'bar',
        	'message' => 'test'
        );
    }
    
	
    public function testConstructions(){
        foreach($this->messages as $type=>$message){
        	$this->assertMessage($message);	
    	}    	
    		   
    }    
    
    public function testGetContents(){
        foreach($this->messages as $type=>$message){
    		$func = 'is_'.$type;
        	$this->assertEquals($message->getContent(), $message->getContent());
    		$this->assertTrue(call_user_func($func, $message->getContent()), 'payload != '.$type);       	
        	$this->assertEquals($this->payloads[$type], $message->getContent());	
    	}     
    }    
    
	public function testGetHeaders(){
        $headers = $this->getHeaders();
        $message = new $this->testClass($payload, $headers);
		foreach($headers as $name=>$header){
    		$this->assertEquals($headers[$name], $message->getHeader($name));		
    	} 		
	}
    
	public function testHasHeaders(){
        $headers = $this->getHeaders();
        $message = new $this->testClass($payload, $headers);
		foreach($headers as $name=>$header){
    		$this->assertTrue($message->hasHeader($name));		
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
	
	
    /**
     * 
     */	
	public function testFailWrongHeaderInt(){
        try{
            new $this->testClass($this->payload, 123);
        }
        catch(InvalidArgumentException $e){
            return;
        }
        

        $this->fail('InvalidArgumentException expected');
	}
	
    /**
     * 
     */	
	public function testFailWrongHeaderFloat(){
        try{
            new $this->testClass($this->payload, 123.123);
        }
        catch(InvalidArgumentException $e){
            return;
        }


        $this->fail('InvalidArgumentException expected');
	}
	
    /**
     * 
     */	
	public function testFailWrongHeaderString(){
        try{
            new $this->testClass($this->payload, 'Test');
        }
        catch(InvalidArgumentException $e){
            return;
        }


        $this->fail('InvalidArgumentException expected');
	}

    /**
     * 
     */	
	public function testFailWrongHeaderObject(){
        $object = new stdClass;
        try{
            new $this->testClass($this->payload, $object);
        }
        catch(InvalidArgumentException $e){
            return;  
        }


        $this->fail('InvalidArgumentException expected');
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
    
    public function testBuildException(){
        try{
        	$message = $this->build(array());
        }
    	catch (Exception $expected) {
            return;
        }   
        $this->fail('An expected exception has not been raised.'); 	    		   
    }     

    /**
     *  
     */	
	public function testFailBuildWrongHeaderInt(){
       // new $this->testClass($this->payload, 123);
	}
	
    /**
     * 
     */	
	public function testFailBuildWrongHeaderFloat(){
       // new $this->testClass($this->payload, 123.321);
	}
	
    /**
     * 
     */	
	public function testFailBuildWrongHeaderString(){
      //  new $this->testClass($this->payload, 'Test');
	}

    /**
     * 
     */	
	public function testFailBuildWrongHeaderObject(){
     //   new $this->testClass($this->payload, new stdClass);
	}    
   
    
   // helper methods 
    
    protected function assertMessage($message){
        $this->assertTrue(is_object($message));
    	$this->assertTrue($message instanceof PEIP_Generic_Message);
    	$this->assertTrue($message instanceof PEIP_INF_Message);    
    }
    
	protected function assertPayloads($message, $type){
		$this->assertEquals($this->payloads[$type], $message->getContent());
	}    

	protected function build($parameter){
		return call_user_func(array('PEIP_Generic_Message', build), $parameter);
	}
	
	
}
