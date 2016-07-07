<?php



use \PEIP\Event\Event as PEIP_Event;
use \PEIP\Util\Test as PEIP_Test;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/ReflectionTestResources.php');


class TestTest extends PHPUnit_Framework_TestCase
{
    public function testAssertClassHasConstructor()
    {
        $this->assertFalse(PEIP_Test::assertClassHasConstructor('ReflectionTestClass1'));
        $this->assertTrue(PEIP_Test::assertClassHasConstructor('ReflectionTestClass2'));
        $this->assertTrue(PEIP_Test::assertClassHasConstructor('ReflectionTestClass3'));
    }

    public function testAssertRequiredConstructorParameters()
    {
        $this->assertTrue(PEIP_Test::assertRequiredConstructorParameters('ReflectionTestClass1', []));
        $this->assertTrue(PEIP_Test::assertRequiredConstructorParameters('ReflectionTestClass2', []));
        $this->assertTrue(PEIP_Test::assertRequiredConstructorParameters('ReflectionTestClass3', []));
        $this->assertFalse(PEIP_Test::assertRequiredConstructorParameters('ReflectionTestClass4', []));

        $this->assertTrue(PEIP_Test::assertRequiredConstructorParameters('ReflectionTestClass4', [1]));
        $this->assertTrue(PEIP_Test::assertRequiredConstructorParameters('ReflectionTestClass4', [1, 2]));
    }

    public function testAssertInstanceOf()
    {
        $instance = new ReflectionTestClass4('foo');

        foreach (ReflectionTestClassUtils::$testInterfacesAndClasses as $c) {
            $this->assertTrue(PEIP_Test::assertInstanceOf($c, $instance));
        }
    }

    public function testAssertImplements()
    {
        // testing Exception
         $this->assertFalse(PEIP_Test::assertImplements(123, 456));
         // testing concrete classes and interfaces
         $this->assertFalse(PEIP_Test::assertImplements('ReflectionTestClass1', 'ReflectionTestInterface1'));
        $this->assertTrue(PEIP_Test::assertImplements('ReflectionTestClass2', 'ReflectionTestInterface1'));
        $this->assertFalse(PEIP_Test::assertImplements('ReflectionTestClass2', 'ReflectionTestInterface2'));
        $this->assertTrue(PEIP_Test::assertImplements('ReflectionTestClass3', 'ReflectionTestInterface1'));
        $this->assertTrue(PEIP_Test::assertImplements('ReflectionTestClass3', 'ReflectionTestInterface2'));
        $this->assertTrue(PEIP_Test::assertImplements('ReflectionTestClass4', 'ReflectionTestInterface1'));
        $this->assertTrue(PEIP_Test::assertImplements('ReflectionTestClass4', 'ReflectionTestInterface2'));
    }

    public function testAssertEvent()
    {
        $this->assertFalse(PEIP_Test::assertEvent(123));
        $this->assertTrue(PEIP_Test::assertEvent('PEIP\Event\Event'));
        $this->assertTrue(PEIP_Test::assertEvent(new PEIP_Event('foo', 'bar')));
    }

    public function testAssertEventSubject()
    {
        $this->assertTrue(PEIP_Test::assertEventSubject(new PEIP_Event('foo', 'bar')));
        $this->assertFalse(PEIP_Test::assertEventSubject(new PEIP_Event(null, 'bar')));
    }

    public function testAssertEventObjectSubject()
    {
        $this->assertFalse(PEIP_Test::assertEventObjectSubject(new PEIP_Event('foo', 'bar')));
        $this->assertFalse(PEIP_Test::assertEventObjectSubject(new PEIP_Event(null, 'bar')));
        $this->assertTrue(PEIP_Test::assertEventObjectSubject(new PEIP_Event(new ReflectionTestClass4('foo'), 'bar')));
    }
}
