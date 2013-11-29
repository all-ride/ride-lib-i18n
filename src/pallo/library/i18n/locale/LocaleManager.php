<?php

namespace pallo\library\i18n\locale;

/**
 * Interface for a locale manager
 */
interface LocaleManager {

    /**
     * Checks if the provided locale is available
     * @param string $code Code of the locale
     * @return boolean
     * @throws pallo\library\i18n\exception\I18nException when an invalid code
     * is provided
     */
    public function hasLocale($code);

    /**
     * Gets all locales
     * @return array Array with the locale code as key and the Locale as value
     */
    public function getLocales();

    /**
     * Gets a locale
     * @param string $code if not provided, the current locale will be returned
     * @return pallo\library\i18n\locale\Locale
     * @throws pallo\library\i18n\exception\I18nException when an invalid code
     * is provided
     * @throws pallo\library\i18n\exception\LocaleNotFoundException when the
     * locale is not available
     */
    public function getLocale($code = null);

    /**
     * Gets the default locale.
     * @return pallo\library\i18n\locale\Locale the default locale
     * @throws pallo\library\i18n\exception\I18nException when there are no
     * locales available
     */
    public function getDefaultLocale();

    /**
     * Sets the current locale
     * @param string|pallo\library\i18n\locale\Locale $locale
     * @return null
     * @throws pallo\library\i18n\exception\I18nException when an invalid code
     * is provided
     * @throws pallo\library\i18n\exception\LocaleNotFoundException when the
     * locale is not available
     */
    public function setCurrentLocale($locale);

}