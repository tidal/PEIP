<?php

class PublishSubscribeHandlerEvent implements PEIP_INF_Handler {

    protected $testCase;
    protected $assertSubject;
    protected $headerName = 'MESSAGE';

    public function __construct($testCase){
        $this->testCase = $testCase;
    }

    public function setAssertSubject($subject){
        $this->assertSubject = $subject;
    }

    public function handle($subject){
        $this->testCase->assertSame($this->assertSubject, $subject->getHeader($this->headerName));
    }

}
