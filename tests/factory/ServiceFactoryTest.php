<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/TestServiceFactory.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/TestConnectable.php');
PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/InnerDependencyService.php');


class ServiceFactoryTest extends PHPUnit_Framework_TestCase implements \PEIP\INF\Service\ServiceProvider  {


    protected 
        $services = array(),
        $factory;


    public function setup(){ 
        $ids = array('foo', 'bar');
        foreach($ids as $id){
            $this->services[$id] = new HelloService($id);
        }
        $this->services['con'] = new TestConnectable;

        $this->factory = new TestServiceFactory($this);

    }

    public function testGetServiceProvider(){
        $this->assertSame($this, $this->factory->getServiceProvider());
    }


    public function testBuildArg1(){
        $argValue = 'foo';
        $argConfig = $argValue;

        $this->assertEquals($argValue, $this->factory->arg($argConfig));
    }

    public function testBuildArg2(){
        $argValue = 'foo';
        $argConfig = array (
          'type' => 'constructor_arg',
          'value' => $argValue,
        );

        $this->assertEquals($argValue, $this->factory->arg($argConfig));
    }


    public function testBuildArg3(){
        $argValue = array(1,2,3);
        $argConfig = array (
          'type' => 'value',
          'value' => $argValue,
        );
        $this->assertEquals($argValue, $this->factory->arg($argConfig));
    }


    public function testBuildArg4(){
        $argValue = array(1,2,array(1,2,3));
        $argConfig = array (
          'type' => 'value',
          'value' => $argValue,
        );
        $this->assertEquals($argValue, $this->factory->arg($argConfig));
    }


    public function testBuildArgServiceRef1(){
        $serviceId = 'foo';
        $argConfig = array (
          'type' => 'service',
          'ref' => $serviceId
        );
        $this->assertSame($this->services[$serviceId], $this->factory->arg($argConfig));
    }

    public function testBuildArgServiceRef2(){
        $serviceId = 'foo';
        $argConfig = array (
          'type' => 'service',
          'ref' => $serviceId
        );
        $this->assertSame($this->services[$serviceId], $this->factory->arg($argConfig));
    }

    public function testDoBuildDefaultConstructor(){
       $name = 'Bar';
       $class = 'HelloService';
       $config = array(
           'class' => $class
       );
       $arguments = array($name);

       $service =  $this->factory->doBuild($config, $arguments);

       $this->assertTrue($service instanceof $class);
       $this->assertEquals($name, $service->name);
    }

    public function testDoBuildConfigConstructor(){
       $name = 'Bar';
       $class = 'HelloService';
       $config = array(
           'constructor' => 'getInstance',
           'class' => $class
       );
       $arguments = array($name);

       $service =  $this->factory->doBuild($config, $arguments);

       $this->assertTrue($service instanceof $class);
       $this->assertEquals($name, $service->name);
    }

    public function testDoBuildDefaultClassDefaultConstructor(){
       $name = 'Bar';
       $class = 'HelloService';
       $config = array();
       $arguments = array($name);

       $service =  $this->factory->doBuild($config, $arguments, $class);

       $this->assertTrue($service instanceof $class);
       $this->assertEquals($name, $service->name);
    }

    public function testDoBuildDefaultClassConfigConstructor(){
       $name = 'Bar';
       $class = 'HelloService';
       $config = array(
           'constructor' => 'getInstance'
       );
       $arguments = array($name);

       $service =  $this->factory->doBuild($config, $arguments, $class);

       $this->assertTrue($service instanceof $class);
       $this->assertEquals($name, $service->name);
    }

    public function testDoBuildException1(){
       $name = 'Bar';
       $class = 'HelloService_FOO';
       $arguments = array();
       $config = array();
       try{
            $service =  $this->factory->doBuild($config, $arguments, $class);
       }
       catch(Exception $e){
           return;
       }
       $this->fail('An Exception should have been thrown.');
    }

    public function testDoBuildException2(){
       $name = 'Bar';
       $arguments = array();
       $config = array();
       try{
            $service =  $this->factory->doBuild($config, $arguments);
       }
       catch(Exception $e){ 
           return;
       }
       $this->fail('An Exception should have been thrown.');
    }

    public function testCreateService(){
       $name = 'Bar';
       $class = 'HelloService';
       $config = array(
           'constructor' => 'getInstance',
           'class' => $class,
           'constructor_arg' => array(
                $name
           )
       );

       $service =  $this->factory->createService($config);

       $this->assertTrue($service instanceof $class);
       $this->assertEquals($name, $service->name);        
    }

    public function testBuild(){
       $name = 'Bar';
       $class = 'HelloService';
       $arguments = array($name);

       $service =  $this->factory->build($class, $arguments);

       $this->assertTrue($service instanceof $class);
       $this->assertEquals($name, $service->name);
    }


    public function testModifySetter1(){
        $value = 'foo';
        $serviceId = 'foo';
        $service = $this->services[$serviceId];
        $config = array (
          'type' => 'service',
          'property' => array(
              array(
                  'value' => $value,
                  'setter' => 'setSalutation'
            )
          )
        );
        $this->assertNotEquals($value, $service->salutation);
        $this->factory->modify($service, $config);
        $this->assertEquals($value, $service->salutation);
    }

    public function testModifySetter2(){
        $value = 'foo';
        $serviceId = 'foo';
        $service = $this->services[$serviceId];
        $config = array (
          'type' => 'service',
          'property' => array(
              array(
                  'value' => $value,
                  'method' => 'setSalutation'
            )
          )
        );
        $this->assertNotEquals($value, $service->salutation);
        $this->factory->modify($service, $config);
        $this->assertEquals($value, $service->salutation);
    }

    public function testModifySetter3(){
        $value = 'foo';
        $serviceId = 'foo';
        $service = $this->services[$serviceId];
        $config = array (
          'type' => 'service',
          'property' => array(
              array(
                  'value' => $value,
                  'name' => 'salutation'
            )
          )
        );
        $this->assertNotEquals($value, $service->salutation);
        $this->factory->modify($service, $config);
        $this->assertEquals($value, $service->salutation);
    }

    public function testModifyProperty(){
        $value = 'bar';
        $serviceId = 'foo';
        $service = $this->services[$serviceId];
        $config = array (
          'type' => 'service',
          'property' => array(
              array(
                  'value' => $value,
                  'name' => 'name'
            )
          )
        );
        $this->assertNotEquals($value, $service->name);
        $this->factory->modify($service, $config);
        $this->assertEquals($value, $service->name);
    }

    public function testModifyCallMethod(){
        $value = 'bar';
        $serviceId = 'foo';
        $service = $this->services[$serviceId];
        $config = array (
          'type' => 'service',
          'action' => array(
              array(
                  'method' => 'setSalutation',
                  'arg' => array($value)
            )
          )
        );
        $this->assertNotEquals($value, $service->salutation);
        $this->factory->modify($service, $config);
        $this->assertEquals($value, $service->salutation);
    }

    public function testModifyListenerStaticMethod(){ 
        $event = 'foo';
        $serviceId = 'con';
        $service = $this->services[$serviceId];
        $class = 'TestConnectable';
        $config = array (
          'type' => 'service',
          'listener' => array(
              array(
                  'event' => $event,
                  'class' => $class,
                  'method' => 'staticCallback'
            )
          )
        );
        TestConnectable::$staticCalledBack = false;

        $this->assertFalse($service->eventFired);
        $this->assertFalse($service->calledBack);
        
        $this->factory->modify($service, $config);
        $service->fireEvent($event);

        $this->assertTrue(TestConnectable::$staticCalledBack);
        $this->assertTrue($service->eventFired);
        $this->assertFalse($service->calledBack);

    }

    public function testModifyListenerInstanceMethod(){ 
        $event = 'foo';
        $serviceId = 'con';
        $service = $this->services[$serviceId];
        $class = 'TestConnectable';
        $config = array (
          'type' => 'service',
          'listener' => array(
              array(
                  'event' => $event,
                  'ref' => $serviceId,
                  'method' => 'callback'
            )
          )
        );
        TestConnectable::$staticCalledBack = false;

        $this->assertFalse($service->eventFired);
        $this->assertFalse($service->calledBack);

        $this->factory->modify($service, $config);
        $service->fireEvent($event);

        $this->assertFalse(TestConnectable::$staticCalledBack);
        $this->assertTrue($service->eventFired);
        $this->assertTrue($service->calledBack);

    }


    public function testModifyListenerHandlerInstance(){ 
        $event = 'foo';
        $serviceId = 'con';
        $service = $this->services[$serviceId];
        $class = 'TestConnectable';
        $config = array (
          'type' => 'service',
          'listener' => array(
              array(
                  'event' => $event,
                  'ref' => $serviceId
            )
          )
        );
        TestConnectable::$staticCalledBack = false;

        $this->assertFalse($service->eventFired);
        $this->assertFalse($service->calledBack);

        $this->factory->modify($service, $config);
        $service->fireEvent($event);

        $this->assertFalse(TestConnectable::$staticCalledBack);
        $this->assertTrue($service->eventFired);
        $this->assertTrue($service->calledBack);

    }

    public function testBuildAndModify(){
        $name = 'bar';
        $class = 'OuterDependencyService';
       $config = array(
           'class' => $class,
           'constructor_arg' => array(
                $name
           )
       );
       $arguments = array($name);

        $service = $this->factory->buildAndModify($config, $arguments);
        $this->assertTrue($service instanceof $class);
    }

    public function testBuildAndModifyReferenceProperty(){
        $name = 'bar';
        $outerClass = 'OuterDependencyService';
        $innerClass = 'InnerDependencyService';
       $config = array(
           'class' => $outerClass,
           'constructor_arg' => array(
                $name
           ),
           'ref_property' => 'service'
       );
       $arguments = array($name);

        $service = $this->factory->buildAndModify($config, $arguments);
        $this->assertTrue($service instanceof $innerClass);
    }

    public function testBuildAndModifyReferenceMethod(){
        $name = 'bar';
        $outerClass = 'OuterDependencyService';
        $innerClass = 'InnerDependencyService';
       $config = array(
           'class' => $outerClass,
           'constructor_arg' => array(
                $name
           ),
           'ref_method' => array(
              'method' => 'getService'
          )
       );
       $arguments = array($name);

        $service = $this->factory->buildAndModify($config, $arguments);
        $this->assertTrue($service instanceof $innerClass);
    }

    public function testBuildAndModifyReferenceMethods(){
        $name = 'bar';
        $outerClass = 'OuterDependencyService';
        $innerClass = 'InnerDependencyService';
       $config = array(
           'class' => $outerClass,
           'constructor_arg' => array(
                $name
           ),
           'ref_method' => array(
              array(
                  'method' => 'getService'
            )
          )
       );
       $arguments = array($name);

        $service = $this->factory->buildAndModify($config, $arguments);
        $this->assertTrue($service instanceof $innerClass);
    }

    public function testBuildAndModifyReferenceMethodsArguments(){
        $name = 'bar';
        $outerClass = 'OuterDependencyService';
        $innerClass = 'InnerDependencyService';
       $config = array(
           'class' => $outerClass,
           'constructor_arg' => array(
                $name
           ),
           'ref_method' => array(
              array(
                  'method' => 'getServiceByName',
                  'arg' => array($name)
            )
          )
       );
       $arguments = array($name);

        $service = $this->factory->buildAndModify($config, $arguments);
        $this->assertTrue($service instanceof $innerClass);
    }


    public function testBuildAndModifyException1(){
       try{
            $service = $this->factory->buildAndModify(array(), array());
       }
       catch(Exception $e){
           return;
       }
       $this->fail('An Exception should have been thrown.');
    }

    public function testBuildAndModifyException2(){
        $name = 'bar';
        $outerClass = 'OuterDependencyService';
        $innerClass = 'InnerDependencyService';
       $config = array(
           'class' => $outerClass,
           'constructor_arg' => array(
                $name
           ),
           'ref_method' => array(
              array(
                  'method' => 'getServiceByName',
                  'arg' => array($name.'FOOO')
            )
          )
       );
       $arguments = array($name);
       try{
            $service = $this->factory->buildAndModify($config, $arguments);
       }
       catch(Exception $e){
           return;
       }
       $this->fail('An Exception should have been thrown.');
    }


    ////////////////////////////////////////////////////////////////////
    //   \PEIP\INF\Service\ServiceProvider Implementation
    ////////////////////////////////////////////////////////////////////
    public function getServices(){
        return $this->services;
    }

    /**
     * returns a service-object for given key
     *
     * @access public
     * @return object the requested service
     */

    public function provideService($id){
        return $this->services[$id];
    }

}