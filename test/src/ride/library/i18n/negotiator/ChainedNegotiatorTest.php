<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\negotiator\ChainedNegotiator;

use ride\library\i18n\locale\GenericLocaleManager;

use ride\library\i18n\locale\io\LocaleIOMock;

use PHPUnit\Framework\TestCase;

class ChainedNegotiatorTest extends TestCase {

    public function testAddNegotiator() {
        $negotiator = new ChainedNegotiator();

        $this->assertNull($negotiator->addNegotiator($negotiator));
    }

    public function testGetLocaleShouldReturnNull() {
        $negotiator = new ChainedNegotiator();

        $this->assertNull($negotiator->getLocale(new GenericLocaleManager(new LocaleIOMock())));
    }

}
