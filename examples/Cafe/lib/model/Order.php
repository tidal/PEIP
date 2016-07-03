<?php

class Order {

    protected 
        $items = array(),
        $orderNumber;
    protected static $orderCount = 0;

    public function __construct() {
        self::$orderCount++;
        $this->orderNumber = self::$orderCount;
    }	

    public function getOrderNumber() {
        return $this->orderNumber;
    }
	
    public function addItem($type, $number, $iced = false) {
        $this->items[] = 
            array(
                'type' => $type,
                'number' => $number,
                'iced' => $iced
            );
    }

    public function getItems() {
        return $this->items;
    }

    public function getTotalCount() {
        $x = 0;
        foreach ($this->items as $item) {
            $x += (int)$item['number'];
        }
        return $x;
    }
	
	
	
}
