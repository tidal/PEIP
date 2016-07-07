<?php



use \PEIP\Channel\PollableChannel as PEIP_Pollable_Channel;
use \PEIP\Channel\PublishSubscribeChannel as PEIP_Publish_Subscribe_Channel;
use \PEIP\Message\GenericMessage as PEIP_Generic_Message;
use \PEIP\Message\StringMessage as PEIP_String_Message;
use \PEIP\Service\ServiceActivator as PEIP_Service_Activator;
use \PEIP\Service\StringServiceActivator as PEIP_String_Service_Activator;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloServiceHandler.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/NoReplyChannel.php');

class ServiceActivatorTest extends PHPUnit_Framework_TestCase
{
    public function setup()
    {
        $this->service = new HelloService();
    }

    protected function getService()
    {
        return new HelloService();
    }

    public function testHelloService()
    {
        $service = $this->getService();
        $this->assertEquals('Hello FOO', $service->greet('FOO'));
        $service->setSalutation('Hi');
        $this->assertEquals('Hi FOO', $service->greet('FOO'));
        $this->assertEquals('Hi', $service->salutation);
    }

    public function testHelloServiceHandler()
    {
        $service = $this->getService();
        $handler = new HelloServiceHandler($service, 'greet');
        $this->assertEquals('Hello FOO', $handler->handle('FOO'));
    }

    public function testConstructionServiceActivator()
    {
        $input = new PEIP_Pollable_Channel('input');
        $output = new PEIP_Pollable_Channel('output');
        $endpoint = new PEIP_Service_Activator([$this->service, 'greet'], $input, $output);
        $this->assertTrue(is_object($endpoint));
        $this->assertTrue($endpoint instanceof PEIP_Service_Activator);
    }

    public function testConstructionStringServiceActivator()
    {
        if (!class_exists('PEIP_String_Service_Activator')) {
            return;
        }
        $input = new PEIP_Pollable_Channel('input');
        $output = new PEIP_Pollable_Channel('output');
        $endpoint = new PEIP_String_Service_Activator([$this->service, 'greet'], $input, $output);
        $this->assertTrue(is_object($endpoint));
        $this->assertTrue($endpoint instanceof PEIP_String_Service_Activator);
    }

    public function testSend()
    {
        $input = new PEIP_Publish_Subscribe_Channel('input');
        $output = new PEIP_Publish_Subscribe_Channel('output');
        $service = $this->getService();
        $endpoint = new PEIP_Service_Activator([$service, 'setSalutation'], $input, $output);
        //$endpoint->setInputChannel($input);
                $salutation = 'Good Morning';
        $message = new PEIP_String_Message($salutation);
        $input->send($message);
        $this->assertEquals($salutation, $service->salutation);
    }

    public function testReplyServiceActivator()
    {
        $input = new PEIP_Publish_Subscribe_Channel('input');
        $output = new PEIP_Pollable_Channel('output');
        $service = $this->getService();
        $endpoint = new PEIP_Service_Activator([$service, 'greet'], $input, $output);
        $salutation = 'Foo';
        $message = new PEIP_Generic_Message($salutation);
        $input->send($message);

        return;
        $res = $output->receive();
        $this->assertTrue($res instanceof PEIP_Generic_Message);
        $this->assertEquals('Hello Foo', (string) $res->getContent());
    }

    public function testReplyStringServiceActivator()
    {
        if (!class_exists('PEIP_String_Service_Activator')) {
            return;
        }
        $input = new PEIP_Publish_Subscribe_Channel('input');
        $output = new PEIP_Pollable_Channel('output');
        $service = $this->getService();
        $endpoint = new PEIP_String_Service_Activator([$service, 'greet'], $input, $output);
        $salutation = 'Foo';
        $message = new PEIP_String_Message($salutation);
        $input->send($message);
        $res = $output->receive();
        $this->assertTrue($res instanceof PEIP_String_Message);
        $this->assertTrue(is_string($res->getContent()));
        $this->assertEquals('Hello Foo', $res->getContent());
    }

    public function testHandle()
    {
        $input = new PEIP_Publish_Subscribe_Channel('input');
        $service = $this->getService();
        $handler = new HelloServiceHandler($service, 'setSalutation');
        $endpoint = new PEIP_Service_Activator($handler, $input);
        $salutation = 'Good Evening';
        $message = new PEIP_String_Message($salutation);
        $input->send($message);
        $this->assertEquals($salutation, $service->salutation);
    }

    public function testChannelReceiveException()
    {
        //why should this raise an exception?
        /*
        $input = new NoReplyChannel('input');
        $service = $this->getService();
        $handler = new HelloServiceHandler($service, 'setSalutation');
        $endpoint = new PEIP_Service_Activator($handler, $input);
        $salutation = 'Good Evening';
        $message = new PEIP_String_Message($salutation);
        try{
            $input->send($message);
        }
        catch (Exception $expected) {
            return;
        }
        $this->fail('An expected exception has not been raised.');

         */
    }
}
