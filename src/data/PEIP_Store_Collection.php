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
 * Class to act as a namespaced store for arbitrary values.
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

    protected 
    	$factory,
    	$stores;
 
    /**
     * constructor
     * 
     * @access public
     * @param PEIP_INF_Dedicated_Factory $factory a factory instance to create new stores
     * @return 
     */
    public function __construct(PEIP_INF_Dedicated_Factory $factory){
        $this->factory = $factory;
    }
 
    /**
     * Returns a PEIP_INF_Store instance for a given namespace.
     * Creates a new PEIP_INF_Store instance if none is allerady set for given namespace.
     * 
     * @access protected
     * @param string $namespace the namespace to get the store for
     * @return PEIP_INF_Store a store for given namespace
     */
    protected function getStoreOrCreate($namespace){
        if(!$this->hasPrivateValue($namespace)){
            $store = $this->factory->build();
            if($store instanceof PEIP_INF_Store){
                $this->setPrivateValue($namespace, $store);
            }else{
                throw new Exception('Could not build Instance of PEIP_INF_Store from factory.');
            }
        }
        return $this->getPrivateValue($namespace);
    }

    /**
     * Sets all values for a namespace as key/value pairs array.
     * 
     * @access public
     * @param string $namespace the namspace to set values for 
     * @param array $values key/value pairs to store
     * @return 
     */
    public function setValues($namespace, array $values){
        $this->getStoreOrCreate($namespace)->setValues($values);
   	}
  
    /**
     * Adds values for a namespace as key/value pairs array.
     * Overwrites value for a key if allready has been set.
     * 
     * @access public
     * @param string $namespace the namspace to add values to 
     * @param $values 
     * @return 
     */
    public function addValues($namespace, array $values){
        $this->getStoreOrCreate($namespace)->addValues($values);
   	}
    
    /**
     * returns all values for a namespace as key/value pairs
     * 
     * @access public
     * @param string $namespace the namspace to return values for  
     * @return array stored key/value pairs
     */
    public function getValues($namespace){
        $this->getStoreOrCreate($namespace)->getValues();
   	}
  
    /**
     * Returns the value for a given key on a given namespace
     * 
     * @access public
     * @param string $namespace the namspace to return value for 
     * @param string $key the key to return value for 
     * @return mixed value for the given key on the given namespace
     */
    public function getValue($namespace, $key){
        $this->getStoreOrCreate($namespace)->getValue($key);
   	}
   
    /**
     * Stores the value for a given key on a given namespace
     * 
     * @access public
     * @param string $namespace the namspace to store a value for 
     * @param string $key key to store value for
     * @param mixed $value the value to store 
     * @return 
     */
    public function setValue($namespace, $key, $value){
        $this->getStoreOrCreate($namespace)->setValues($values);
   	}
  
    /**
     * Checks wether a value is stored for given key on a given namespace.
     * 
     * @access public
     * @param $namespace the namespace to look for a value
     * @param string $key the key to look for a value 
     * @return 
     */
    public function hasValue($namespace, $key){
        $this->getStoreOrCreate($namespace)->hasValue($key);
   	}

    /**
     * Removes the value for a given key on a given namespace
     * 
     * @access public
     * @param string $namespace the namespace to remove the value from
     * @param string $key the key to remove the value from
     * @return 
     */
    public function deleteValue($namespace, $key){
        $this->getStoreOrCreate($namespace)->setValues($values);
   	}

    /**
     * Sets a store instance (PEIP_INF_Store) for a given namespace
     * 
     * @access public
     * @param string $namespace the namespace to set the store for
     * @param PEIP_INF_Store $store the store instance to register for the namespace
     * @return 
     */
    public function setStore($namespace, PEIP_INF_Store $store){
        $this->setInternalValue($namespace, $store);    
  	} 

    /**
     * returns the store instance for a given namespace
     * 
     * @access public
     * @param string $namespace the namespace to return the store for 
     * @return PEIP_INF_Store store instance for given namespace (if set)
     */
    public function getStore($namespace){
        $this->getInternalValue($namespace);
  	}
 
    /**
     * Checks wether a store has been registered for a given namespace
     * 
     * @access public
     * @param string $namespace the namespace to check for a store instance 
     * @return boolean wether a store has been registered for the given namespace
     */
    public function hasStore($namespace){
    	return $this->hasInternalValue($namespace);
  	}
 
    /**
     * Unregisters the store for a given namespace
     * 
     * @access public
     * @param string $namespace the namespace to ungegister the store for 
     * @return 
     */
    public function deleteStore($namespace){
        return $this->deleteInternalValue($namespace);
  	}    

}