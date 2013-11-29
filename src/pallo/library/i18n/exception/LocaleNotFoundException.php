<?php

namespace pallo\library\i18n\exception;

/**
 * Exception for when a requested locale is not found
 */
class LocaleNotFoundException extends I18nException {

    /**
     * Constructs a new locale not found exception
     * @param string $localeCode Code of the requested locale
     * @return null
     */
    public function __construct($localeCode) {
        parent::__construct('Locale ' . $localeCode . ' is not defined in this installation');
    }

}