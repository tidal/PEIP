<?php
require_once dirname(__FILE__).'/XmlArrayTranslatorTest.php';

 class Translator_AllTests extends PHPUnit_Framework_TestSuite {
	 public static function suite(){
		$suite = new PHPUnit_Framework_TestSuite('translator');
        $suite->addTestSuite('XmlArrayTranslatorTest');
		return $suite;
	}
}