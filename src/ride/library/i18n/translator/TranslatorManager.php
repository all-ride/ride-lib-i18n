<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\Locale;

/**
 * Manager of the translators
 */
interface TranslatorManager {

    /**
     * Gets the translator for the provided locale
     * @param ride\library\i18n\locale\Locale $locale
     * @return ride\library\i18n\translator\Translator
     */
    public function getTranslator(Locale $locale);

}