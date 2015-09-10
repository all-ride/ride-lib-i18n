<?php

namespace ride\library\i18n\locale;

/**
 * Interface for a locale manager
 */
interface LocaleManager {

    /**
     * Checks if the provided locale is available
     * @param string $code Code of the locale
     * @return boolean
     * @throws \ride\library\i18n\exception\I18nException when an invalid code
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
     * @param string $code Code of the locale. If not provided, the current
     * locale will be returned
     * @return \ride\library\i18n\locale\Locale Instance of the requested locale
     * @throws \ride\library\i18n\exception\I18nException when an invalid code
     * is provided
     * @throws \ride\library\i18n\exception\LocaleNotFoundException when the
     * locale is not available
     */
    public function getLocale($code = null);

    /**
     * Gets the default locale.
     * @return \ride\library\i18n\locale\Locale Default locale
     * @throws \ride\library\i18n\exception\I18nException when there are no
     * locales available
     */
    public function getDefaultLocale();

    /**
     * Sets the current locale
     * @param string|\ride\library\i18n\locale\Locale $locale Locale to set as
     * current locale
     * @return null
     * @throws \ride\library\i18n\exception\I18nException when an invalid code
     * is provided
     * @throws \ride\library\i18n\exception\LocaleNotFoundException when the
     * locale is not available
     */
    public function setCurrentLocale($locale);

}
