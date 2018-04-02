<?php

namespace ride\library\i18n\locale;

use ride\library\i18n\locale\io\LocaleIOMock;

use PHPUnit\Framework\TestCase;

class GenericLocaleManagerTest extends TestCase {

    public function setUp() {
        $this->manager = new GenericLocaleManager(new LocaleIOMock());
    }

    /**
     * @expectedException ride\library\i18n\exception\I18nException 
     */
    public function testSetOrderShouldThrowI18nException() {
        $this->manager->setOrder(1000);
    }

    /**
     * @dataProvider providerHasLocaleThrowsExceptionWhenInvalidLocaleProvided
     * @expectedException ride\library\i18n\exception\I18nException
     */
    public function testHasLocaleThrowsExceptionWhenInvalidLocaleProvided($locale) {
        $this->manager->hasLocale($locale);
    }

    public function providerHasLocaleThrowsExceptionWhenInvalidLocaleProvided() {
        return array(
        	array($this),
            array(array()),
        );
    }

    public function providerGetLocalesSortsLocales() {
        return array(
            array('nl', 'nl'),
            array('fr', 'fr'),
            array('en', 'en'),
            array('en,nl', 'en', 'nl'),
            array('en,fr', 'en', 'fr'),
            array('nl,en', 'nl', 'en'),
            array('nl,fr', 'nl', 'fr'),
            array('fr,en', 'fr', 'en'),
            array('fr,nl', 'fr', 'nl'),
            array('fr,nl,en', 'fr', 'nl', 'en', 'en_GB'),
            array('fr,en,nl', 'fr', 'en', 'nl', 'en_GB'),
            array('en,fr,nl', 'en', 'fr', 'nl', 'en_GB'),
            array('en,nl,fr', 'en', 'nl', 'fr', 'en_GB'),
            array('nl,fr,en', 'nl', 'fr', 'en', 'en_GB'),
            array('nl,en,fr', 'nl', 'en', 'fr', 'en_GB'),

        );
    }

    /**
     * @dataProvider providerGetLocalesSortsLocales
     */
    public function testSetOrderSortsLocales($order, $codeA, $codeB = null, $codeC = null, $codeD = null) {
        $this->manager->setOrder($order);

        $locales = $this->manager->getLocales();

        $this->assertEquals(4, count($locales));

        $i = 0;
        foreach ($locales as $key => $locale) {
            switch($i) {
                case 0:
                    $this->assertEquals($codeA, $key);
                    $this->assertEquals($codeA, $locale->getCode());
                    break;
                case 1:
                    if ($codeB) {
                        $this->assertEquals($codeB, $key);
                        $this->assertEquals($codeB, $locale->getCode());
                    }
                    break;
                case 2:
                    if ($codeC) {
                        $this->assertEquals($codeC, $key);
                        $this->assertEquals($codeC, $locale->getCode());
                    }
                    break;
                case 3:
                    if ($codeD) {
                        $this->assertEquals($codeD, $key);
                        $this->assertEquals($codeD, $locale->getCode());
                    }
                    break;
            }

            $i++;
        }
    }

    public function testSetCurrentLocale() {
        $locale = 'en';

        $this->assertNotEquals($locale, $this->manager->getLocale()->getCode());

        $this->manager->setCurrentLocale($locale);

        $this->assertEquals($locale, $this->manager->getLocale()->getCode());
    }

    public function testGetLocaleReturnsInstanceOfLocale() {
        $this->assertInstanceOf('ride\library\i18n\locale\Locale', $this->manager->getLocale('en'));
    }

    /**
     * @expectedException ride\library\i18n\exception\LocaleNotFoundException
     */
    public function testGetLocaleThrowsExceptionIfLocaleNotFound() {
        $this->manager->getLocale('foo');
    }

    /**
     * @dataProvider providerGetLocaleThrowsExceptionWhenInvalidArgumentProvided
     * @expectedException ride\library\i18n\exception\I18nException
     */
    public function testGetLocaleThrowsExceptionWhenInvalidArgumentProvided($arg) {
        $this->manager->getLocale($arg);
    }

    public function providerGetLocaleThrowsExceptionWhenInvalidArgumentProvided() {
        return array(
            array(1),
            array(1.1),
            array(array('whatever')),
            array($this),
        );
    }

}