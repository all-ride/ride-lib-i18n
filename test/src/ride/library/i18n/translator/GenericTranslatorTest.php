<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\GenericLocale;
use ride\library\i18n\translator\io\TranslationIOMock;

use \PHPUnit_Framework_TestCase;

class GenericTranslatorTest extends PHPUnit_Framework_TestCase {

    public function setUp() {
        $this->englishLocale = new GenericLocale('en', 'English');
        $this->dutchLocale = new GenericLocale('nl', 'Nederlands');
        $this->frenchLocale = new GenericLocale('fr', 'français');

        $this->io = new TranslationIOMock();
        $this->translator = new GenericTranslator($this->englishLocale, $this->io);
    }

    public function testConstruct() {
        $this->assertEquals($this->englishLocale->getCode(), $this->translator->getLocale());
    }

    public function testGetTranslation() {
        $expected = array(
            'apple.0' => '%n% apple',
            'apple.1' => '%n% apples',
            'label' => 'A label',
            'label.vars' => 'A label',
            'label.var' => 'This is a %0%',
        );

        $this->assertEquals('This is a %0%', $this->translator->getTranslation('label.var'));
        $this->assertEquals($expected, $this->translator->getTranslations());
    }

    public function testSetTranslation() {
        $this->assertNull($this->io->translation);

        $this->translator->setTranslation('my key', 'my translation');

        $expected = array(
            'locale' => 'en',
            'key' => 'my key',
            'translation' => 'my translation',
        );

        $this->assertEquals($expected, $this->io->translation);
    }

    /**
     * @dataProvider providerTranslate
     */
    public function testTranslate($expected, $key, $vars = null, $default = null) {
        $result = $this->translator->translate($key, $vars, $default);

        $this->assertEquals($expected, $result);
    }

    public function providerTranslate() {
        return array(
            array('This is a label with name Label1', 'label.vars', array('object' => 'label', 'name' => 'Label1')),
            array('This is a translation', 'label.var', array('translation')),
            array('[untranslated]', 'untranslated'),
            array('Default translation test', 'untranslated', array('translation'), 'Default %0% test'),
        );
    }

    /**
     * @dataProvider providerTranslatePluralUsesPluralScriptFromLocale
     */
    public function testTranslatePluralUsesPluralScriptFromLocale(Translator $translator, $n, $expected) {
        $result = $translator->translatePlural($n, 'apple');

        $this->assertEquals($expected, $result);
    }

    public function providerTranslatePluralUsesPluralScriptFromLocale() {
        $englishLocale = new GenericLocale('en', 'English', array('translator.script.plural' => '$n != 1'));
        $dutchLocale = new GenericLocale('nl', 'Nederlands', array('translator.script.plural' => '$n != 1'));
        $frenchLocale = new GenericLocale('fr', 'français', array('translator.script.plural' => '$n > 1'));
        $russianLocale = new GenericLocale('ru', 'русский', array('translator.script.plural' => '($n % 10 == 1 && $n % 100 != 11) ? 0 : ($n % 10 >=2 && $n % 10 <=4 && ($n % 100 < 10 || $n % 100 >= 20) ? 1 : 2)'));

        $io = new TranslationIOMock();

        return array(
            array(new GenericTranslator($englishLocale, $io), 0, '0 apples'),
            array(new GenericTranslator($englishLocale, $io), 1, '1 apple'),
            array(new GenericTranslator($englishLocale, $io), 2, '2 apples'),
            array(new GenericTranslator($englishLocale, $io), 3, '3 apples'),

            array(new GenericTranslator($dutchLocale, $io), 0, '0 appels'),
            array(new GenericTranslator($dutchLocale, $io), 1, '1 appel'),
            array(new GenericTranslator($dutchLocale, $io), 2, '2 appels'),
            array(new GenericTranslator($dutchLocale, $io), 3, '3 appels'),

            array(new GenericTranslator($frenchLocale, $io), 0, '0 pomme'),
            array(new GenericTranslator($frenchLocale, $io), 1, '1 pomme'),
            array(new GenericTranslator($frenchLocale, $io), 2, '2 pommes'),
            array(new GenericTranslator($frenchLocale, $io), 3, '3 pommes'),

            array(new GenericTranslator($russianLocale, $io), 0, '0 яблок'),
            array(new GenericTranslator($russianLocale, $io), 1, '1 яблоко'),
            array(new GenericTranslator($russianLocale, $io), 2, '2 яблока'),
            array(new GenericTranslator($russianLocale, $io), 3, '3 яблока'),
            array(new GenericTranslator($russianLocale, $io), 4, '4 яблока'),
            array(new GenericTranslator($russianLocale, $io), 5, '5 яблок'),
            array(new GenericTranslator($russianLocale, $io), 6, '6 яблок'),
            array(new GenericTranslator($russianLocale, $io), 7, '7 яблок'),
            array(new GenericTranslator($russianLocale, $io), 8, '8 яблок'),
            array(new GenericTranslator($russianLocale, $io), 9, '9 яблок'),
            array(new GenericTranslator($russianLocale, $io), 10, '10 яблок'),
            array(new GenericTranslator($russianLocale, $io), 11, '11 яблок'),
            array(new GenericTranslator($russianLocale, $io), 12, '12 яблок'),
            array(new GenericTranslator($russianLocale, $io), 13, '13 яблок'),
            array(new GenericTranslator($russianLocale, $io), 14, '14 яблок'),
            array(new GenericTranslator($russianLocale, $io), 15, '15 яблок'),
            array(new GenericTranslator($russianLocale, $io), 16, '16 яблок'),
            array(new GenericTranslator($russianLocale, $io), 17, '17 яблок'),
            array(new GenericTranslator($russianLocale, $io), 18, '18 яблок'),
            array(new GenericTranslator($russianLocale, $io), 19, '19 яблок'),
            array(new GenericTranslator($russianLocale, $io), 20, '20 яблок'),
            array(new GenericTranslator($russianLocale, $io), 21, '21 яблоко'),
            array(new GenericTranslator($russianLocale, $io), 22, '22 яблока'),
            array(new GenericTranslator($russianLocale, $io), 23, '23 яблока'),
            array(new GenericTranslator($russianLocale, $io), 24, '24 яблока'),
            array(new GenericTranslator($russianLocale, $io), 25, '25 яблок'),
            array(new GenericTranslator($russianLocale, $io), 26, '26 яблок'),
            array(new GenericTranslator($russianLocale, $io), 27, '27 яблок'),
            array(new GenericTranslator($russianLocale, $io), 28, '28 яблок'),
            array(new GenericTranslator($russianLocale, $io), 29, '29 яблок'),
        );
    }

}