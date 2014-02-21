<?php

namespace ride\library\i18n\translator;

use ride\library\i18n\locale\Locale;
use ride\library\i18n\translator\io\TranslationIO;
use ride\library\i18n\exception\I18nException;

/**
 * Translator of keys into localized translations
 */
class GenericTranslator implements Translator {

    /**
     * Locale for which this translator translates
     * @var string
     */
    protected $locale;

    /**
     * Script for plural translations
     * @var string
     */
    protected $pluralScript;

    /**
     * Translation input/output implementation
     * @var ride\library\translation\io\TranslationIO
     */
    protected $io;

    /**
     * Constructs a new translator
     * @param ride\library\i18n\locale\Locale $locale
     * @param ride\library\i18n\translator\io\TranslationIO $io
     * @return null
     */
    public function __construct(Locale $locale, TranslationIO $io) {
        $this->locale = $locale->getCode();
        $this->pluralScript = $locale->getProperty('translator.script.plural');
        $this->io = $io;
    }

    /**
     * Gets the locale code of this translator
     * @return string
     */
    public function getLocale() {
        return $this->locale;
    }

    /**
     * Sets a translation to the data source
     * @param string $key Key of the translation
     * @param string $translation Translation string
     * @return null
     */
    public function setTranslation($key, $translation) {
        $this->io->setTranslation($this->locale, $key, $translation);
    }

    /**
     * Gets a translation from the data source
     * @param string $key Key of the translation
     * @return string Unprocessed translation
     */
    public function getTranslation($key) {
        return $this->io->getTranslation($this->locale, $key);
    }

    /**
     * Translates a key into a localized translation
     * @param string $key translation key
     * @param array $vars variables to be replaced in the translation
     * @param string $default default translation
     * @return string TKey translated into a localized translation
     */
    public function translate($key, array $vars = null, $default = null) {
        if ($default == null) {
            $default = '[' . $key . ']';
        }

        $translation = $this->io->getTranslation($this->locale, $key);

        if (!$translation) {
            $translation = $default;
        }

        if ($translation === null || $vars === null) {
            return $translation;
        }

        if ($vars) {
            foreach ($vars as $key => $value) {
                $translation = str_replace('%' . $key . '%', $value, $translation);
            }
        }

        return $translation;
    }

    /**
     * Translates a key into a localized translation which describes multiple items
     * @param integer $n Number of items which the translation is describing
     * @param string $key Translation key
     * @param array $vars Variables to be replaced in the translation
     * @param string $default Default translation
     * @return string Key translated into a localized translation
     */
    public function translatePlural($n, $key, array $vars = null, $default = null) {
        if (is_null($vars)) {
            $vars = array();
        }

        $vars['n'] = $n;

        if (!$this->pluralScript) {
            throw new I18nException('Could not translate plural key ' . $key . ': no plural script set to locale');
        }

        $keySuffix = (int) eval('return ' . $this->pluralScript . ';');
        $key .= '.' . $keySuffix;

        return $this->translate($key, $vars, $default);
    }

    /**
     * Gets all the translations
     * @return array Array with the translation key as array and the actual
     * translation as value
     */
    public function getTranslations() {
        return $this->io->getTranslations($this->locale);
    }

}