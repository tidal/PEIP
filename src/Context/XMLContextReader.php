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


    public function __construct($config){ //print_r((array)simplexml_load_string($config));
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

    public static function convertXmlToArray(\SimpleXMLElement $node, array $array = array()){
        $node->type = $node->type ? $node->type : $node->getName();

        foreach($node->attributes() as $name=>$value){
            $array[$name] = (string)$value;
        }
        foreach($node->children() as $child){
                $a = $b->getName();
                if(!$b->children()){
                        $arr[$a] = trim($b[0]);
                }
                else{
                        $arr[$a][$iter] = array();
                        $arr[$a][$iter] = xml2phpArray($b,$arr[$a][$iter]);
                }
        $iter++;
        }

    }

}

