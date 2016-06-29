<?php

use PEIP\ABS\Router\Router;
use PEIP\INF\Message\Message;

class DrinkRouter 
	extends Router {
	
	protected function selectChannels(Message $message){
		$order = $message->getContent();
		$channelName = $order['iced']  ? 'coldDrinks' : 'hotDrinks';
		echo PEIP_LINE_SEPARATOR."DrinkRouter: routed to channel: $channelName";
		return $channelName;
	}	

	
}
