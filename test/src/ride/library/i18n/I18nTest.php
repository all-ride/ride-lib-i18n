<?php

namespace ride\library\i18n;

use ride\library\i18n\locale\io\LocaleIOMock;
use ride\library\i18n\locale\GenericLocaleManager;
use ride\library\i18n\locale\Locale;
use ride\library\i18n\translator\io\TranslationIOMock;
use ride\library\i18n\translator\Translator;
use ride\library\i18n\translator\GenericTranslatorManager;

use PHPUnit\Framework\TestCase;

class I18nTest extends TestCase {

    private $i18n;

    public function setUp() {
        $localeIO = new LocaleIOMock();
        $translationIO = new TranslationIOMock();

        $this->i18n = new I18n(new GenericLocaleManager($localeIO), new GenericTranslatorManager($translationIO));
    }

    public function testSetTranslatorManager() {
        $this->i18n->setTranslatorManager(new GenericTranslatorManager(new TranslationIOMock()));

        $this->assertSame('nl', $this->i18n->getTranslator()->getLocale());
    }

    public function testGetLocales() {
        $locales = $this->i18n->getLocales();

        $this->assertEquals(4, count($locales));
    }

    public function testGetLocaleWithoutParameterGivesFirstOfTheLocalesList() {
        $locale = $this->i18n->getLocale();

        $this->assertTrue($locale instanceof Locale);
        $this->assertEquals('nl', $locale->getCode());
    }

    public function testHasLocaleReturnsIfLocaleExists() {
        $this->assertTrue($this->i18n->hasLocale('en'));
        $this->assertTrue($this->i18n->hasLocale('nl'));
        $this->assertTrue($this->i18n->hasLocale('en_GB'));
        $this->assertTrue($this->i18n->hasLocale('fr'));

        $this->assertFalse($this->i18n->hasLocale('ru'));
        $this->assertFalse($this->i18n->hasLocale('it'));
        $this->assertFalse($this->i18n->hasLocale('de'));
        $this->assertFalse($this->i18n->hasLocale('uk'));
    }

    public function testSetCurrentLocaleModifiesCurrentLocale() {
        $locale = $this->i18n->getLocale();
        $this->assertTrue($locale instanceof Locale);
        $this->assertEquals('nl', $locale->getCode());

        $locale = $this->i18n->getLocale('en_GB');
        $this->assertTrue($locale instanceof Locale);

        $this->i18n->setCurrentLocale($locale);

        $locale = $this->i18n->getLocale();
        $this->assertTrue($locale instanceof Locale);
        $this->assertEquals('en_GB', $locale->getCode());
    }

    public function testGetLocaleList() {
        $expected = array(
        	'nl' => 'Nederlands',
        	'en' => 'English',
        	'fr' => 'français',
        	'en_GB' => 'British English'
        );

        $result = $this->i18n->getLocaleList();

        $this->assertEquals($expected, $result);
    }

    public function testGetLocaleCodeList() {
        $expected = array(
        	'nl' => 'nl',
        	'en' => 'en',
        	'fr' => 'fr',
        	'en_GB' => 'en_GB'
        );

        $result = $this->i18n->getLocaleCodeList();

        $this->assertEquals($expected, $result);
    }

    /**
     * @expectedException ride\library\i18n\exception\LocaleNotFoundException
     */
    public function testGetLocaleThrowsLocaleNotFoundExceptionWhenLocaleNotAvailable() {
        $this->i18n->getLocale('uk');
    }

    public function testGetTranslatorAcceptsStringArgument() {
        $translator = $this->i18n->getTranslator('en');

        $this->assertTrue($translator instanceof Translator);
    }

    public function testGetTranslatorAcceptsLocaleArgument() {
        $locale = $this->i18n->getLocale('en');

        $this->assertTrue($locale instanceof Locale);

        $translator = $this->i18n->getTranslator($locale);

        $this->assertTrue($translator instanceof Translator);
    }

    /**
     * @dataProvider providerGetTranslatorThrowsExceptionWhenArgumentIsNotALocaleOrString
     * @expectedException ride\library\i18n\exception\I18nException
     */
    public function testGetTranslatorThrowsExceptionWhenArgumentIsNotALocaleObjectOrString($argument) {
        $this->i18n->getTranslator($argument);
    }

    public function providerGetTranslatorThrowsExceptionWhenArgumentIsNotALocaleOrString() {
        return array(
            array(1),
            array(1.1),
            array(array('whatever')),
        );
    }
}