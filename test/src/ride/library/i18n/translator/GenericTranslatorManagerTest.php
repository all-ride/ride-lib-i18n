<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\GenericLocale;
use ride\library\i18n\translator\io\TranslationIOMock;
use ride\library\i18n\translator\Translator;

use PHPUnit\Framework\TestCase;

class GenericTranslatorManagerTest extends TestCase {

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