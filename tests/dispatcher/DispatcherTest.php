<?php



use \PEIP\Dispatcher\Dispatcher as PEIP_Dispatcher;
use \PEIP\Handler\CallableHandler as PEIP_Callable_Handler;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/CallableObject.php';


class DispatcherTest extends PHPUnit_Framework_TestCase
{
    protected $dispatcher;

    public function setup()
    {
        $this->dispatcher = new PEIP_Dispatcher();
    }

    public function testConnect()
    {
        $listener = new PEIP_Callable_Handler(['TestClass', 'TestMethod']);
        $this->assertFalse($this->dispatcher->hasListeners());
        $this->dispatcher->connect($listener);
        $this->assertTrue($this->dispatcher->hasListeners());
    }

    public function testDisconnect()
    {
        $listener = new PEIP_Callable_Handler(['TestClass', 'TestMethod']);
        $this->dispatcher->connect($listener);
        $this->assertTrue($this->dispatcher->hasListeners());
        $this->dispatcher->disconnect($listener);
        $this->assertFalse($this->dispatcher->hasListeners());
    }

    public function testNotify()
    {
        $object = new stdClass();
        $this->assertFalse($this->dispatcher->hasListeners());
        $callable = new CallableObject($this);
        $callable->setObject($object);
        $listener = new PEIP_Callable_Handler([$callable, 'callNotify']);
        $this->dispatcher->connect($listener);
        $this->dispatcher->notify($object);
    }

    public function testNotifyUntil()
    {
        $object = new stdClass();
        $callable = new CallableObject($this);
        $callable->setObject($object);
        $listeners = [];
        $listener1 = new PEIP_Callable_Handler([$callable, 'callNotify']);
        $this->dispatcher->connect($listener1);
        $breaker = $this->dispatcher->notifyUntil($object);
        $listener2 = new PEIP_Callable_Handler([$callable, 'callUntil']);
        $this->dispatcher->connect($listener2);
        $breaker = $this->dispatcher->notifyUntil($object);
        $listener3 = new PEIP_Callable_Handler([$callable, 'callNoMore']);
        $this->dispatcher->connect($listener3);
        $breaker = $this->dispatcher->notifyUntil($object);
        $this->assertSame($listener2, $breaker);
    }
}
