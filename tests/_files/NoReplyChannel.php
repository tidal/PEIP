<?php



use \PEIP\Channel\PollableChannel as PEIP_Pollable_Channel;

class NoReplyChannel extends PEIP_Pollable_Channel
{
    public function receive($timeout = -1)
    {
    }
}
