<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Store_Collection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @extends PEIP_Internal_Store_Abstract
 * @implements PEIP_INF_Store_Collection
 */



class PEIP_Store_Collection 
    extends PEIP_Internal_Store_Abstract 
    implements PEIP_INF_Store_Collection{

    protected $factory;
    
    protected $stores;

    
    /**
     * @access public
     * @param $factory 
     * @return 
     */
    public function __construct(PEIP_INF_Dedicated_Factory $factory){
        $this->factory = $factory;
    }

    
    /**
     * @access protected
     * @param $namespace 
     * @return 
     */
    protected function getStoreOrCreate($namespace){
        if(!$this->hasPrivateValue($namespace)){
            $store = $this->factory->build();
            if($store instanceof PEIP_Store_Interface){
                $this->setPrivateValue($namespace, $store);
            }else{
                throw new Exception('Could not build Instance of PEIP_Store_Interface from factory.');
            }
        }
        return $this->getPrivateValue($namespace);
    }
    
  
    /**
     * @access public
     * @param $namespace 
     * @param $parameters 
     * @return 
     */
    
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @param $value 
     * @return 
     */
    public function setValues($namespace, array $parameters){
        $this->getStoreOrCreate($namespace)->setValues($parameters);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $parameters 
     * @return 
     */
    public function addValues($namespace, array $parameters){
        $this->getStoreOrCreate($namespace)->addValues($parameters);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function getValues($namespace){
        $this->getStoreOrCreate($namespace)->getValues();
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function getValue($namespace, $name){
        $this->getStoreOrCreate($namespace)->getValue($name);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @param $value 
     * @return 
     */
    public function setValue($namespace, $name, $value){
        $this->getStoreOrCreate($namespace)->setValues($parameters);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function hasValue($namespace, $name){
        $this->getStoreOrCreate($namespace)->hasValue($name);
   }

  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function deleteValue($namespace, $name){
        $this->getStoreOrCreate($namespace)->setValues($parameters);
   }

  
    /**
     * @access public
     * @param $namespace 
     * @param $store 
     * @return 
     */
    public function setStore($namespace, PEIP_Store_Interface $store){
        $this->setInternalValue($namespace, $store);    
  } 

  
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    public function getStore($namespace){
        $this->getInternalValue($namespace);
  }

  
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    public function hasStore($namespace){
    return $this->hasInternalValue($namespace);
  }

  
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    public function deleteStore($namespace){
        return $this->deleteInternalValue($namespace);
  } 
    
    
    
    

}