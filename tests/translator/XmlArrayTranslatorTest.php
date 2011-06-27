<?php

require_once dirname(__FILE__).'/../../misc/bootstrap.php'; 

class XmlArrayTranslatorTest extends PHPUnit_Framework_TestCase  {

    public function testTranslateAttributes(){
        $xml = '<context id="foo" name="bar"/>';
        $array = array('type'=>'context', 'id'=>'foo', 'name'=>'bar');

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateValue(){
        $xml = '<context id="foo" value="bar"/>';
        $array = array('type'=>'context', 'id'=>'foo', 'value'=>'bar');

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateValue2(){
        $xml = '<context id="foo"><value>bar</value></context>';
        $array = array('type'=>'context', 'id'=>'foo', 'value'=>'bar');

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateValue3(){
        $xml = '<context id="foo"><value>bar</value><value>foo</value></context>';
        $array = array('type'=>'context', 'id'=>'foo', 'value'=>'foo');

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }


    public function testTranslateValue4(){
        $xml = '<context id="foo"><value><value>foo</value></value></context>';
        $array = array('type'=>'context', 'id'=>'foo', 'value'=>'foo');

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }


    public function testTranslateValue5(){
        $xml = '<context id="foo"><value><service ref="foo"/></value></context>';
        $array = array('type'=>'context', 'id'=>'foo', 'value'=>array('type'=>'service', 'ref'=>'foo'));

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateListNumeric(){
        $xml = '<context id="foo"><list><value>foo</value><value>bar</value></list></context>';
        $array = array(
            'type'=>'context',
            'id'=>'foo',
            'value'=>array('foo', 'bar'));

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateListAssoc(){
        $xml = '<context id="foo"><list><value key="foo">foo</value><value key="bar">bar</value></list></context>';
        $array = array(
            'type'=>'context',
            'id'=>'foo',
            'value'=>array('foo'=>'foo', 'bar'=>'bar'));

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }


    public function testTranslateListNested(){
        $xml = '<context id="foo">
                    <value>
                        <list>
                            <value>fu</value>
                            <list><value>bahr</value></list>
                        </list>
                    </value>
                </context>';
        $array = array(
            'type'=>'context',
            'id'=>'foo',
            'value'=>array('fu', array('bahr')));

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }


    public function testTranslateCharData(){
        $xml = '<context id="foo">bar</context>';
        $array = array('type'=>'context', 'id'=>'foo', 'value'=>'bar');

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateSingleChildren(){
        $xml = '<context><foo>bar</foo></context>';
        $array = array(
            'type'=>'context',
            'foo'=>array(array('type'=>'foo', 'value'=>'bar'))
        );

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertEquals(
            self::asort($array),
            self::asort($translation),
            'Translator should have returned: '.print_r($array, 1)
        );
    }

    public function testTranslateMultipleChildren(){
        $xml = '<context><bar>fu</bar><bar>foo</bar></context>';
        $array = array(
            'type'=>'context',
            'bar'=> array(
                array('type'=>'bar', 'value'=>'fu'),
                array('type'=>'bar', 'value'=>'foo')
            ));

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }
    
    public function testTranslateChildReplacesAttribute(){
        $xml = '<context bar="foo"><bar>fu</bar></context>';
        $array = array(
            'type'=>'context',
            'bar'=>array(
                array('type'=>'bar', 'value'=>'foo'),
                array('type'=>'bar', 'value'=>'fu')
            )
        );
        
        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testTranslateNestedChilds(){
        $xml = '<context><bar><foo>fu</foo></bar></context>';
        $array = array(
            'type'=>'context',
            'bar'=>array(
                array(
                    'type'=>'bar',
                    'foo'=>array(
                        array('type'=>'foo', 'value'=>'fu')
                    )
                )
            )
        );

        $translation = PEIP\Translator\XMLArrayTranslator::translate($xml);
        $this->assertSame(self::asort($array), self::asort($translation));
    }

    public function testWrongData(){
        $this->assertFalse(PEIP\Translator\XMLArrayTranslator::translate(321));
    }



    protected static function asort($array){
        array_multisort($array, SORT_STRING);
        return $array;        
    }


}

