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

    public function testOffsetSet(){
        $object1 = new stdClass();
        $this->storage->attach($object1, 'foo');
        $this->assertTrue($this->storage->offsetExists($object1));
    }

    public function testOffsetUnset(){ 
        $object1 = new stdClass();
        $this->storage->attach($object1, 'foo');
        $this->assertTrue($this->storage->offsetExists($object1));
        $this->storage->offsetUnset($object1);
        $this->assertFalse($this->storage->offsetExists($object1));
    }

    public function testRewindCurrent(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $this->storage->next();
        $this->storage->rewind();
        $this->assertEquals($object1, $this->storage->current());
    }

    public function testNext(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $this->storage->rewind();
        $this->assertEquals($object1, $this->storage->current());
        $this->storage->next();
        $this->assertEquals($object2, $this->storage->current());
    }

    public function testValid(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $this->storage->rewind();
        $this->assertTrue($this->storage->valid());
        $this->storage->next();
        $this->assertTrue($this->storage->valid());
        $this->storage->next();
        $this->assertFalse($this->storage->valid());
    }


    public function testKey(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $this->storage->rewind();
        $this->assertEquals(0, $this->storage->key());
        $this->storage->next();
        $this->assertEquals(1, $this->storage->key());
    }


    public function testGetInfo(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $this->storage->rewind();
        $this->assertEquals('foo', $this->storage->getInfo());
        $this->storage->next();
        $this->assertEquals(123, $this->storage->getInfo());
    }

    public function testAddAll(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $storage = new PEIP_Object_Storage;
        $storage->addAll($this->storage);
        $storage->rewind();
        $this->assertEquals('foo', $storage->getInfo());
        $storage->next();
        $this->assertEquals(123, $storage->getInfo());
    }

    public function testRemoveAll(){
        $object1 = new stdClass();
        $object1->val = 321;
        $object2 = new stdClass();
        $object2->val = 456;
        $this->storage->attach($object1, 'foo');
        $this->storage->attach($object2, 123);
        $storage = new PEIP_Object_Storage;
        $storage->attach($object1, 'foo');
        $storage->attach($object2, 123);     
        $storage->removeAll($this->storage);
        $this->assertFalse($storage->offsetExists($object1));
        $this->assertFalse($storage->offsetExists($object2));
    }

}