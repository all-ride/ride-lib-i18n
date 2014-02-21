<?php

namespace ride\library\i18n\translator\io;

/**
 * Interface for the translation input/output
 */
interface TranslationIO {

    /**
     * Sets a translation for the provided locale
     * @param string $localeCode Code of the locale
     * @param string $key Key of the translation
     * @param string|null $translation
     * @return null
     */
    public function setTranslation($localeCode, $key, $translation = null);

    /**
     * Gets a translation for the provided locale code
     * @param string $localeCode Code of the locale
     * @param string $key Key of the translation
     * @return string|null A string when found, null otherwise
     */
    public function getTranslation($localeCode, $key);

    /**
     * Gets all the translations for the provided locale
     * @param string $localeCode Code of the locale
     * @return array An associative array with translation key - value pairs
     */
    public function getTranslations($localeCode);

}