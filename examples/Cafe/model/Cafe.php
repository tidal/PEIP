<?php

class Cafe 
	extends PEIA_Simple_Messaging_Gateway {

	public function placeOrder(Order $order){
		return $this->sendAndReceive($order);	
	}

}

