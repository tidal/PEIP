<?php 

class BaseConnetableTest extends PHPUnit_Framework_TestCase   {

    protected 
        $eventThrown = false,
        $eventName = '',
        $connectable = NULL,
        $headers = array();

    protected function setupEventTest(\PEIP\INF\Event\Connectable $connectable, $eventName, $headers = array()){
        $this->eventName = $eventName;
        $this->eventThrown = false;
        $this->connectable = $connectable;
        $this->headers = $headers;
        $connectable->disconnectAll($eventName);
        $connectable->connect($eventName, array($this, 'eventCallback'));

    }

    public function eventCallback(\PEIP\INF\Event\Event $event){
        $this->assertTrue($event instanceof \PEIP\INF\Event\Event);
        $this->assertTrue($event->getContent() instanceof \PEIP\INF\Event\Connectable);
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

