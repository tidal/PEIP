<?php

namespace PEIP\Translator;
/*
 * This file is part of the PEIP package.
 * (c) 2009-2011 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * XMLArrayTranslator
 * Abstract base class for transformers.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @package PEIP
 * @subpackage translator
 * @extends PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Transformer\Transformer, \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */

class XMLArrayTranslator {

    public static function translate($content){
        $array = array();
        try {
            $node = simplexml_load_string($content);
        }
        catch(\Exception $e){
            return false;
        }     
        return self::doTranslate($node);
    }

    protected static function doTranslate(\SimpleXMLElement $node){
        
        $array = array();
        $array = self::addType($array, $node);
        $array = self::addValue($array, $node);
        $array = self::addAttributes($array, $node);
        $array = self::addChildren($array, $node);
    
        return $array;
    }


    protected static function addValue($array,\SimpleXMLElement $node){
        $value = trim((string)$node);
        if($value != ''){
            $array['value'] = $value;
        }
        return $array;
    }

    protected static function addType($array,\SimpleXMLElement $node){
        $array['type'] = $node['type']
            ? (string)$node['type']
            : (string)$node->getName();
        return $array;
    }

    protected static function addAttributes($array,\SimpleXMLElement $node){
        foreach($node->attributes() as $name=>$value){
            $array[$name] = (string)$value;
        }
        return $array;
    }

    protected static function addChildren($array,\SimpleXMLElement $node){
        foreach($node->children() as $nr=>$child){
            $name = $child->getName();
            $val = self::translateArgument($child);
            if($val){
                $array['value'] = $val;
                continue;
            }

            $res = self::doTranslate($child);

            if(isset($array[$name])){
                if(is_string($array[$name])){
                    $array[$name] = array(
                        array(
                            'type'=>$name,
                            'value'=>$array[$name]
                        )
                    );
                }
            }else{
                $array[$name] = array();
            }
            $array[$name][] = $res;
        }
        return $array;
    }


    protected static function translateArgument(\SimpleXMLElement $node){
        $value = NULL;
        $name = $node->getName();
        if($name == 'value' || $name == 'list'){
            $value = self::doTranslateArgument($node);
        }
        return $value;
    }

    protected static function doTranslateArgument(\SimpleXMLElement $node){
        $name = $node->getName();
        if($name == 'value'){
            $value = self::translateValue($node);
        }elseif($name == 'list'){
            $value = self::translateList($node);
        }else{
            $value = self::doTranslate($node);
        }
        return $value;
    }

    protected function translateValue(\SimpleXMLElement $node){
        $value = NULL; 
        if(trim((string)$node) != '' || !$node->count()){
            $value = trim((string)$node);
        }elseif($node->value){
            $value = self::translateValue($node->value);
        }elseif($node->list){
            $value = self::translateList($node->list);
        }elseif($node->count()){
            foreach($node->children() as $child){
                $value = self::doTranslateArgument($child);
            }
        }
        return $value;
    }

    protected function translateList(\SimpleXMLElement $node){
        $value = array();
        foreach($node->children() as $i=>$child){
            $childValue = self::doTranslateArgument($child);
            if($child['key']){
                $value[(string)$child['key']] = $childValue;
            }else{
                $value[] = $childValue;
            }
        }
        return $value;
    }

}

