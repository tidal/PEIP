<?php



namespace PEIP\Channel;

class ChannelAdapter {

    protected $channel;
    protected $handler;

    public function __construct(\PEIP\ABS\Handler\MessageHandler $handler,  $channel){
        $this->channel = $channel;
        $this->handler = $handler;
    }

    protected function getMessage($object){
        if($this->channel instanceof \PEIP\INF\Channel\SubscribableChannel){
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

