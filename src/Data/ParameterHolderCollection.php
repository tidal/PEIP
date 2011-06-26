<?php

/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * ParameterHolderCollection 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage data 
 * @implements \PEIP\INF\Data\ParameterHolderCollection
 */




namespace PEIP\Data;

class ParameterHolderCollection 
    implements \PEIP\INF\Data\ParameterHolderCollection {

    protected $factory;
    
    protected $stores;

    
    /**
     * @access public
     * @param $factory 
     * @return 
     */
    public function __construct(\PEIP\INF\Factory\DedicatedFactory $factory){
        $this->factory = $factory;
    }

    
    /**
     * @access protected
     * @param $namespace 
     * @return 
     */
    protected function getParameterHolderOrCreate($namespace){
        if(!$this->hasParameterHolder($namespace)){
            $store = $this->factory->build();
            if($store instanceof \PEIP\INF\Data\ParameterHolder){
                $this->stores[$namespace] = $store;
            }else{
                throw new Exception('Could not build Instance of \PEIP\INF\Data\ParameterHolder from factory.');
            }
        }
        return $this->stores[$namespace];
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
    public function setParameters($namespace, array $parameters){
        $this->getParameterHolderOrCreate($namespace)->setParameters($parameters);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $parameters 
     * @return 
     */
    public function addParameters($namespace, array $parameters){
        $this->getParameterHolderOrCreate($namespace)->addParameters($parameters);
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
    public function getParameters($namespace){
        $this->getParameterHolderOrCreate($namespace)->getParameters();
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function getParameter($namespace, $name){
        $this->getParameterHolderOrCreate($namespace)->getParameter($name);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @param $value 
     * @return 
     */
    public function setParameter($namespace, $name, $value){
        $this->getParameterHolderOrCreate($namespace)->setParameters($parameters);
   }
  
  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function hasParameter($namespace, $name){
        $this->getParameterHolderOrCreate($namespace)->hasParameter($name);
   }

  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    public function deleteParameter($namespace, $name){
        $this->getParameterHolderOrCreate($namespace)->setParameters($parameters);
   }

  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @param $value 
     * @return 
     */
    
    /**
     * @access public
     * @param $namespace 
     * @param $holder 
     * @return 
     */
    public function setParameterHolder($namespace, \PEIP\INF\Data\ParameterHolder $holder){
    $this->stores[$namespace] = $holder;
  } 

  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    public function getParameterHolder($namespace){
    return $this->stores[$namespace];
  }

  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    public function hasParameterHolder($namespace){
    return array_key_exists($namespace, $this->stores);
  }

  
    /**
     * @access public
     * @param $namespace 
     * @param $name 
     * @return 
     */
    
    /**
     * @access public
     * @param $namespace 
     * @return 
     */
    public function deleteParameterHolder($namespace){
    unset($this->stores[$namespace]);
  } 
    
    


}