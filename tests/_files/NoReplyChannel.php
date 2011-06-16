<?php


class NoReplyChannel extends PEIP_Pollable_Channel {


	public function receive($timeout = -1){
		return NULL;
	}

}