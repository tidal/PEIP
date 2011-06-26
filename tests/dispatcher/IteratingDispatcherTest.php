<?php 


use \PEIP\Dispatcher\IteratingDispatcher as PEIP_Iterating_Dispatcher;
use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;

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

        $test = $this;
        $this->handlersCalled = array_fill(0, 3, false);
        foreach($this->handlersCalled as $key=>$value){
            $this->dispatcher->connect(function($subject)use($test, $key){

                $test->assertEquals($key, $subject);
                $test->handlersCalled[$key] = true;

            });         
        }

        foreach($this->handlersCalled as $key=>$value){
            $this->dispatcher->notify($key);
            $this->assertTrue($test->handlersCalled[$key]);

        }

    }

    public function testDisconnectAll(){
        $this->assertFalse($this->dispatcher->hasListeners());
        $handler = new PEIP_Callable_Handler(array('TestClass','TestMethod'));
        for($x = 1; $x <= 3; $x++){
            $this->dispatcher->connect($handler);
        }
        $this->assertTrue($this->dispatcher->hasListeners());
        $this->dispatcher->disconnectAll();
        $this->assertFalse($this->dispatcher->hasListeners());
    }
}




