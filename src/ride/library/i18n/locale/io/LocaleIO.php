<?php

namespace ride\library\i18n\locale\io;

/**
 * Interface to retrieve locales
 */
interface LocaleIO {

    /**
     * Gets all available locales
     * @return array all Locale objects
     */
    public function getLocales();

}