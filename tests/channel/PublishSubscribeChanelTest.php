<?php



use \PEIP\Channel\PublishSubscribeChannel as PEIP_Publish_Subscribe_Channel;
use \PEIP\Dispatcher\Dispatcher as PEIP_Dispatcher;
use \PEIP\Message\GenericMessage as PEIP_Generic_Message;
use \PEIP\Pipe\Pipe as PEIP_Pipe;

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/ChannelTest.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandler.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandlerFail.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandlerEvent.php';

class PublishSubscribeChanelTest extends ChannelTest
{
    public function setUp()
    {
        $this->channel = new PEIP_Publish_Subscribe_Channel('TestChannel');
    }

    public function testSubscribe()
    {
        $handler = new PublishSubscribeHandler($this);
        $this->channel->subscribe($handler);
        $message = new PEIP_Generic_Message('Hallo');
        $handler->setAssertSubject($message);
        $this->channel->send($message);
    }

    public function testUnsubscribe()
    {
        $handler = new PublishSubscribeHandlerFail($this);
        $this->channel->subscribe($handler);
        $this->channel->unsubscribe($handler);
        $message = new PEIP_Generic_Message('Hallo');
        $handler->setAssertSubject($message);
        $this->channel->send($message);
    }

    public function testSetMessageDispatcher()
    {
        $dispatcher = new PEIP_Dispatcher();
        $this->channel->setMessageDispatcher($dispatcher);
        $this->assertSame($dispatcher, $this->channel->getMessageDispatcher());
    }

    public function testSetMessageDispatcherTransfer()
    {
        $handler = new PublishSubscribeHandler($this);
        $this->channel->subscribe($handler);
        $dispatcher = new PEIP_Dispatcher();
        $this->channel->setMessageDispatcher($dispatcher);
        $this->assertSame($dispatcher, $this->channel->getMessageDispatcher());
        $message = new PEIP_Generic_Message('Hallo');
        $handler->setAssertSubject($message);
        $this->channel->send($message);
    }

    public function testSetMessageDispatcherTransferFalse()
    {
        $handler = new PublishSubscribeHandlerFail($this);
        $this->channel->subscribe($handler);
        $dispatcher = new PEIP_Dispatcher();
        $this->channel->setMessageDispatcher($dispatcher, false);
        $this->assertSame($dispatcher, $this->channel->getMessageDispatcher());
        $message = new PEIP_Generic_Message('Hallo');
        $handler->setAssertSubject($message);
        $this->channel->send($message);
    }

    public function testEventPrePublish()
    {
        $handler = new PublishSubscribeHandlerEvent($this);
        $this->channel->connect('prePublish', $handler);
        $message = new PEIP_Generic_Message('Hallo');
        $handler->setAssertSubject($message);
        $this->channel->send($message);
    }

    public function testEventPostPublish()
    {
        $this->channel = new PEIP_Publish_Subscribe_Channel('TestChannel2');
            //$handler = new PublishSubscribeHandlerEvent($this);
            $message = new PEIP_Generic_Message('Hallo');
        $testCase = $this; /*
            $this->channel->connect('postPublish',function($event)use($message, $testCase){
                $testCase->assertTrue(is_object($message));
                $testCase->assertTrue(is_object(1));
                $testCase->assertTrue(is_object($event->getHeader(PEIP_Pipe::HEADER_MESSAGE)));

                $testCase->assertEquals(
                    $message,
                    $event->getHeader(PEIP_Pipe::HEADER_MESSAGE),
                    'Objects should be equal:'.get_class($message).' - '.get_class($event->getHeader(PEIP_Pipe::HEADER_MESSAGE))
                );
            });
            */


            //$handler->setAssertSubject($message);
            $this->channel->send($message);
    }
}
