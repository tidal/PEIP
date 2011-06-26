<?php 


use \PEIP\Base\GenericBuilder as PEIP_Generic_Builder;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/BuilderObjectMock.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/BuilderObjectMockConstructor.php');

class GenericBuilderTest  extends PHPUnit_Framework_TestCase { 




	public function testConstruction(){
		$reflection = new ReflectionClass('BuilderObjectMock');	
		$builder = new PEIP_Generic_Builder('BuilderObjectMock', $reflection);
		$this->assertTrue(is_object($builder));	
		$this->assertTrue($builder instanceof PEIP_Generic_Builder);
	}

	public function testConstructionException(){
        try{
			$reflection = new ReflectionClass('PEIP_Generic_Builder');	
			$builder = new PEIP_Generic_Builder('BuilderObjectMock', $reflection);
        }
    	catch (Exception $expected) {
            return;
        }   
        $this->fail('An expected exception has not been raised.'); 
	}

	public function testGetInstance(){
		$reflection = new ReflectionClass('BuilderObjectMock');	
		$builder = new PEIP_Generic_Builder('BuilderObjectMock', $reflection);	
		$builder2 = PEIP_Generic_Builder::getInstance('BuilderObjectMock');
		$this->assertSame($builder, $builder2);
		$builder3 = PEIP_Generic_Builder::getInstance('BuilderObjectMock');
		$this->assertSame($builder2, $builder3);			
	}	

	public function testStoreRefFalse(){
		$reflection = new ReflectionClass('BuilderObjectMock');	
		$builder = new PEIP_Generic_Builder('BuilderObjectMock', $reflection, false);
		$builder2 = PEIP_Generic_Builder::getInstance('BuilderObjectMock');
		$this->assertNotSame($builder, $builder2);
	}
	
	public function testBuild(){
		$builder = PEIP_Generic_Builder::getInstance('BuilderObjectMock');	
		$object = $builder->build();
		$this->assertTrue(is_object($object));	
		$this->assertTrue($object instanceof BuilderObjectMock);				
	}

	public function testBuilderObjectMockConstructor(){
		$object = new BuilderObjectMockConstructor(1, 2, 3);
		$this->assertEquals(1, $object->a);
		$this->assertEquals(2, $object->b);
		$this->assertEquals(3, $object->c);
	}
	
	public function testBuildConstructor(){
		$builder = PEIP_Generic_Builder::getInstance('BuilderObjectMockConstructor');	
		$object = $builder->build(array(1, 2, 3));
		$this->assertTrue(is_object($object));	
		$this->assertTrue($object instanceof BuilderObjectMockConstructor);
		$this->assertEquals(1, $object->a);
		$this->assertEquals(2, $object->b);
		$this->assertEquals(3, $object->c);
		$object2 = $builder->build(array(1, 2, 3));
		$this->assertNotSame($object, $object2);				
	}	

    /**
     * @expectedException PHPUnit_Framework_Error
     */		
	public function testBuildFailWrongArgs(){
		PEIP_Generic_Builder::getInstance('BuilderObjectMockConstructor')->build(1, 2, 3);				
	}
	
	public function testBuildException(){					
        try{
			PEIP_Generic_Builder::getInstance('BuilderObjectMockConstructor')->build();
        }
    	catch (Exception $expected) {
            return;
        }   
        $this->fail('An expected exception has not been raised.'); 
	}	
	
}