<?php

class CafeGateway extends PEIP_Simple_Messaging_Gateway {

	public function placeOrder(Order $order){
		echo "\nCafe: place order #".$order->getOrderNumber();
		$this->send($order);
	}
	
	public function receiveDelivery(){
		return $this->receive();
	}

}
