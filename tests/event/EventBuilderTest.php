<?php
require_once __DIR__.'/../../misc/bootstrap.php';

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
		$test = $this;
		$dispatcher->connect('foo', $builder, new PEIP_Callable_Handler(function($event) use($builder, $test){
			$test->assertSame($builder, $event->getContent());
		}));
		$builder->buildAndDispatch($dispatcher, $builder, 'foo');		
	}
	
} 