<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';



class IteratingDispatcherTest extends PHPUnit_Framework_TestCase {


    protected $dispatcher;

    public function setup(){
        $this->dispatcher = new PEIP_Iterating_Dispatcher;
    }

    public function testConnect(){
        $this->assertFalse($this->dispatcher->hasListeners());
        $handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
        $this->dispatcher->connect($handler);
        $this->assertTrue($this->dispatcher->hasListeners());      
    }

    public function testDisconnect(){
        $this->assertFalse($this->dispatcher->hasListeners());
        $handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
        $this->dispatcher->connect($handler);
        $this->assertTrue($this->dispatcher->hasListeners());
        $this->dispatcher->disconnect($handler);
        $this->assertFalse($this->dispatcher->hasListeners());
    }

    public function testgetListeners(){
        $this->assertFalse($this->dispatcher->hasListeners());
        $handler1 = new PEIP_Callable_Handler(array('TestClass','TestMethod1'));
        $handler2 = new PEIP_Callable_Handler(array('TestClass','TestMethod2'));
        $this->dispatcher->connect($handler1);
        $this->dispatcher->connect($handler2);
        $this->assertEquals(array($handler1, $handler2), $this->dispatcher->getListeners());
    }

    public function testNotify(){
        return;
        $interceptor1 = new MessageChannelInterceptor ;
        $interceptor2 = new MessageChannelInterceptor ;
        $handler1 = new PEIP_Callable_Handler(array($interceptor1,'callback'));
        $handler2 = new PEIP_Callable_Handler(array($interceptor2,'callback'));
        $this->dispatcher->connect($handler1);
        $this->dispatcher->connect($handler2);
        $this->dispatcher->notify('foo');
        $this->assertEquals('foo', $interceptor1->message);
        $this->assertNotEquals('foo', $interceptor2->message);
        $this->dispatcher->notify('bar');
        $this->assertEquals('bar', $interceptor2->message);
        $this->assertNotEquals('bar', $interceptor1->message);
    }

}




