<?php
require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandlerEvent.php';
require_once dirname(__FILE__).'/../_files/CallableObject.php';

class EventBuilderTest 
	extends PHPUnit_Framework_TestCase {
		
	public function testGetInstance(){
            $builder = PEIP_Event_Builder::getInstance();
            $this->assertSame($builder, PEIP_Event_Builder::getInstance());
	} 

	public function testBuild(){
            $builder = new PEIP_Event_Builder;
            $this->assertTrue($builder->build(321, 'foo') instanceof PEIP_INF_Event);
	}	
	
	public function testBuildAndDispatch(){
            $builder = new PEIP_Event_Builder;
            $dispatcher = new PEIP_Object_Event_Dispatcher();
            $callable = new CallableObject($this);
            $callable->setObject($builder);
            $dispatcher->connect('foo', $builder, new PublishSubscribeHandlerEvent($this));
            $builder->buildAndDispatch($dispatcher, $builder, 'foo');
	}
	
} 
