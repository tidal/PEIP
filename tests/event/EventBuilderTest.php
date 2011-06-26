<?php 

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandlerEvent.php';
require_once dirname(__FILE__).'/../_files/CallableObject.php';

class EventBuilderTest 
	extends PHPUnit_Framework_TestCase {
		
	public function testGetInstance(){
            $builder = \PEIP\Event\EventBuilder::getInstance();
            $this->assertSame($builder, \PEIP\Event\EventBuilder::getInstance());
	} 

	public function testBuild(){
            $builder = new \PEIP\Event\EventBuilder;
            $this->assertTrue($builder->build(321, 'foo') instanceof \PEIP\INF\Event\Event);
	}	
	
	public function testBuildAndDispatch(){
            $builder = new \PEIP\Event\EventBuilder;
            $dispatcher = new \PEIP\Dispatcher\ObjectEventDispatcher();
            $callable = new CallableObject($this);
            $callable->setObject($builder);
            $dispatcher->connect('foo', $builder, new PublishSubscribeHandlerEvent($this));
            $builder->buildAndDispatch($dispatcher, $builder, 'foo');
	}
	
} 
