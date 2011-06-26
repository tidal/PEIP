<?php 


use \PEIP\Base\Sealer as PEIP_Sealer;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/SealerBoxMock.php');



class SealerTest extends PHPUnit_Framework_TestCase {

	
	public function testConstruction(){ 
		$sealer = new PEIP_Sealer;
		$this->assertTrue(is_object($sealer));	
		$this->assertTrue($sealer instanceof PEIP_Sealer);		
		$sealer = new PEIP_Sealer(new SplObjectStorage);
		$this->assertTrue(is_object($sealer));	
		$this->assertTrue($sealer instanceof PEIP_Sealer);		
	}
	
	public function testSeal(){
		$sealer = new PEIP_Sealer;
		$box = $sealer->seal('foo');
		$this->assertTrue(is_object($box));	
	}	
	
	public function testSealBox(){
		$box = new SealerBoxMock;
		$sealer = new PEIP_Sealer;
		$box2 = $sealer->seal('foo', $box);
		$this->assertSame($box, $box2);	
	}	

	public function testUnseal(){
		$sealer = new PEIP_Sealer;
		$value = 'foo';
		$box = $sealer->seal($value);
		$value2 = $sealer->unseal($box);
		$this->assertEquals($value, $value2);	
	}	
	

}