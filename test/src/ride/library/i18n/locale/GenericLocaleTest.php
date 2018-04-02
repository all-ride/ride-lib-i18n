<?php

namespace ride\library\i18n\locale;

use PHPUnit\Framework\TestCase;

class GenericLocaleTest extends TestCase {

    public function testConstruct() {
        $code = "code";
        $name = "name";
        $properties = array('key' => 'value');
        $locale = new GenericLocale($code, $name, $properties);

        $this->assertEquals($code, $locale->getCode());
        $this->assertEquals($name, $locale->getName());
        $this->assertEquals('value', $locale->getProperty('key'));
        $this->assertEquals('default', $locale->getProperty('unset', 'default'));
        $this->assertNull($locale->getProperty('unset'));
    }

    public function testToString() {
        $code = "code";
        $name = "name";
        $properties = array('key' => 'value');
        $locale = new GenericLocale($code, $name, $properties);

        $this->assertSame("code", (string) $locale);
    }

    public function testGetProperties() {
        $code = "code";
        $name = "name";
        $properties = array('key' => 'value');
        $locale = new GenericLocale($code, $name, $properties);

        $this->assertSame(array('key' => 'value'), $locale->getProperties());
    }

    /**
     * @dataProvider providerConstructThrowsExceptionWhenInvalidValuePassed
     * @expectedException ride\library\i18n\exception\I18nException
     */
    public function testConstructThrowsExceptionWhenInvalidValuePassed($code, $name) {
        new GenericLocale($code, $name);
    }

    public function providerConstructThrowsExceptionWhenInvalidValuePassed() {
        return array(
            array('code', ''),
            array('', 'name'),
        );
    }

}