<?php

namespace ride\library\i18n\locale;

use ride\library\i18n\exception\I18nException;

/**
 * Generic implementation of the Locale interface
 */
class GenericLocale implements Locale {

    /**
     * Code of the locale
     * @var string
     */
    protected $code;

    /**
     * Native name of the locale
     * @var string
     */
    protected $name;

    /**
     * Extra properties of this locale
     * @var string
     */
    protected $properties;

    /**
     * Constructs a new locale
     * @param string $code Code of the locale
     * @param string $name Native name of the locale
     * @param array $properties Extra properties of the locale
     * @return null
     */
    public function __construct($code, $name, array $properties = array()) {
        if (!is_string($code) || $code == '') {
            throw new I18nException('Could not create locale: provided code is empty or invalid');
        }

        if (!is_string($name) || $name == '') {
            throw new I18nException('Could not create locale: provided native name is empty or invalid');
        }

        $this->code = $code;
        $this->name = $name;
        $this->properties = $properties;
    }

    /**
     * Gets a string representation of the locale
     * @return string
     */
    public function __toString() {
        return $this->code;
    }

    /**
     * Gets the code of this locale
     * @return string
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Gets the native name of this locale
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Gets a property of the locale
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getProperty($key, $default = null) {
        if (!isset($this->properties[$key])) {
            return $default;
        }

        return $this->properties[$key];
    }

}
