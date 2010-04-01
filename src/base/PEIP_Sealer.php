<?php

/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_Sealer 
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP 
 * @subpackage base 
 * @implements PEIP_INF_Sealer, PEIP_INF_Unsealer
 */

// PHP5.3

class PEIP_Sealer implements PEIP_INF_Sealer, PEIP_INF_Unsealer{

    protected $store;
    
    
    /**
     * @access public
     * @param $store 
     * @return 
     */
    public function __construct(SplObjectStorage $store = NULL){
        $this->store = (bool)$store ? $store : new SplObjectStorage;    
    }   
    
    
    /**
     * @access public
     * @param $value 
     * @param $box 
     * @return 
     */
    public function seal($value, $box = false){
        $box = (bool)$box ? $box : new stdClass;
        $this->store[$box] = $value;        
        return $box;
    }

    
    /**
     * @access public
     * @param $box 
     * @return 
     */
    public function unseal($box){
        return $this->store[$box];
    }
}
