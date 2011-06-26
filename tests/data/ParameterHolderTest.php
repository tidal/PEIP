<?php 


use \PEIP\Data\ParameterHolder as PEIP_Parameter_Holder;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class ParameterHolderTest  extends PHPUnit_Framework_TestCase {

    public function setup(){
    	//test provider
    	$holder = self::provider();
    	$this->assertTrue($holder instanceof PEIP_Parameter_Holder);
    
    }

	public static function provider()
    {
        return new PEIP_Parameter_Holder();
    }
	
	
    /**
     * @dataProvider provider
     */
    public function testAccessors($holder = NULL){
    	$holder = $holder ? $holder : self::provider();
    	$holder->setParameter('foo', 'bar');
        $this->assertEquals('bar', $holder->getParameter('foo'));
        $parameters = array(
        	'foo' => 'boo',
        	'test' => 'text'
        );
        $holder->setParameters($parameters);
        $this->assertEquals($parameters, $holder->getParameters());
    }	
	
    /**
     * @dataProvider provider
     */
    public function testHas($holder = NULL){
    	$holder = $holder ? $holder : self::provider();
    	$holder->setParameter('foo', 'bar');
        $this->assertTrue($holder->hasParameter('foo')); 
    }	
	
    /**
     * @dataProvider provider
     */
    public function testDelete($holder = NULL){
    	$holder = $holder ? $holder : self::provider();
    	$holder->setParameter('foo', 'bar');
        $this->assertTrue($holder->hasParameter('foo'));
        $holder->deleteParameter('foo');
        $this->assertNotEquals('bar', $holder->getParameter('foo'));
        $this->assertFalse($holder->hasParameter('foo'));
    }
    
    /**
     * @dataProvider provider
     */
    public function testAdd($holder = NULL){
        $parameters = array(
        	'foo' => 'bar',
        	'test' => 'text'
        );
        $parameters2 = array(
        	'foo' => 'boo',
        	'text' => 'test'
        );
        $merge = array(
        	'foo' => 'boo',
        	'test' => 'text',
        	'text' => 'test'        
        );
        $merge2 = array(
        	'foo' => 'bar',
        	'test' => 'text',
        	'text' => 'test'        
        );
        $holder = self::provider();
    	$holder->addParameters($parameters);
        $this->assertEquals($parameters, $holder->getParameters());
        
        $holder = self::provider();
    	$holder->setParameters($parameters);
        $this->assertEquals($parameters, $holder->getParameters());
        $holder->addParameters($parameters2);
        $this->assertEquals($merge, $holder->getParameters());    
       
        $holder = self::provider();
    	$holder->setParameters($parameters);
        $this->assertEquals($parameters, $holder->getParameters());
        $holder->addParametersIfNot($parameters2);
        $this->assertEquals($merge2, $holder->getParameters());          
    
    }    

}