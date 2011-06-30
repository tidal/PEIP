<?php


class HelloService {

	public $salutation = 'Hello';
    public $name;

    public function __construct($name = 'Foo'){
        $this->name = $name;
    }

    public function getInstance($name = 'Foo'){
        return new HelloService($name);
    }

    public function getName(){
        return $this->name;
    }

	public function greet($name = false){
        $name = $name ? $name : $this->name;
		return $this->salutation.' '.$name;
	}
	
	public function setSalutation($salutation){ 
		$this->salutation = $salutation;
	}




}
