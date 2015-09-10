<?php

namespace ride\library\i18n;

use ride\library\i18n\locale\Locale;
use ride\library\i18n\locale\LocaleManager;
use ride\library\i18n\translator\TranslatorManager;

/**
 * Facade to the localization and translation subsystems
 */
class I18n {

    /**
     * Source for the log messages
     * @var string
     */
    const LOG_SOURCE = 'i18n';

    /**
     * The manager of the locales
     * @var \ride\library\i18n\locale\LocaleManager
     */
    protected $localeManager;

    /**
     * The manager of the translators
     * @var \ride\library\i18n\translator\TranslatorManager
     */
    protected $translatorManager;

    /**
     * Constructs a new internationalization facade
     * @param \ride\library\i18n\locale\LocaleManager $localeManager Manager
     * of the locales
     * @param \ride\library\i18n\translator\TranslatorManager
     * $translatorManager Manager of the translators
     * @return null
     */
    public function __construct(LocaleManager $localeManager, TranslatorManager $translatorManager) {
        $this->localeManager = $localeManager;
        $this->translatorManager = $translatorManager;
    }

    /**
     * Set the translator manager
     * @param \ride\library\i18n\translator\TranslatorManager
     * $translatorManager Manager of the translators
     * @return null
     */
    public function setTranslatorManager(TranslatorManager $translatorManager) {
        $this->translatorManager = $translatorManager;
    }

    /**
     * Sets the current locale
     * @param string|\ride\library\i18n\locale\Locale $locale Code or instance
     * of the locale
     * @return null
     */
    public function setCurrentLocale($locale) {
        $this->localeManager->setCurrentLocale($locale);
    }

    /**
     * Checks if the provided locale is available
     * @param string $code Code of the locale
     * @return boolean
     */
    public function hasLocale($code) {
        return $this->localeManager->hasLocale($code);
    }

    /**
     * Gets the locale.
     *
     * @param string $code the locale code, if not specified then the current locale is assumed
     * @return \ride\library\i18n\locale\Locale
     * @throws \ride\library\i18n\exception\LocaleNotFoundException if the
     * locale with the specified code could not be found
     * @throws \ride\library\i18n\exception\I18nException when $code is not
     * specified and no locales could be found
     */
    public function getLocale($code = null) {
        return $this->localeManager->getLocale($code);
    }

    /**
     * Gets all the available locales
     * @return array
     */
    public function getLocales() {
        return $this->localeManager->getLocales();
    }

    /**
     * Gets a list of the available locales
     * @return array Array with the locale code as key and the native name as
     * value
     */
    public function getLocaleList() {
        $locales = array();

        foreach ($this->getLocales() as $locale) {
            $locales[$locale->getCode()] = $locale->getName();
        }

        return $locales;
    }

    /**
     * Gets a list of the available locales
     * @return array Array with the locale code as key and as value
     */
    public function getLocaleCodeList() {
        $locales = array();

        foreach ($this->getLocales() as $locale) {
            $code = $locale->getCode();

            $locales[$code] = $code;
        }

        return $locales;
    }

    /**
     * Gets the translator for a locale
     * @param null|string|\ride\library\i18n\locale\Locale $locale locale code,
     * a Locale instance or if not specified the current locale is assumed
     * @return \ride\library\i18n\translator\Translator
     * @throws \ride\library\i18n\exception\I18nException when the provided
     * locale is not available or when no locale is provided and there are no
     * locales available
     */
    public function getTranslator($locale = null) {
        if ($locale === null || !$locale instanceof Locale) {
            $locale = $this->getLocale($locale);
        }

        return $this->translatorManager->getTranslator($locale);
    }

}
