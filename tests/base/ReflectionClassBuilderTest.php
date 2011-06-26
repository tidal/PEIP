<?php 


use \PEIP\Base\ReflectionClassBuilder as PEIP_Reflection_Class_Builder;


require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class ReflectionClassBuilderTest extends PHPUnit_Framework_TestCase {


	public function testBuild(){
		$reflection = PEIP_Reflection_Class_Builder::getInstance('PEIP_Reflection_Class_Builder');
		$this->assertTrue(is_object($reflection));	
		$this->assertTrue($reflection instanceof ReflectionClass);
		$this->assertEquals('PEIP_Reflection_Class_Builder', $reflection->getName());
	}
	
	public function testGetInstance(){
		$reflection = PEIP_Reflection_Class_Builder::getInstance('PEIP_Reflection_Class_Builder');
		$reflection2 = PEIP_Reflection_Class_Builder::getInstance('PEIP_Reflection_Class_Builder');
		$this->assertSame($reflection, $reflection2);	
	}	


}