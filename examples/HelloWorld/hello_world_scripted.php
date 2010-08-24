<?php 

// This is the PEIP´s way of "hello world" done by just scripting (no config) 


// requiring autoloader
require_once(dirname(__FILE__).'/../../misc/bootstrap.php');

// simple service class
class HelloService {

	public function greet($name){
		return 'Hello '.$name;
	}

}

// create channels
$input = new PEIP_Publish_Subscribe_Channel('input'); 
$output = new PEIP_Pollable_Channel('output');

// create service instance
$service = new HelloService();
// create service activator instance
$endpoint = new PEIP_String_Service_Activator(array($service, 'greet'), $input, $output);

// send request message
$message = new PEIP_String_Message('World');
$input->send($message);

// receive reply message
$res = $output->receive(); 
echo "\nReply Message: '$res'\n\n";

function convert($size)
 {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
 }

echo convert(memory_get_usage(true)); 
