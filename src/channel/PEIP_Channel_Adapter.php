<?php


class PEIP_Channel_Adapter {

	protected $channel;
	protected $handler;

	public function __construct(PEIP_ABS_Message_Handler $handler, PEIP_INF_CHANNEL $channel){
		$this->channel = $channel;
		$this->handler = $handler;
	}

	protected function getMessage($object){
		if($this->channel instanceof PEIP_INF_Subscribable_Channel){
			return $object;	
		}else{
			return $object->getContent()->receive();
		}
	}

	public function handle($object){
		$message = $this->getMessage($object);
            	if(!is_object($message)){ 
                	throw new Exception('Could not get Message from Channel');
            	}               
            	$this->handler->handle($message);
	} 







}

