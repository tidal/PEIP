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
        foreach($this->config as $xmlNode){
            $arrayNode = PEIP_XML_Array_Translator::translate($xmlNode);
            $this->doFireEvent('read_node', array('NODE'=>$arrayNode));
        }
        $this->config = array();
    }

    public static function convertXmlToArray(SimpleXMLElement $node, array $array = array()){
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

