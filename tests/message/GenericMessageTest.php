<?php 


use \PEIP\INF\Message\Message as PEIP_INF_Message;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/PayloadMock.php');
 


class GenericMessageTest extends PHPUnit_Framework_TestCase {

	protected $message;
	
	protected $messages = array();
	
	protected $payloadObject;

	protected $payloads = array();
	
	protected $testClass = '\PEIP\Message\GenericMessage'; 
	
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
    		$this->messages[$type] = new \PEIP\Message\GenericMessage($payload);
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
        $message = new \PEIP\Message\GenericMessage($this->payloads['string'], $headers);
		foreach($headers as $name=>$header){
    		$this->assertEquals($headers[$name], $message->getHeader($name));		
    	} 		
	}
    
	public function testHasHeaders(){
        $headers = $this->getHeaders();
        $message = new \PEIP\Message\GenericMessage($this->payloads['string'], $headers);
		foreach($headers as $name=>$header){
    		$this->assertTrue($message->hasHeader($name));		
    	} 		
	}
	public function testHeaders(){
        $headers = $this->getHeaders();
		foreach($this->payloads as $type=>$payload){
        	$message = new \PEIP\Message\GenericMessage($payload, $headers);
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
            new \PEIP\Message\GenericMessage($this->payloads['string'], 123);
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
            new \PEIP\Message\GenericMessage($this->payloads['string'], 123.123);
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
            new \PEIP\Message\GenericMessage($this->payloads['string'], 'Test');
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
            new \PEIP\Message\GenericMessage($this->payloads['string'], $object);
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
       // new \PEIP\Message\GenericMessage($this->payload, 123);
	}
	
    /**
     * 
     */	
	public function testFailBuildWrongHeaderFloat(){
       // new \PEIP\Message\GenericMessage($this->payload, 123.321);
	}
	
    /**
     * 
     */	
	public function testFailBuildWrongHeaderString(){
      //  new \PEIP\Message\GenericMessage($this->payload, 'Test');
	}

    /**
     * 
     */	
	public function testFailBuildWrongHeaderObject(){
     //   new \PEIP\Message\GenericMessage($this->payload, new stdClass);
	}    
   
    
   // helper methods 
    
    protected function assertMessage($message){
        $this->assertTrue(is_object($message));
    	$this->assertTrue($message instanceof PEIP\INF\Message\Message);
        $this->assertTrue($message instanceof PEIP\Message\GenericMessage);
    }
    
	protected function assertPayloads($message, $type){
		$this->assertEquals($this->payloads[$type], $message->getContent());
	}    

	protected function build($parameter){
		return call_user_func(array('PEIP\Message\GenericMessage', 'build'), $parameter);
	}
	
	
}
