<?php

class SimpleHandler implements PEIP_INF_Handler {

    public $subject;

    public function handle($subject){
        $this->subject = $subject;
    }

}

