<?php

class DrinkRouter 
	extends PEIP_ABS_Router {
	
	protected function selectChannels(PEIP_INF_Message $message){
		$order = $message->getContent();
		$channelName = $order['iced']  ? 'coldDrinks' : 'hotDrinks';
		echo PEIP_LINE_SEPARATOR."DrinkRouter: routed to channel: $channelName";
		return $channelName;
	}	

	
}
