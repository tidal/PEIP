<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloServiceHandler.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/NoReplyChannel.php');

class ServiceProviderTest extends PHPUnit_Framework_TestCase  {


	public function setup(){
		//$this->serviceProvider = new PEIP_Service_Provider($config, $idAttribute);
	}

    public function testConstruct(){
        $provider = new PEIP_Service_Provider();

        $this->assertEquals(get_class($provider), 'PEIP_Service_Provider');
    }

    public function testConstructEmptyConfigArray(){
        $provider = new PEIP_Service_Provider(array());

        $this->assertEquals(get_class($provider), 'PEIP_Service_Provider');
    }

    public function testConstructEmptyConfigArrayOfArray(){
        $provider = new PEIP_Service_Provider(array(array(), array()));

        $this->assertEquals(get_class($provider), 'PEIP_Service_Provider');
    }
    public function testAddConfig(){
        $provider = new PEIP_Service_Provider();

        $provider->addConfig(array('id'=>'123'));
        $this->assertEquals(get_class($provider), 'PEIP_Service_Provider');
    }
    
    public function testgetServiceConfig(){
        $provider = new PEIP_Service_Provider();
        $id = 'id123';
        $config = array('id'=>$id);
        $provider->addConfig($config);
        $this->assertEquals($config, $provider->getServiceConfig($id));
    }

    public function testgetServiceConfigDifferentIdAttribute(){
        $provider = new PEIP_Service_Provider(array(), 'name');
        $id = 'id123';
        $name = 'name123';
        $config = array('id'=>$id, 'name'=>$name);
        $provider->addConfig($config);
        $this->assertNotEquals($config, $provider->getServiceConfig($id));
        $this->assertEquals($config, $provider->getServiceConfig($name));
    }
}
