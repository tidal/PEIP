<?php

class InterceptableMessageChannel extends PEIP_ABS_Interceptable_Message_Channel {

	protected $messages = array();


	
	protected function doSend(PEIP_INF_Message $message){
		$this->messages[] = $message;
		return true;		 
	}	
	
	
}


