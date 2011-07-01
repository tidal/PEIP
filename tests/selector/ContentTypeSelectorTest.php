<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class ContentTypeSelectorTest
	extends PHPUnit_Framework_TestCase {

    protected 
        $types = array(
            'string' => 'foo',
            'int' => 1,
            'float' => 1.1,
            'numeric' => 2,
            'bool' => true,
            'boolean' => false,
            'array' => array(1),
            'scalar' => 'bar'
        );

    public function setup(){

    }

    public function teardown(){}


    public function testConstruct(){
        foreach($this->types as $type=>$value){
            $selector = new \PEIP\Selector\ContentTypeSelector($type);
            $this->assertTrue(is_object($selector));
        }
    }

    public function testConstructException(){
        $type = 'foo';
        try{
            $selector = new \PEIP\Selector\ContentTypeSelector($type);
        }
        catch(Exception $e){
            return;
        }
        $this->fail('An Exception should have been thrown');
    }



    public function testAccept(){
        foreach($this->types as $type=>$value){
            $selector = new \PEIP\Selector\ContentTypeSelector($type);
            $message = new \PEIP\Message\GenericMessage($value);
            $this->assertTrue($selector->acceptMessage($message));
        }
    }

    public function testDecline(){
        foreach($this->types as $type=>$value){
            $value = $type == 'array' ? 'foo' : array();
            $selector = new \PEIP\Selector\ContentTypeSelector($type);
            $message = new \PEIP\Message\GenericMessage($value);
            $this->assertFalse($selector->acceptMessage($message));
        }
    }


}

