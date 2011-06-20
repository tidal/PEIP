<?php

class FooChannel extends PEIP_ABS_Channel {

	protected $messages = array();

	protected function doSend(PEIP_INF_Message $message){
		$this->messages[] = $message;
		return true;
	}

}

