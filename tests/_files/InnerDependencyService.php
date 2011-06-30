<?php


class InnerDependencyService {

    public $name;

    public function __construct($name){
        $this->name = $name;
    }

}


class OuterDependencyService {
    public $service;

    public function __construct($name){
        $this->service = new InnerDependencyService($name);
    }

    public function getService(){
        return $this->service;
    }

    public function getServiceByName($name){
        return $this->service->name == $name ? $this->service : NULL;
    }
}




