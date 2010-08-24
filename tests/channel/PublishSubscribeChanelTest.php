<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';
require_once dirname(__FILE__).'/InterceptableMessageChannelTest.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandler.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandlerFail.php';
require_once dirname(__FILE__).'/../_files/PublishSubscribeHandlerEvent.php';

class PublishSubscribeChanelTest
	extends InterceptableMessageChannelTest {

	public function setUp(){
            $this->channel = new PEIP_Publish_Subscribe_Channel('TestChannel');
	}

        public function testSubscribe(){
            $handler = new PublishSubscribeHandler($this);
            $this->channel->subscribe($handler);
            $message = new PEIP_Generic_Message('Hallo');
            $handler->setAssertSubject($message);
            $this->channel->send($message);
        }

        public function testUnsubscribe(){
            $handler = new PublishSubscribeHandlerFail($this);
            $this->channel->subscribe($handler);
            $this->channel->unsubscribe($handler);
            $message = new PEIP_Generic_Message('Hallo');
            $handler->setAssertSubject($message);
            $this->channel->send($message);
        }

        public function testSetMessageDispatcher(){
            $dispatcher = new PEIP_Dispatcher();
            $this->channel->setMessageDispatcher($dispatcher);
            $this->assertSame($dispatcher, $this->channel->getMessageDispatcher());
        }

        public function testSetMessageDispatcherTransfer(){
            $handler = new PublishSubscribeHandler($this);
            $this->channel->subscribe($handler);
            $dispatcher = new PEIP_Dispatcher();
            $this->channel->setMessageDispatcher($dispatcher);
            $this->assertSame($dispatcher, $this->channel->getMessageDispatcher());
            $message = new PEIP_Generic_Message('Hallo');
            $handler->setAssertSubject($message);
            $this->channel->send($message);
        }

        public function testSetMessageDispatcherTransferFalse(){
            $handler = new PublishSubscribeHandlerFail($this);
            $this->channel->subscribe($handler);
            $dispatcher = new PEIP_Dispatcher();
            $this->channel->setMessageDispatcher($dispatcher, false);
            $this->assertSame($dispatcher, $this->channel->getMessageDispatcher());
            $message = new PEIP_Generic_Message('Hallo');
            $handler->setAssertSubject($message);
            $this->channel->send($message);
       }

       public function testEventPrePublish(){
            $handler = new PublishSubscribeHandlerEvent($this);
            $this->channel->connect('prePublish',$handler);
            $message = new PEIP_Generic_Message('Hallo');
            $handler->setAssertSubject($message);
            $this->channel->send($message);
       }
       public function testEventPostPublish(){
            $handler = new PublishSubscribeHandlerEvent($this);
            $this->channel->connect('postPublish',$handler);
            $message = new PEIP_Generic_Message('Hallo');
            $handler->setAssertSubject($message);
            $this->channel->send($message);
       }

}