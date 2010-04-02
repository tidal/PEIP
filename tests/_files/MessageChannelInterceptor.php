<?php


class MessageChannelInterceptor extends PEIP_Abstract_Message_Channel_Interceptor {

	public $message;
	
	public function __construct($id = false){
		$this->id = $id;
	}
	

	public function preSend(PEIA_Message_Interface $message, PEIA_Message_Channel_Interface $channel){
	
	}

	public function postSend(PEIA_Message_Interface $message, PEIA_Message_Channel_Interface $channel, $sent){
		$this->message = $message;
	}



}