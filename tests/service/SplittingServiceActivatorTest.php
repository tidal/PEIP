<?php



require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloServiceHandler.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/NoReplyChannel.php');

class SplittingServiceActivatorTest extends PHPUnit_Framework_TestCase  {

	public function setup(){
		$this->service = new HelloService();
        $this->endpoint = new \PEIP\Service\SplittingServiceActivator(array($this->service, 'greet'));
	}

	protected function getService(){
		return $this->service;
	}

	public function testConstruction(){
        $this->assertTrue(is_object($this->endpoint));
        $this->assertTrue($this->endpoint instanceof \PEIP\Service\ServiceActivator);
	}

	public function testSend(){
		$service = $this->getService();
        $name = 'Foo';
		$message = new \PEIP\Message\GenericMessage(array($name));
		$this->endpoint->send($message);
        $this->assertEquals($name, $service->name);
	}

	public function testReplyServiceActivator(){
		$service = $this->getService();
		$name = 'Foo';
        $expected = $service->greet($name);
        $this->called = false;
        $test = $this;
        $message = new \PEIP\Message\GenericMessage(array($name));
        $this->endpoint->getMessageDispatcher()->connect(function($m)use($test, $expected, $message){
            $test->assertNotEquals($message, $m);
            $test->assertTrue($m instanceof \PEIP\INF\Message\Message);
            $test->assertEquals($expected, (string)$m->getContent());
            $test->called = true;
        });

		
		$this->endpoint->send($message);
		$this->assertTrue($this->called);

	}

	public function testHandle(){
        $service = $this->getService();
		$handler = new HelloServiceHandler($service, 'setSalutation');
        $this->endpoint = new \PEIP\Service\SplittingServiceActivator($handler);
		$salutation = 'Good Evening';
		$message = new \PEIP\Message\GenericMessage(array($salutation));
		$this->endpoint->send($message);
        $this->assertEquals($salutation, $service->salutation);
	}
}
