<?php
/*
 * This file is part of the PEIP package.
 * (c) 2010 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PEIP_XML_Array_Translator
 * Abstract base class for transformers.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage translator
 * @extends PEIP_Pipe
 * @implements PEIP_INF_Transformer, PEIP_INF_Connectable, PEIP_INF_Subscribable_Channel, PEIP_INF_Channel, PEIP_INF_Handler, PEIP_INF_Message_Builder
 */
class PEIP_XML_Array_Translator {

    public static function translate($content){
        $array = array();
        try {
            $node = simplexml_load_string($content);
        }
        catch(Exception $e){
            return false;
        }     
        
        return self::doTranslate($node);
    }

    protected static function doTranslate(SimpleXMLElement $node){
        
        $array = array();
        $array['type'] = $node['type']
            ? (string)$node['type']
            : (string)$node->getName();
        $value = (string)$node;
        if($value != ''){
            $array['value'] = $value;
        }

        foreach($node->attributes() as $name=>$value){
            $array[$name] = (string)$value;
        }
        foreach($node->children() as $nr=>$child){
            $name = $child->getName();
            $res = self::doTranslate($child);
            if(isset($array[$name]) || !is_array($array[$name])){
                if(is_string($array[$name])){
                    $array[$name] = array(
                        array(
                            'type'=>$name,
                            'value'=>$array[$name]
                        )
                    );
                }else{
                    $array[$name] = array();
                }
            }else{
                $array[$name] = array();
            }
            $array[$name][] = $res;
        }
    
        return $array;
    }

}

