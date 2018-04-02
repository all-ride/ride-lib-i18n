<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\negotiator\DefaultNegotiator;

use ride\library\i18n\locale\GenericLocaleManager;

use ride\library\i18n\locale\io\LocaleIOMock;

use PHPUnit\Framework\TestCase;

class DefaultNegotiatorTest extends TestCase {

    public function testGetLocale() {
        $negotiator = new DefaultNegotiator();

        $this->assertInstanceOf('ride\library\i18n\locale\Locale', $negotiator->getLocale(new GenericLocaleManager(new LocaleIOMock())));
    }

}
