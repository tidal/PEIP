<?php

class NonBlockingPollableChannel extends \PEIP\Channel\PollableChannel {
    
    protected 
        $called = 0,
        $calls = 10;

    protected function getMessage() { 
        if($this->called < $this->calls){
            $this->called++;
            $res = NULL;
        }else{
            $res = parent::getMessage();
        }
        return $res;
    }






}

