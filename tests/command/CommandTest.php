<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/CallableMock.php');

class CommandTest extends PHPUnit_Framework_TestCase {

	
	public function setup(){
	
	
	}
	
	public function testExecuteStatic(){
		$callable = array('CallableMock', 'repeatStatic');
		$command = new PEIP_Command($callable, array('Test'));
		$this->assertEquals(CallableMock::repeatStatic('Test'), $command->execute());	
	} 
	
	public function testExecuteInstance(){
		$inst = new CallableMock;
		$callable = array($inst, 'repeat');
		$command = new PEIP_Command($callable, array('Test'));
		$this->assertEquals(CallableMock::repeat('Test'), $command->execute());	
	}		
	
	public function testExecuteFunction(){
		$callable = 'callable_mock_function';
		$command = new PEIP_Command($callable, array('Test'));
		$this->assertEquals(callable_mock_function('Test'), $command->execute());	
	}	

	public function testInvoke(){
		$callable = 'callable_mock_function';
		$command = new PEIP_Command($callable, array('Test'));
		$this->assertEquals($command->execute(), $command->__invoke());	
	}	
	
	
	
	
}