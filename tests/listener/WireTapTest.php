<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class WireTapTest
	extends PHPUnit_Framework_TestCase {


    public function setup(){
        $this->input = new \PEIP\Channel\PublishSubscribeChannel('input');
        $this->output = new \PEIP\Channel\PollableChannel('output');
        $this->wiretap = new \PEIP\Listener\Wiretap($this->input, $this->output);
    }


    public function testConstruct(){
        $this->assertTrue($this->wiretap instanceof \PEIP\Listener\Wiretap);
        $this->assertSame($this->input, $this->wiretap->getInputChannel());
        $this->assertSame($this->output, $this->wiretap->getOutputChannel());
    }

    public function testSend(){
        $message = new \PEIP\Message\GenericMessage('foo');
        $this->input->send($message);
        $this->assertSame($message, $this->output->receive());

    }





}

