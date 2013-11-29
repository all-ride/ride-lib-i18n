<?php

namespace pallo\library\i18n\translator;

use pallo\library\i18n\locale\Locale;

/**
 * Manager of the translators
 */
interface TranslatorManager {

    /**
     * Gets the translator for the provided locale
     * @param pallo\library\i18n\locale\Locale $locale
     * @return pallo\library\i18n\translator\Translator
     */
    public function getTranslator(Locale $locale);

}