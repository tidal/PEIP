<?php


class MessageChannelInterceptor extends PEIP_Channel_Interceptor {

	public $message;
	
	public function __construct($id = false){
		$this->id = $id;
	}
	

	public function preSend(PEIP_INF_Message $message, PEIP_INF_Channel $channel){
	
	}

	public function postSend(PEIP_INF_Message $message, PEIP_INF_Channel $channel, $sent){
		$this->message = $message;
	}



}