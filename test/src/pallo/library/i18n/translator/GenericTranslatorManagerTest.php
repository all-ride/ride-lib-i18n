<?php

namespace pallo\library\i18n\translator;

use pallo\library\i18n\locale\GenericLocale;
use pallo\library\i18n\translator\io\TranslationIOMock;
use pallo\library\i18n\translator\Translator;

use \PHPUnit_Framework_TestCase;

class GenericTranslatorManagerTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->englishLocale = new GenericLocale('en', 'English');

        $this->manager = new GenericTranslatorManager(new TranslationIOMock());
    }

    public function testGetTranslatorReturnsInstanceOfTranslator() {
        $translator = $this->manager->getTranslator($this->englishLocale);

        $this->assertTrue($translator instanceof Translator);
        $this->assertEquals('A label', $translator->translate('label'));

        $this->assertTrue($translator === $this->manager->getTranslator($this->englishLocale));
    }

}