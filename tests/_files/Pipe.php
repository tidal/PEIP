<?php 


use \PEIP\Pipe\Pipe as PEIP_Pipe;

class DefaultPipe extends PEIP_Pipe {



    public function __construct(){
        $this->registerCommand('foo', array($this, 'fooCommand'));
    }

    protected function fooCommand($arg){

    }







}
