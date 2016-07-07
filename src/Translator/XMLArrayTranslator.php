<?php

namespace PEIP\Translator;

/*
 * This file is part of the PEIP package.
 * (c) 2009-2016 Timo Michna <timomichna/yahoo.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * XMLArrayTranslator
 * Abstract base class for transformers.
 *
 * @author Timo Michna <timomichna/yahoo.de>
 * @extends PEIP\Pipe\Pipe
 * @implements \PEIP\INF\Transformer\Transformer, \PEIP\INF\Event\Connectable, \PEIP\INF\Channel\SubscribableChannel, \PEIP\INF\Channel\Channel, \PEIP\INF\Handler\Handler, \PEIP\INF\Message\MessageBuilder
 */
class XMLArrayTranslator
{
    public static function translate($content)
    {
        try {
            $node = simplexml_load_string($content);
            // fix for hhvm
            if (!($node instanceof \SimpleXMLElement)) {
                throw new \Exception('loading XML failed');
            }
        } catch (\Exception $e) {
            return false;
        }

        return self::doTranslate($node);
    }

    protected static function doTranslate(\SimpleXMLElement $node)
    {
        $array = [];
        $array['type'] = $node['type']
            ? (string) $node['type']
            : (string) $node->getName();
        $value = (string) $node;
        if ($value != '') {
            $array['value'] = $value;
        }

        foreach ($node->attributes() as $name => $value) {
            $array[$name] = (string) $value;
        }
        foreach ($node->children() as $nr => $child) {
            $name = $child->getName();
            $res = self::doTranslate($child);

            if (isset($array[$name])) {
                if (is_string($array[$name])) {
                    $array[$name] = [
                        [
                            'type'  => $name,
                            'value' => $array[$name],
                        ],
                    ];
                }
            } else {
                $array[$name] = [];
            }
            $array[$name][] = $res;
        }

        return $array;
    }
}
