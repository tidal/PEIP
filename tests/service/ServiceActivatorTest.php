<?php 

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloServiceHandler.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/NoReplyChannel.php');

class ServiceActivatorTest extends PHPUnit_Framework_TestCase  {


	public function setup(){
		$this->service = new HelloService();
	}
	
	protected function getService(){
		return new HelloService();
	}	

	public function testHelloService(){
		$service = $this->getService();
		$this->assertEquals('Hello FOO', $service->greet('FOO'));
		$service->setSalutation('Hi');
		$this->assertEquals('Hi FOO', $service->greet('FOO'));
		$this->assertEquals('Hi', $service->salutation);
	}
	
	public function testHelloServiceHandler(){
		$service = $this->getService();
		$handler = new HelloServiceHandler($service, 'greet');
		$this->assertEquals('Hello FOO', $handler->handle('FOO'));
	}	
	
	public function testConstructionServiceActivator(){
		$endpoint = new \PEIP\Service\ServiceActivator(array($this->service, 'greet'));
        $this->assertTrue(is_object($endpoint));
        $this->assertTrue($endpoint instanceof \PEIP\Service\ServiceActivator);
	}


	public function testConstructionServiceActivatorChannels(){
		$input = new \PEIP\Channel\PollableChannel('input');
		$output = new \PEIP\Channel\PollableChannel('output');
		$endpoint = new \PEIP\Service\ServiceActivator(array($this->service, 'greet'), $input, $output);
        $this->assertTrue(is_object($endpoint));
        $this->assertTrue($endpoint instanceof \PEIP\Service\ServiceActivator);
	}

	public function testConstructionStringServiceActivator(){
		if(!class_exists('\PEIP\Service\StringServiceActivator')){
			return;
		}		
		$endpoint = new \PEIP\Service\StringServiceActivator(array($this->service, 'greet'));
        $this->assertTrue(is_object($endpoint));
        $this->assertTrue($endpoint instanceof \PEIP\Service\StringServiceActivator);
	}

	public function testSend(){
		$service = $this->getService();	
		$endpoint = new \PEIP\Service\ServiceActivator(array($service, 'setSalutation'));
        $salutation = 'Good Morning';
		$message = new \PEIP\Message\StringMessage($salutation);
		$endpoint->send($message);
        $this->assertEquals($salutation, $service->salutation);	
	}
	
	public function testReplyServiceActivator(){
		$service = $this->getService();	
		$endpoint = new \PEIP\Service\ServiceActivator(array($service, 'greet'));
		$salutation = 'Foo';
        $this->called = false;
        $test = $this;
        $endpoint->getMessageDispatcher()->connect(function($m)use($test){
            $test->assertTrue($m instanceof \PEIP\Message\GenericMessage);
            $test->assertEquals('Hello Foo', (string)$m->getContent());
            $test->called = true;
        });

		$message = new \PEIP\Message\GenericMessage($salutation);
		$endpoint->send($message);
		$this->assertTrue($this->called);

	}


	public function testReplyServiceActivatorChannels(){
		$input = new \PEIP\Channel\PublishSubscribeChannel('input');
		$output = new \PEIP\Channel\PollableChannel('output');
		$service = $this->getService();
		$endpoint = new \PEIP\Service\ServiceActivator(array($service, 'greet'));
		$salutation = 'Foo';
		$message = new \PEIP\Message\GenericMessage($salutation);
		$input->send($message); return;
		$res = $output->receive();
		$this->assertTrue($res instanceof PEIP_Generic_Message);
		$this->assertEquals('Hello Foo', (string)$res->getContent());
	}

	public function testReplyStringServiceActivator(){
		if(!class_exists('\PEIP\Service\StringServiceActivator')){
			return;
		}		
		$input = new \PEIP\Channel\PublishSubscribeChannel('input');
		$output = new \PEIP\Channel\PollableChannel('output');
		$service = $this->getService();	
		$endpoint = new \PEIP\Service\StringServiceActivator(array($service, 'greet'), $input, $output);
		$salutation = 'Foo';
		$message = new \PEIP\Message\StringMessage($salutation);
		$input->send($message);
		$res = $output->receive();
		$this->assertTrue($res instanceof \PEIP\Message\StringMessage);
		$this->assertTrue(is_string($res->getContent())); 
		$this->assertEquals('Hello Foo', $res->getContent());
	}	

	public function testHandle(){
		$input = new \PEIP\Channel\PublishSubscribeChannel('input');
		$service = $this->getService();
		$handler = new HelloServiceHandler($service, 'setSalutation');		
		$endpoint = new \PEIP\Service\ServiceActivator($handler, $input);
		$salutation = 'Good Evening';
		$message = new \PEIP\Message\StringMessage($salutation);
		$input->send($message);		
        $this->assertEquals($salutation, $service->salutation);	
	}	

	
	
}
