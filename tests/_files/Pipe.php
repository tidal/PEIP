<?php

class DefaultPipe extends PEIP_Pipe {



    public function __construct(){
        $this->registerCommand('foo', array($this, 'fooCommand'));
    }

    protected function fooCommand($arg){

    }







}
