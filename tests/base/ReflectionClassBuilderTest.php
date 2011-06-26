<?php 

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class ReflectionClassBuilderTest extends PHPUnit_Framework_TestCase {


	public function testBuild(){
		$reflection = PEIP\Base\ReflectionClassBuilder::getInstance('PEIP\Base\ReflectionClassBuilder');
		$this->assertTrue(is_object($reflection));	
		$this->assertTrue($reflection instanceof ReflectionClass);
		$this->assertEquals('PEIP\Base\ReflectionClassBuilder', $reflection->getName());
	}
	
	public function testGetInstance(){
		$reflection = \PEIP\Base\ReflectionClassBuilder::getInstance('\PEIP\Base\ReflectionClassBuilder');
		$reflection2 = \PEIP\Base\ReflectionClassBuilder::getInstance('\PEIP\Base\ReflectionClassBuilder');
		$this->assertSame($reflection, $reflection2);	
	}	


}