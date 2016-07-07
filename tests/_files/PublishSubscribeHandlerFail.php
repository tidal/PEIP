<?php



use \PEIP\INF\Handler\Handler as PEIP_INF_Handler;

class PublishSubscribeHandlerFail implements PEIP_INF_Handler
{
    protected $testCase;
    protected $assertSubject;

    public function __construct($testCase)
    {
        $this->testCase = $testCase;
    }

    public function setAssertSubject($subject)
    {
        $this->assertSubject = $subject;
    }

    public function handle($subject)
    {
        $this->testCase->fail('Handle should not be called');
    }
}
