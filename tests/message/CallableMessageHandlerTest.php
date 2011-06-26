<?php 


use \PEIP\Message\CallableMessageHandler as PEIP_Callable_Message_Handler;
use \PEIP\Message\GenericMessage as PEIP_Generic_Message;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/CallableMessageHandlerMock.php');

class CallableMessageHandlerTest extends PHPUnit_Framework_TestCase  {

	public function testCallableMessageHandlerMock() {
		$mock = new CallableMessageHandlerMock();
		$this->assertEquals('Hello', $mock->reply('Hello'));
		$this->assertEquals('Hello', CallableMessageHandlerMock::replyStatic('Hello'));
	}
	
	

	public function testConstructions(){
            $handler = new PEIP_Callable_Message_Handler(array('CallableMessageHandlerMock', 'replyStatic'));
            $this->assertTrue($handler instanceof PEIP_Callable_Message_Handler);
            $handler = new PEIP_Callable_Message_Handler('trim');
            $this->assertTrue($handler instanceof PEIP_Callable_Message_Handler);
            $mock = new CallableMessageHandlerMock();
            $handler = new PEIP_Callable_Message_Handler(array($mock, 'reply'));
            $this->assertTrue($handler instanceof PEIP_Callable_Message_Handler);
            $handler = new PEIP_Callable_Message_Handler(array('CallableMessageHandlerMock', 'replyStatic'));
            $this->assertTrue($handler instanceof PEIP_Callable_Message_Handler);
	}

	public function testNoCallableException(){
        try{
        	$handler = new PEIP_Callable_Message_Handler(321);
        }
    	catch (Exception $expected) {
	        try{
	        	$string = 'this_is_not_a_functon_name';
	        	if(!function_exists($string)){
	        		$handler = new PEIP_Callable_Message_Handler($string);
	        	}	
	        }
	    	catch (Exception $expected) {
	            return;
	        } 
    	}   
        $this->fail('An expected exception has not been raised.'); 	
	} 
	
	
	public function testStaticException(){
        try{
        	$handler = new PEIP_Callable_Message_Handler(array('CallableMessageHandlerMock', 'reply'));
        }
    	catch (Exception $expected) {
 
	        return;
    	}   
        $this->fail('An expected exception has not been raised.'); 	
	} 	
	
	public function testHandle(){
		$message = new PEIP_Generic_Message(321);
		$handler = new PEIP_Callable_Message_Handler(array('CallableMessageHandlerMock', 'replyStatic'));	
		$this->assertEquals($message, $handler->handle($message));
	}
	
	public function testHandleException(){
        try{
        	$handler = new PEIP_Callable_Message_Handler(array('CallableMessageHandlerMock', 'replyStatic'));
        	$handler->handle(321);
        }
    	catch (Exception $expected) {
 
	        return;
    	}   
        $this->fail('An expected exception has not been raised.'); 
	}	

	public function testCallableException(){
        try{
        	$message = new PEIP_Generic_Message(321);
        	$handler = new PEIP_Callable_Message_Handler(array('CallableMessageHandlerMock', 'throwException'));
        	$handler->handle($message);
        }
    	catch (Exception $expected) {
 
	        return;
    	}   
        $this->fail('An expected exception has not been raised.'); 
	}	
	
} 
