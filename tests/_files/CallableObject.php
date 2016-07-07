<?php


class CallableObject
{
    protected $testCase;
    protected $object;

    public function __construct(PHPUnit_Framework_TestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    public function setObject($object)
    {
        $this->object = $object;
    }

    public function callNotify($subject)
    {
        if (isset($this->object)) {
            $this->testCase->assertSame($this->object, $subject);
        } else {
            throw new RuntimeException('Asserted Object must be set first');
        }
    }

    public function callUntil()
    {
        return true;
    }

    public function callNoMore()
    {
        $this->testCase->fail('Dispatcher should have stopped on last listener');
    }

    public function returnParam($param)
    {
        return $param;
    }
}
