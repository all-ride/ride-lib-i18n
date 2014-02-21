<?php

namespace ride\library\i18n\locale;

use ride\library\i18n\exception\LocaleNotFoundException;
use ride\library\i18n\exception\I18nException;
use ride\library\i18n\locale\negotiator\Negotiator;
use ride\library\i18n\locale\io\LocaleIO;

/**
 * Manager of the locales
 */
class GenericLocaleManager implements LocaleManager {

    /**
     * Available locales
     * @var array
     */
    protected $locales;

    /**
     * Code of the current locale
     * @var string
     */
    protected $locale;

    /**
     * Locale input/ouput implementation
     * @var ride\library\i18n\locale\io\LocaleIO
     */
    protected $io;

    /**
     * Negotiator to determine the current locale
     * @var ride\library\i18n\locale\negotiator\Negotiator
     */
    protected $negotiator;

    /**
     * Constructs a new generic locale manager
     * @param ride\library\i18n\locale\io\LocaleIO $io Locale input/output
     * implementation
     * @param ride\library\i18n\locale\negotiator\Negotiator $negotiator
     * Negotiator to determine the current locale
     * @return null
     */
    public function __construct(LocaleIO $io, Negotiator $negotiator = null) {
        $this->io = $io;
        $this->negotiator = $negotiator;
    }

    /**
     * Checks if the provided locale is available
     * @param string $code Code of the locale
     * @return boolean
     * @throws ride\library\i18n\exception\I18nException when an invalid code
     * is provided
     */
    public function hasLocale($code) {
        if (!is_string($code) || $code === '') {
            throw new I18nException('Could not check if the locale is available: provided code is empty or invalid');
        }

        $this->initializeLocales();

        return isset($this->locales[$code]);
    }

    /**
     * Gets all locales
     * @return array Array with the locale code as key and the Locale as value
     */
    public function getLocales() {
        $this->initializeLocales();

        return $this->locales;
    }

    /**
     * Gets a locale
     * @param string $code if not provided, the current locale will be returned
     * @return ride\library\i18n\locale\Locale
     * @throws ride\library\i18n\exception\I18nException when an invalid code
     * is provided
     * @throws ride\library\i18n\exception\LocaleNotFoundException when the
     * locale is not available
     */
    public function getLocale($code = null) {
        $this->initializeLocales();

        if ($code === null) {
            if (!isset($this->locale)) {
                $this->initializeCurrentLocale();
            }

            $code = $this->locale;
        } elseif (!is_string($code) || $code === '') {
            throw new I18nException('Could not get locale: provided code is empty or invalid');
        }

        if (!isset($this->locales[$code])) {
            throw new LocaleNotFoundException($code);
        }

        return $this->locales[$code];
    }

    /**
     * Gets the default locale.
     * @return ride\library\i18n\locale\Locale the default locale
     * @throws ride\library\i18n\exception\I18nException when there are no
     * locales available
     */
    public function getDefaultLocale() {
        $locales = $this->getLocales();
        if (!$locales) {
            throw new I18nException('Could not get the default locale: no locales defined');
        }

        return array_shift($locales);
    }

    /**
     * Sets the current locale
     * @param string|ride\library\i18n\locale\Locale $locale
     * @return null
     * @throws ride\library\i18n\exception\I18nException when an invalid code
     * is provided
     * @throws ride\library\i18n\exception\LocaleNotFoundException when the
     * locale is not available
     */
    public function setCurrentLocale($locale) {
        if (!$locale instanceof Locale) {
            $locale = $this->getLocale($locale);
        }

        $code = $locale->getProperty('full', $locale->getCode());

        setlocale(LC_COLLATE, $code);
        setlocale(LC_MONETARY, $code);
        setlocale(LC_TIME, $code);

        $this->locale = $locale->getCode();
    }

    /**
     * Sets the order of the locales
     * @param string|array $order A comma separated string or an array of
     * locale codes
     * @return null
     */
    public function setOrder($order = null) {
        if (is_string($order)) {
            $order = explode(',', $order);
        } elseif (!is_array($order) && $order !== null) {
            throw new I18nException('Could not order the locales: invalid order provided');
        }

        $this->getLocales();

        uasort($this->locales, function(Locale $a, Locale $b) use ($order) {
            $aIndex = array_search($a->getCode(), $order);
            $bIndex = array_search($b->getCode(), $order);

            if ($aIndex === $bIndex) {
                return 0;
            } else if ($aIndex === false) {
                return 1;
            } else if ($bIndex === false) {
                return -1;
            } else {
                return ($aIndex < $bIndex) ? -1 : 1;
            }
        });
    }

    /**
     * Initializes the current locale
     * @return null
     */
    protected function initializeCurrentLocale() {
        $locale = null;

        if ($this->negotiator) {
            $locale = $this->negotiator->getLocale($this);
        }

        if (!$locale) {
            $locale = $this->getDefaultLocale();
        }

        $this->setCurrentLocale($locale);
    }

    /**
     * Initializes the available locales
     * @return null
     */
    protected function initializeLocales() {
        if (isset($this->locales)) {
            return;
        }

        $this->locales = $this->io->getLocales();
    }

}