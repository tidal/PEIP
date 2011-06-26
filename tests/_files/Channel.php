<?php 


use \PEIP\ABS\Channel\Channel as PEIP_ABS_Channel;
use \PEIP\INF\Message\Message as PEIP_INF_Message;

class FooChannel extends PEIP_ABS_Channel {

	protected $messages = array();

	protected function doSend(PEIP_INF_Message $message){
		$this->messages[] = $message;
		return true;
	}

}

