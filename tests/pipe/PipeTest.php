<?php 


use \PEIP\Channel\PollableChannel as PEIP_Pollable_Channel;
use \PEIP\Message\GenericMessage as PEIP_Generic_Message;
use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

require_once dirname(__FILE__).'/../_files/Pipe.php';
require_once dirname(__FILE__).'/../_files/SimpleHandler.php';


class PipeTest extends PHPUnit_Framework_TestCase {


    protected $dispatcher;

    public function setup(){
        $this->pipe = new DefaultPipe;
    }

    public function testSetName(){
        $this->pipe->setName('foo');
        $this->assertEquals('foo', $this->pipe->getName());
    }

    public function testSendPush(){ 
        $receiveCh = new PEIP_Pollable_Channel('receive');
        $message = new PEIP_Generic_Message('foo');
        $this->pipe->setOutputChannel($receiveCh);
        $this->pipe->send($message);
        $this->assertEquals($message, $receiveCh->receive());
    }

    public function testSendAsynch(){
        $receiveCh1 = new SimpleHandler();
        $receiveCh2 = new SimpleHandler();
        $message = new PEIP_Generic_Message('foo');
        $this->pipe->subscribe($receiveCh1);
        $this->pipe->subscribe($receiveCh2);
        $this->pipe->send($message);
        $this->assertEquals($message, $receiveCh1->subject);
        $this->assertEquals($message, $receiveCh2->subject);
    }

    public function testSubscribeUnsubscribe(){
        $receiveCh1 = new SimpleHandler();
        $message = new PEIP_Generic_Message('foo');
        $this->pipe->subscribe($receiveCh1);        
        $this->pipe->send($message);
        $this->assertEquals($message, $receiveCh1->subject);
        $this->pipe->unsubscribe($receiveCh1);
        $receiveCh1->subject = NULL;
        $this->pipe->send($message);
        $this->assertNotEquals($message, $receiveCh1->subject);
    }


    public function testConnect(){
        $this->assertFalse($this->pipe->hasListeners('preSend'));
        $handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
        $this->pipe->connect('preSend', $handler);
        $this->assertTrue($this->pipe->hasListeners('preSend'));
        $this->pipe->disconnect('preSend', $handler);
    }

    public function testDisconnect(){
        $handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
        $this->pipe->connect('preSend', $handler);
        $this->assertTrue($this->pipe->hasListeners('preSend'));
        $this->pipe->disconnect('preSend', $handler);
        $this->assertFalse($this->pipe->hasListeners('preSend'));
    }




}