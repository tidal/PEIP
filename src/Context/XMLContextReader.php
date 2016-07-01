<?php

namespace PEIP\Context;
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XMLContextReader
 *
 * @author timo
 */
use PEIP\Translator\XMLArrayTranslator;

class XMLContextReader extends \PEIP\ABS\Base\Connectable {
    //put your code here

    protected $config;


    public function __construct($config){ 
        $this->config = ($config);       
    }

    public function read(){      
        $iterator = new \SimpleXMLIterator($this->config);
        $iterator->rewind();
        while($iterator->valid()){
            
            $arrayNode = XMLArrayTranslator::translate($iterator->current()->asXML()); 
            $this->doFireEvent('read_node', array('NODE'=>$arrayNode));            
            $iterator->next();
        }
        
        foreach($iterator as $xmlNode){  

        }
        $this->config = array();
    }

}

