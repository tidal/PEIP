<?php



require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloServiceHandler.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/NoReplyChannel.php');

class HeaderServiceActivatorTest extends PHPUnit_Framework_TestCase  {

    protected $header = 'NAME';

	public function setup(){
		$this->service = new HelloService();
        $this->endpoint = new \PEIP\Service\HeaderServiceActivator(
            array($this->service, 'greet'),
            $this->header
        );
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
        $headers = array($this->header => $name);
		$message = new \PEIP\Message\GenericMessage('', $headers);
		$this->endpoint->send($message);
        $this->assertEquals($name, $service->name);
	}

	public function testReplyServiceActivator(){
		$service = $this->getService();
		$name = 'Foo';
        $headers = array($this->header => $name);
        $expected = $service->greet($name);
        $this->called = false;
        $test = $this;
        $message = new \PEIP\Message\GenericMessage('', $headers);
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
        $salutation = 'Good Evening';
        $this->endpoint = new \PEIP\Service\HeaderServiceActivator(
            $handler,
            'SALUTATION'
        );
        $headers = array('SALUTATION' => $salutation);
		$message = new \PEIP\Message\GenericMessage('', $headers);
		$this->endpoint->send($message);
        $this->assertEquals($salutation, $service->salutation);
	}
}
