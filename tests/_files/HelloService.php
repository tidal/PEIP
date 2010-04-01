<?php


class HelloService {

	public $salutation = 'Hello';

	public function greet($name){
		return $this->salutation.' '.$name;
	}
	
	public function setSalutation($salutation){
		$this->salutation = $salutation;
	}


}
