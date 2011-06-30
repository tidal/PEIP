<?php

require_once(__DIR__.'/../../src/Autoload/Autoload.php');


class AutoloadTest extends PHPUnit_Framework_TestCase {


    public function testGetInstance(){
        $instance = \PEIP\Autoload\Autoload::getInstance(true);
        $this->assertSame($instance, \PEIP\Autoload\Autoload::getInstance());
        $this->assertNotSame($instance, \PEIP\Autoload\Autoload::getInstance(true));
    }

    public function testAutoload(){
        $class = 'PEIP\Message\GenericMessage';
        $this->assertFalse(class_exists($class, false));
        $autoload = \PEIP\Autoload\Autoload::getInstance();
        $this->assertTrue($autoload->autoload($class));
        $this->assertTrue(class_exists($class, false));
        $this->assertFalse($autoload->autoload($class));
        $this->assertFalse($autoload->autoload('FooBarFooBar'));

    }

}

