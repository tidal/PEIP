<?php

class TestConnectable 
    extends PEIP\ABS\Base\Connectable
    implements PEIP\INF\Event\EventHandler{

    public $eventFired = false;
    public $calledBack = false;
    public static $staticCalledBack = false;

    public function fireEvent($name ,array $headers = array(), $eventClass = '', $type = false){
        $res = $this->doFireEvent($name, $headers, $eventClass, $type);
        $this->eventFired = true;
        return $res;
    }

    public function handle($subject){
        $this->calledBack = true;
    }

    public function callback(\PEIP\INF\Event\Event $event){
        $this->calledBack = true;
    }

    public static function staticCallback(\PEIP\INF\Event\Event $event){
        self::$staticCalledBack = true;
    }

}

