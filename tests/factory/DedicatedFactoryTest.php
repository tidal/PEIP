<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');


class DedicatedFactoryTest extends PHPUnit_Framework_TestCase{


    public function testGetfromClass(){
        $class = 'HelloService';
        $factory = PEIP\Factory\DedicatedFactory::getfromClass($class);
        $callable = array($class, '__construct');

        $this->assertTrue($factory instanceof PEIP\Factory\DedicatedFactory);
        $this->assertEquals($callable, $factory->getCallable());


    }

    public function testGetfromCallable(){
        $class = 'HelloService';
        $callable = array($class, '__construct');
        $factory = PEIP\Factory\DedicatedFactory::getfromCallable($callable);


        $this->assertTrue($factory instanceof PEIP\Factory\DedicatedFactory);
        $this->assertEquals($callable, $factory->getCallable());


    }

    public function testBuild(){
        $class = 'HelloService';
        $callable = array($class, '__construct');
        $factory = PEIP\Factory\DedicatedFactory::getfromCallable($callable);

        $service = $factory->build();

        $this->assertTrue($service instanceof $class);
    }

    public function testBuildInstanceArguments(){
        $class = 'HelloService';
        $callable = array($class, '__construct');
        $name = 'Fuuu';
        $args = array($name);
        $factory = PEIP\Factory\DedicatedFactory::getfromCallable($callable, $args);

        $service = $factory->build();

        $this->assertTrue($service instanceof $class);
        $this->assertEquals($name, $service->name);
    }

    public function testBuildArguments(){
        $class = 'HelloService';
        $callable = array($class, '__construct');
        $name = 'Fuuu';
        $args = array($name);
        $factory = PEIP\Factory\DedicatedFactory::getfromCallable($callable);

        $service = $factory->build($args);

        $this->assertTrue($service instanceof $class);
        $this->assertEquals($name, $service->name);
    }

    public function testBuildOverwriteArguments(){
        $class = 'HelloService';
        $callable = array($class, '__construct');
        $name1 = 'Fuuu';
        $name2 = 'Baaar';
        $factory = PEIP\Factory\DedicatedFactory::getfromCallable($callable, array($name1));

        $service = $factory->build(array($name2));

        $this->assertTrue($service instanceof $class);
        $this->assertEquals($name2, $service->name);
    }
}