<?php

namespace pallo\library\i18n\translator\io;

class TranslationIOMock implements TranslationIO {

    public $translation;

    public function getTranslations($localeCode) {

        switch($localeCode) {
            case 'en':
                return array(
                    'apple.0' => $this->getTranslation($localeCode, 'apple.0'),
                    'apple.1' => $this->getTranslation($localeCode, 'apple.1'),
                    'label'   => $this->getTranslation($localeCode, 'label'),
                    'label.vars'   => $this->getTranslation($localeCode, 'label'),
                    'label.var'   => $this->getTranslation($localeCode, 'label.var'),
                );
            case 'nl':
                return array(
                    'apple.0' => $this->getTranslation($localeCode, 'apple.0'),
                    'apple.1' => $this->getTranslation($localeCode, 'apple.1'),
                );
            case 'fr':
                return array(
                    'apple.0' => $this->getTranslation($localeCode, 'apple.0'),
                    'apple.1' => $this->getTranslation($localeCode, 'apple.1'),
                );
            case 'ru':
                return array(
                    'apple.0' => $this->getTranslation($localeCode, 'apple.0'),
                    'apple.1' => $this->getTranslation($localeCode, 'apple.1'),
                    'apple.2' => $this->getTranslation($localeCode, 'apple.2'),
                );
            default:
                return array();
        }
    }

    public function getTranslation($localeCode, $key) {

        switch($localeCode) {
            case 'en':
                switch($key) {
                    case 'apple.0':     return '%n% apple';
                    case 'apple.1':     return '%n% apples';
                    case 'label':       return 'A label';
                    case 'label.vars':  return 'This is a %object% with name %name%';
                    case 'label.var':   return 'This is a %0%';
                }
                break;
            case 'nl':
                switch($key) {
                    case 'apple.0': return '%n% appel';
                    case 'apple.1': return '%n% appels';
                }

            case 'fr':
                switch($key) {
                    case 'apple.0': return '%n% pomme';
                    case 'apple.1': return '%n% pommes';
                }

            case 'ru':
                switch($key) {
                    case 'apple.0': return '%n% яблоко';
                    case 'apple.1': return '%n% яблока';
                    case 'apple.2': return '%n% яблок';
                }
            default:
                return null;
        }
    }

    public function setTranslation($localeCode, $key, $translation = null) {
        $this->translation = array(
            'locale' => $localeCode,
            'key' => $key,
            'translation' => $translation,
        );
    }

}