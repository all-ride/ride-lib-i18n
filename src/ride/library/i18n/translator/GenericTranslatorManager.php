<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\Locale;
use ride\library\i18n\translator\io\TranslationIO;

/**
 * Manager of the translators
 */
class GenericTranslatorManager implements TranslatorManager {

    /**
     * Array with the loaded translators
     * @var array
     */
    protected $translators;

    /**
     * Constructs a new translation manager
     * @param ride\library\i18n\translator\io\TranslationIO $io
     * @return null
     */
    public function __construct(TranslationIO $io) {
        $this->io = $io;
        $this->translators = array();
    }

    /**
     * Gets the translator for the provided locale
     * @param ride\library\i18n\locale\Locale $locale
     * @return ride\library\i18n\translator\Translator
     */
    public function getTranslator(Locale $locale) {
        $localeCode = $locale->getCode();

        if (isset($this->translators[$localeCode])) {
            return $this->translators[$localeCode];
        }

        return $this->translators[$localeCode] = $this->createTranslator($locale);
    }

    /**
     * Creates an instance of a translator
     * @param ride\library\i18n\locale\Locale $locale
     * @return \ride\library\i18n\translator\GenericTranslator
     */
    protected function createTranslator(Locale $locale) {
        return new GenericTranslator($locale, $this->io);
    }

}