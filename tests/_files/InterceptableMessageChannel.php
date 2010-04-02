<?php

class InterceptableMessageChannel extends PEIP_ABS_Interceptable_Message_Channel {

	protected $messages = array();

	public function __construct($name){
		$this->name = $name;
	}
	
	protected function doSend(PEIP_INF_Message $message){
		$this->messages[] = $message;
		return true;		 
	}	
	
	
}


