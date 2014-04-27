<?php

namespace ride\library\i18n\locale;

/**
 * Interface for a locale
 */
interface Locale {

    /**
     * Gets the code of this locale
     * @return string
     */
    public function getCode();

    /**
     * Gets the native name of this locale
     * @return string
     */
    public function getName();

    /**
     * Gets a property of the locale
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getProperty($key, $default = null);

    /**
     * Gets all the properties of the locale
     * @return array
     */
    public function getProperties();

}
