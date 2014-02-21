<?php

namespace ride\library\i18n\translator\io;

use ride\library\i18n\exception\I18nException;

/**
 * Abstract implementation of the TranslationIO
 */
abstract class AbstractTranslationIO implements TranslationIO {

    /**
     * Array holding the read translations
     * @var array
     */
    protected $translations = array();

    /**
     * Gets a translation for the provided locale code
     * @param string $localeCode code of the locale
     * @param string $key key of the translation
     * @return string|null astring when found, null otherwise
     */
    public function getTranslation($localeCode, $key) {
        if (!is_string($localeCode) || $localeCode == '') {
            throw new I18nException('Could not get the provided translation: provided locale code is empty or invalid');
        }

        if (!is_string($key) || $key == '') {
            throw new I18nException('Could not get the provided translation: provided key is empty or invalid');
        }

        if (!isset($this->translations[$localeCode])) {
            $this->translations[$localeCode] = $this->readTranslations($localeCode);
        }

        if (isset($this->translations[$localeCode][$key])) {
            return $this->translations[$localeCode][$key];
        }

        return null;
    }

    /**
     * Gets all the translations for the provided locale
     * @param string $localeCode The code of the locale
     * @return array Array with the translation key as key and the translation
     * as value
     * @throws ride\library\i18n\exception\I18nException when the locale code
     * is empty or invalid
     */
    public function getTranslations($localeCode) {
        if (!is_string($localeCode) || $localeCode == '') {
            throw new I18nException('Could not get the translations: provided locale code is empty');
        }

        if (isset($this->translations[$localeCode])) {
            return $this->translations[$localeCode];
        }

        $this->translations[$localeCode] = $this->readTranslations($localeCode);

        return $this->translations[$localeCode];
    }

    /**
     * Reads the translations from the data source
     * @param string $localeCode The code of the locale to read
     * @return array Array with the translation key as key and the translation
     * as value
     */
    abstract protected function readTranslations($localeCode);

    /**
     * Sets a translation for the provided locale
     * @param string $localeCode Code of the locale
     * @param string $key Key of the translation
     * @param string $translation
     * @return null
     * @throws ride\library\i18n\exception\I18nException when this
     * functionality is not supported
     */
    public function setTranslation($localeCode, $key, $translation = null) {
        throw new I18nException('Could not set the provided translation: not supported by this TranslationIO');
    }

}