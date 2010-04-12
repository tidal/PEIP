<?php 

// This is the PEIP´s way of "hello world" done by configuration (no config) 
// (Contrary to the scripted version) to decouple PEIP from your application 
// this time a Gateway is created.


// requiring autoloader
require_once(__DIR__.'/../misc/bootstrap.php');

// simple service class
class HelloService {

	public function greet($name){
		return 'Hello '.$name;
	}

}

// creating context instance from config file
$context = PEIP_XML_Context::createFromFile('config/config.xml'); 

// requiring the gateway instance
$Gateway = $context->getGateway('HelloWorldGateway');

// sending a string and receiving a string answer
echo $Gateway->sendAndReceive('World');

