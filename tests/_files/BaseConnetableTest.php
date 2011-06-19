<?php

class BaseConnetableTest extends PHPUnit_Framework_TestCase   {

    protected 
        $eventThrown = false,
        $eventName = '',
        $connectable = NULL,
        $headers = array();

    protected function setupEventTest(PEIP_INF_Connectable $connectable, $eventName, $headers = array()){
        $this->eventName = $eventName;
        $this->eventThrown = false;
        $this->connectable = $connectable;
        $this->headers = $headers;
        $connectable->disconnectAll($eventName);
        $connectable->connect($eventName, array($this, 'eventCallback'));

    }

    public function eventCallback(PEIP_INF_Event $event){
        $this->assertTrue($event instanceof PEIP_INF_Event);
        $this->assertTrue($event->getContent() instanceof PEIP_INF_Connectable);
        foreach($this->headers as $name=>$value){
            $this->assertTrue(
                $event->getHeader($name) !== NULL,
                "Event '".$event->getName()."' - should have header '$name'"
            );
            $this->assertEquals(
                $value,
                $event->getHeader($name),
                $event->getName()." : "
            );
        }
        $this->eventThrown = true;
    }

    protected function assertEventThrown(){
        $this->assertTrue($this->eventThrown, "Event '{$this->eventName}' should have been thrown!");
    }

}

