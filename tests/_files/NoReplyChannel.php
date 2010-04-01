<?php


class NoReplyChannel extends PEIA_Pollable_Channel {


	public function receive($timeout = -1){
		return NULL;
	}

}