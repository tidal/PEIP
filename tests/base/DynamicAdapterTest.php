<?php

require_once __DIR__.'/../../misc/bootstrap.php';
PHPUnit_Util_Fileloader::checkAndLoad(__DIR__.'/../_files/DynamicAdapterMock.php');

class DynamicAdapterTest extends PHPUnit_Framework_TestCase  {

	protected function getMap(){
		return 	new ArrayObject(array(
			'getValue' => 'getEcho'
		));	
	}
	
	public function testDynamicAdapterMock(){
		$mock = new DynamicAdapterMock;
		$this->assertTrue(method_exists($mock, 'getEcho'));
		$this->assertEquals('foo', $mock->getEcho('foo'));
	}
	
	
	public function testConstruction(){ 
		$map = $this->getMap();
		$mock = new DynamicAdapterMock;
		$adapter = new PEIP_Dynamic_Adapter($map, $mock);
		$this->assertTrue(is_object($adapter));	
		$this->assertTrue($adapter instanceof PEIP_Dynamic_Adapter);
				
	}

	public function testCall(){ 
		$map = $this->getMap();
		$mock = new DynamicAdapterMock;
		$adapter = new PEIP_Dynamic_Adapter($map, $mock);
		$this->assertEquals('foo', $adapter->__call('getValue', array('foo')));
		$this->assertEquals('foo', $adapter->getValue('foo'));				
	}	
	
	public function testWrongCall(){ 
		$map = $this->getMap();
		$mock = new DynamicAdapterMock;
		$adapter = new PEIP_Dynamic_Adapter($map, $mock);
		$this->assertNotEquals('foo', $adapter->__call('getValues', array('foo')));
		$this->assertNotEquals('foo', $adapter->getValues('foo'));				
	}	
}
