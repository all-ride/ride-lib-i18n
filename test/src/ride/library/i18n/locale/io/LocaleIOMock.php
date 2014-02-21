<?php

namespace ride\library\i18n\locale\io;

use ride\library\i18n\locale\GenericLocale;

class LocaleIOMock implements LocaleIO {

    public function getLocales() {
        return array(
            'nl' => new GenericLocale('nl', 'Nederlands'),
            'en' => new GenericLocale('en', 'English'),
            'en_GB' => new GenericLocale('en_GB', 'British English'),
            'fr' => new GenericLocale('fr', 'français'),
        );
    }

}