<?php

class Cafe 
	extends \PEIP\Gateway\SimpleMessagingGateway {

	public function placeOrder(Order $order){
		return $this->sendAndReceive($order);	
	}

}

