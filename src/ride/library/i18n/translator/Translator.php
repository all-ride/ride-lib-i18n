<?php

namespace ride\library\i18n\translator;

/**
 * Translator of keys into localized translations
 */
interface Translator {

    /**
     * Gets the locale code of this translator
     * @return string
     */
    public function getLocale();

    /**
     * Sets a translation to the data source
     * @param string $key Key of the translation
     * @param string $translation Translation string
     * @return null
     */
    public function setTranslation($key, $translation);

    /**
     * Gets a translation from the data source
     * @param string $key Key of the translation
     * @return string Unprocessed translation
     */
    public function getTranslation($key);

    /**
     * Translates a key into a localized translation
     * @param string $key Translation key
     * @param array $vars Variables to be replaced in the translation
     * @param string $default Default translation
     * @return string Key translated into a localized translation
     */
    public function translate($key, array $vars = null, $default = null);

    /**
     * Translates a key into a localized translation which describes multiple items
     * @param integer $n Number of items which the translation is describing
     * @param string $key Translation key
     * @param array $vars Variables to be replaced in the translation
     * @param string $default Default translation
     * @return string Key translated into a localized translation
     */
    public function translatePlural($n, $key, array $vars = null, $default = null);

    /**
     * Gets all the translations
     * @return array Array with the translation key as array and the actual
     * translation as value
     */
    public function getTranslations();

}