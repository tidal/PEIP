<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class ContentClassSelectorTest
	extends PHPUnit_Framework_TestCase {

    public function testAccept(){
        $class1 = '\PEIP\Message\GenericMessage';
        $class2 = '\PEIP\Message\StringMessage';
        $selector = new \PEIP\Selector\ContentClassSelector($class1);
        $message1 = new $class1(new $class1('Foo'));
        $message2 = new $class1(new $class2('Foo'));

        $this->assertTrue($selector->acceptMessage($message1));
        $this->assertTrue($selector->acceptMessage($message2));
    }

    public function testDecline(){
        $class1 = '\PEIP\Message\GenericMessage';
        $class2 = '\PEIP\Message\StringMessage';
        $selector = new \PEIP\Selector\ContentClassSelector($class2);
        $message1 = new $class1(new $class2('Foo'));
        $message2 = new $class1(new $class1('Foo'));

        $this->assertTrue($selector->acceptMessage($message1));
        $this->assertFalse($selector->acceptMessage($message2));
    }





}

