<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PEIP_XML_Context_Reader
 *
 * @author timo
 */
class PEIP_XML_Context_Reader extends PEIP_ABS_Connectable {
    //put your code here

    protected $config;


    public function __construct($config){
        $this->config = (array)simplexml_load_string($config);
    }

    public function read(){
        foreach($this->config as $node){
              $this->doFireEvent('read_node', array('NODE'=>$node));

        }
        $this->config = array();
    }

}

