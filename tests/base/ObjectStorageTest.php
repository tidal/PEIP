<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';


class ObjectStorageTest extends PHPUnit_Framework_TestCase  {

    protected $storage;

    public function setup(){
        $this->storage = new PEIP_Object_Storage();
    }

    public function testCount(){
        for($x = 1; $x < 5; $x++){
            $object = new stdClass();
            $this->storage->attach($object);
            $this->assertEquals($x, $this->storage->count());
        }
    }

    public function testAttachObject(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1);
        $this->assertTrue($this->storage->offsetExists($object1));
        $this->storage->attach($object2);
        $this->assertTrue($this->storage->offsetExists($object2));
    }

    public function testAttachSingleValue(){
        $object1 = new stdClass();
        $this->storage->attach($object1, 'foo');
        $this->assertEquals('foo', $this->storage->offsetGet($object1));
    }

    public function testAttachMultiValues(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->assertEquals('foo', $this->storage->offsetGet($object1));
        $this->storage->attach($object2, 123);
        $this->assertEquals(123, $this->storage->offsetGet($object2));
    }




}