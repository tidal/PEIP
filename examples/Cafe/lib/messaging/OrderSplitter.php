<?php

use PEIP\ABS\Splitter\MessageSplitter;
use PEIP\INF\Message\Message;

class OrderSplitter extends MessageSplitter {

	public function split(Message $message){
		$order = $message->getContent();
		$orderItems = $order->getItems();
		$items = array();
		foreach($orderItems as $item){
			$nr = $item['number'];
			unset($item['number']);
			$item['order'] = $order->getOrderNumber();
			for($x = 0; $x < $nr; $x++){
				$items[] = $item;	
			}
		}
		echo PEIP_LINE_SEPARATOR."OrderSplitter: split order #: ".$order->getOrderNumber();
		return $items;
	}
	
}
