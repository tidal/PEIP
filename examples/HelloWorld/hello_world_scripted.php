<?php 

// This is the PEIP�s way of "hello world" done by just scripting (no config) 


// requiring autoloader
require_once(dirname(__FILE__).'/../../misc/bootstrap.php');

// simple service class
class HelloService {

    public function greet($name){
        return 'Hello '.$name;
    }

}

// create channels
$input = new PEIP\Channel\PublishSubscribeChannel('input'); 
$output = new PEIP\Channel\PollableChannel('output');


// create service instance
$service = new HelloService();
// create service activator instance
$endpoint = new PEIP\Service\ServiceActivator(array($service, 'greet'), $input, $output);
        

// send request message
$message = new PEIP\Message\StringMessage("World");
$input->send($message);

// receive reply message
$res = $output->receive(); 
print_r($res);
echo "\nReply Message: '$res'\n\n";

