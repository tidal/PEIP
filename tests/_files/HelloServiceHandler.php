<?php



class HelloServiceHandler {

	public function __construct($service, $method){
		$this->callable = array($service, $method);
	}
	
	public function handle($message){
		return call_user_func($this->callable, $message);
	}
}