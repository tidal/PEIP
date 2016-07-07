<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php';

class XmlArrayTranslatorTest extends PHPUnit_Framework_TestCase
{
    public function testTranslateAttributes()
    {
        $xml = '<context id="foo" name="bar"/>';
        $array = ['type' => 'context', 'id' => 'foo', 'name' => 'bar'];

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateCharData()
    {
        $this->markTestIncomplete();
        $xml = '<context id="foo">bar</context>';
        $array = ['type' => 'context', 'value' => 'bar', 'id' => 'foo'];

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);

        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateSingleChildren()
    {
        $this->markTestIncomplete();
        $xml = '<context><foo>bar</foo></context>';
        $array = [
            'type' => 'context',
            'foo'  => [['type' => 'foo', 'value' => 'bar']],
        ];

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(
                self::asort($array),
                self::asort($translation));
    }

    public function testTranslateMultipleChildren()
    {
        $this->markTestIncomplete();
        $xml = '<context><bar>fu</bar><bar>foo</bar></context>';
        $array = [
            'type' => 'context',
            'bar'  => [
                ['type' => 'bar', 'value' => 'fu'],
                ['type' => 'bar', 'value' => 'foo'],
            ], ];

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateChildReplacesAttribute()
    {
        $this->markTestIncomplete();
        $xml = '<context bar="foo"><bar>fu</bar></context>';
        $array = [
            'type' => 'context',
            'bar'  => [
                ['type' => 'bar', 'value' => 'foo'],
                ['type' => 'bar', 'value' => 'fu'],
            ],
        ];

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateNestedChilds()
    {
        $this->markTestIncomplete();
        $xml = '<context><bar><foo>fu</foo></bar></context>';
        $array = [
            'type' => 'context',
            'bar'  => [
                [
                    'type' => 'bar',
                    'foo'  => [
                        ['type' => 'foo', 'value' => 'fu'],
                    ],
                ],
            ],
        ];

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testWrongData()
    {
        $this->assertFalse(PEIP\Translator\XMLArrayTranslator::translate(321));
    }


    protected static function asort($array)
    {
        array_multisort($array, SORT_ASC, SORT_STRING);

        return $array;
    }
}
