<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

PHPUnit_Util_Fileloader::checkAndLoad(dirname(__FILE__).'/../_files/HelloService.php');


class ConfigMapperTest extends PHPUnit_Framework_TestCase{


    public function setup(){
        $this->mapper = new PEIP\Service\ConfigMapper;
    }

    public function testClasses(){
        $class = 'HelloService';
        $type = 'hello';
        $this->mapper->setClassMapping($type, $class);
        $this->assertEquals($class, $this->mapper->getClassMapping($type));

    }

    public function testClasses2(){
        $class = 'HelloService';
        $config = array('class'=>$class);
        $type = 'hello';
        $this->mapper->setMapping($type, $config);
        $this->assertEquals($class, $this->mapper->getClassMapping($type));

    }

    public function testClasses3(){
        $class = '\HelloService';
        $type = 'hello';
        $this->mapper->setClassMapping($type, $class);
        $expected = array('class'=>$class);
        $this->assertEquals($expected, $this->mapper->map($type, array()));

    }

    public function testSetTypes(){
        $type1 = 'foo';
        $config1 = array ();
        $mappingConfig = array (
            'type' => $type1,
        );
        $mappedConfig = array (
            'type' => $type1
        );
        // test set type
        $this->mapper->setMapping($type1, $mappingConfig);
        $this->assertEquals($mappedConfig, $this->mapper->map($type1, $config1));

    }

    public function testOverwriteTypes(){
        $type1 = 'foo';
        $type2 = 'bar';
        $config2 = array (
            'type' => $type2
        );
        $mappingConfig = array (
            'type' => $type1,
        );
        $mappedConfig = array (
            'type' => $type1
        );
        // test overwrite type
        $this->mapper->setMapping($type2, $mappingConfig);
        $this->assertEquals($mappedConfig, $this->mapper->map($type2, $config2));

    }

    public function testGetMapping(){
        $config = array(1, array(2, array(3)));
        $type = 'hello';
        $this->mapper->setMapping($type, $config);
        $this->assertEquals($config, $this->mapper->getMapping($type));

    }


    public function testClassAttributeMapping(){
        $type = 'hello';
        $attribute = 'salutation';
        $class = 'HelloService';
        $value = 'foo';
        $config = array (
          'type' => $type,
          $attribute => $value
        );
        $mappedConfig = array (
          'type' => $type,
          $attribute => $value,
          'class' => $class
        );

        $this->mapper->setClassMapping($type, $class);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));

    }

    public function testClassMapper(){
        $class = 'HelloService';
        $attribute1 = 'salutation';
        $attribute2 = 'name';
        $value1 = 'foo';
        $value2 = 'foo';
        $type = 'hello';
        $config = array (
          'type' => $type,
          $attribute1 => $value1,
          $attribute2 => $value2
        );
        $mappingConfig = array (
            'type' => $type,
            'constructor_arg' => array(
                  $attribute1,
                  $attribute2
            )
        );
        $mappedConfig = array (
            'type' => $type,
            $attribute1 => $value1,
            $attribute2 => $value2,
            'class' => $class,
            'constructor_arg' => array(
                  $value1,
                  $value2
            )
        );

        $this->mapper->setClassMapping($type, $class);
        $this->mapper->setMapping($type, $mappingConfig);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));

    }

    public function testAttributeMapperConstructor(){
        $attribute1 = 'salutation';
        $attribute2 = 'name';
        $value1 = 'foo';
        $value2 = 'foo';
        $type = 'hello';
        $config = array (
          'type' => $type,
          $attribute1 => $value1,
          $attribute2 => $value2
        );
        $mappingConfig = array (
            'type' => $type,
            'constructor_arg' => array(
                  $attribute1,
                  $attribute2
            )
        );
        $mappedConfig = array (
            'type' => $type,
            $attribute1 => $value1,
            $attribute2 => $value2,
            'constructor_arg' => array(               
                  $value1,
                  $value2
            )
        );

        $this->mapper->setMapping($type, $mappingConfig);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));
    }


    public function testAttributeMapperConstructorReference(){
        $attribute1 = 'salutation';
        $attribute2 = 'name';
        $value1 = 'foo';
        $value2 = 'foo';
        $type = 'hello';
        $config = array (
          'type' => $type,
          $attribute1 => $value1,
          $attribute2 => $value2
        );
        $mappingConfig = array (
            'type' => $type,
            'constructor_arg' => array(
                  '$'.$attribute1,
                  '$'.$attribute2
            )
        );
        $mappedConfig = array (
            'type' => $type,
            $attribute1 => $value1,
            $attribute2 => $value2,
            'constructor_arg' => array(
                  array('type'=>'service', 'ref'=>$value1),
                  array('type'=>'service', 'ref'=>$value1)
            )
        );

        $this->mapper->setMapping($type, $mappingConfig);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));
    }


    public function testAttributeMapperAction(){
        $attribute = 'salutation';
        $value = 'foo';
        $type = 'hello';
        $config = array (
          'type' => $type,
          $attribute => $value
        );
        $mappingConfig = array (
            'type' => $type,
            'action' => array(
              array(
                  'method' => 'setSalutation',
                  'arg' => array($attribute)
                )
            )
        );
        $mappedConfig = array (
            'type' => $type,
            $attribute => $value,
            'action' => array(
                array(
                      'method' => 'setSalutation',
                      'arg' => array($value)
                )
            )
        );

        $this->mapper->setMapping($type, $mappingConfig);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));
    }

    public function testAttributeMapperProperty(){
        $attribute = 'salutation';
        $value = 'foo';
        $type = 'hello';
        $config = array (
          'type' => $type,
          $attribute => $value
        );
        $mappingConfig = array (
          'type' => $type,
          'property' => array(
              array(
                  'value' => $value,
                  'name' => $attribute
            )
          )
        );
        $mappedConfig = array (
          'type' => $type,
          $attribute => $value,
          'property' => array(
              array(
                  'value' => $value,
                  'name' => $attribute
            )
          )
        );

        $this->mapper->setMapping($type, $mappingConfig);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));
    }

    public function testAttributeMapperListener(){
        $attribute = 'salutation';
        $value = 'foo';
        $type = 'hello';
        $serviceId = 'bar';
        $event = 'fooBar';
        $config = array (
          'type' => $type,
          $attribute => $serviceId
        );
        $mappingConfig = array (
          'type' => $type,
          'listener' => array(
              array(
                  'event' => $event,
                  'ref' => $attribute
            )
          )
        );
        $mappedConfig = array (
          'type' => $type,
          $attribute => $serviceId,
          'listener' => array(
              array(
                  'event' => $event,
                  'ref' => $serviceId
            )
          )
        );

        $this->mapper->setMapping($type, $mappingConfig);

        $resultConfig = $this->mapper->map($type, $config);

        $this->assertEquals(
            $mappedConfig,
            $resultConfig,
            'Mapping should return: '.PHP_EOL.print_r($mappedConfig, 1)
                .PHP_EOL.'given: '.PHP_EOL.print_r($resultConfig, 1));
    }

}