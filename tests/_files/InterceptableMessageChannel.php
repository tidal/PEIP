<?php

class InterceptableMessageChannel extends PEIA_ABS_Interceptable_Message_Channel {

	protected $messages = array();

	public function __construct($name){
		$this->name = $name;
	}
	
	protected function doSend(PEIA_Message_Interface $message){
		$this->messages[] = $message;
		return true;		 
	}	
	
	
}


