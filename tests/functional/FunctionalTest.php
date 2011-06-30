<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

use \PEIP\Constant\Header;
use \PEIP\Constant\Event;
use \PEIP\Constant\Fallback;

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloServiceHandler.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/NoReplyChannel.php');

class FunctionalTest extends PHPUnit_Framework_TestCase  {

    public function testSeviceActivator(){

        $string = 'World';
        $expected = 'Hello World';

        // create channels
        $input = new PEIP\Channel\PublishSubscribeChannel('input');
        $output = new PEIP\Channel\PollableChannel('output');
        // create service instance
        $service = new HelloService();
        // create service activator instance
        $endpoint = new PEIP\Service\StringServiceActivator(array($service, 'greet'), $input, $output);
        // send request message      
        $message = new PEIP\Message\StringMessage($string);
        $resultMessage = new PEIP\Message\StringMessage($expected);
        $input->send($message);
        // receive reply message
        $res = $output->receive();
        $this->assertEquals($resultMessage, $res);

    }

    public function testGateway(){

        $string = 'World';
        $expected = 'Hello World';

        // create channels
        $input = new PEIP\Channel\PublishSubscribeChannel('input');
        $output = new PEIP\Channel\PollableChannel('output');
        // create service instance
        $service = new HelloService();
        // create service activator and gateway instance
        $endpoint = new PEIP\Service\StringServiceActivator(array($service, 'greet'), $input, $output);
        $gateway = new PEIP\Gateway\SimpleMessagingGateway($input, $output);

        // send request message
        $gateway->send($string);
        // receive reply message
        $res = $gateway->receive();
        $this->assertEquals($expected, $res);

    }


    public function testReaderProviderMapper(){
        $channelId = 'foo';
        $channelClass = '\PEIP\Channel\PollableChannel';
        $provider = new PEIP\Service\ServiceProvider();
        $mapper = new PEIP\Service\ConfigMapper();
        $mapper->setMapping('channel', array (
            'type' => 'channel',
            'class' => $channelClass,
            'constructor_arg' => array(
                  'id'
            )
        ));
        $config = array (
              'type' => 'context',
              'service' =>
              array (
                array (
                  'id' => $channelId,
                  'type' => 'channel',
                )
              )
        );
        $reader = new PEIP\Context\ContextReader($config);
        $test = $this;
        $reader->connect(Event::READ_SERVICE, function($e)use($mapper, $provider,$channelClass,$test){
            $config = $e->getHeader(Header::SERVICE);
            $config = $mapper->map($config['type'], $config); 
            $test->assertEquals($channelClass, $config['class']);


            $id = $provider->addConfig($config);
        });

        $reader->read();

        $channel = $provider->provideService($channelId);

        $this->assertTrue($channel instanceof  $channelClass);
    }


}
