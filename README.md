# Ride: I18n Library

Internationalization library of the PHP Ride framework.

## Locale

A _Locale_ is the interface for a locale definition.
This is a simple representation with a name and code with extra properties.

These locales are contained in a _LocaleManager_ instance.
This manager controls the current and default locale.

A _LocaleIO_ feeds the _LocaleManager_ with locales.
The locales should be sorted in the order of importance for the system.
The first locale is considered the default locale.

To detect the locale of the client, you can implement the _Negotiator_ interface.

## Translator

A _Translator_ is the interface to translate keys into a localized string.
The interface supports a difference between singular and plural forms of a translation key.

The translators are managed by a _TranslatorManager_.
_Translator_ instances can be requested with the _Locale_ instance.

## I18n

The I18n class glues the different parts together into an easy facade. 

## Code Sample

Check this code sample to see the possibilities of this library:

```php
<?php

use ride\library\i18n\locale\io\LocaleIO;
use ride\library\i18n\locale\negotiator\DefaultNegotiator;
use ride\library\i18n\locale\GenericLocaleManager;
use ride\library\i18n\translator\io\AbstractTranslationIO;
use ride\library\i18n\translator\GenericTranslatorManager;
use ride\library\i18n\I18n;

/**
 * Dummy implementation of a locale data source
 */
class FooLocaleIO implements LocaleIO {
    
    public function getLocales() {
        return array(
            new GenericLocale('en', 'English', array(
                'full' => 'en_GB.utf8',
                'translator.script.plural': '$n != 1',
            )),
            new GenericLocale('nl', 'Nederlands', array(
                'full' => 'nl_BE.utf8',
                'translator.script.plural': '$n != 1',
            )),
        );
    }
    
}

/**
 * Dummy implementation of a translation data source
 */
class FooTranslationIO extends AbstractTranslationIO {
    
    protected function readTranslations($localeCode) {
        switch ($localeCode) {
            case 'en':
                return array(
                    'label.name' => 'Name',
                    'label.email' => 'E-mail address',
                    'label.hello' => 'Hello %name%!',
                    'label.item.0' => 'We got 1 item.',
                    'label.item.1' => 'We got %n% items.',
                );
            default:
                return array();
        } 
    }
}

// first we need to initialize our I18n instance
$localeIO = new FooLocaleIO(); 
$negotiator = new DefaultNegotiator();
$translationIO = new FooTranslationIO();

$localeManager = new GenericLocaleManager($localeIO, $negotiator);
$translatorManager = new GenericTranslatorManager($translationIO);

$i18n = new I18n($localeManager, $translatorManager);

// play with the locales
$en = $i18n->getLocale(); // default language is English since it's provided first by the locale IO
$nl = $i18n->getLocale('nl');

$i18n->setCurrentLocale($nl);
$i18n->setCurrentLocale('nl');

$nl = $i18n->getLocale();

$i18n->hasLocale('fr'); // false

// fetch some lists of the available locales
$locales = $i18n->getLocales();
$localeList = $i18n->getLocaleList(); // array('en' => 'English', 'nl' => 'Nederlands')
$localeCodeList = $i18n->getLocaleCodeList(); // array('en' => 'en', 'nl' => 'nl')

// play with translations
$translator = $i18n->getTranslator($en);

// translate some keys
$value = $translator->translate('label.name'); // Name
$value = $translator->translate('label.hello', array('name' => 'world'); // Hello world!
$value = $translator->translate('label.unexistant'); // [label.unexistant]
$value = $translator->translatePlural(1, 'label.item'); // We got 1 item. 
$value = $translator->translatePlural(3, 'label.item'); // We got 3 items. 

// translation management
$translations = $translator->getTranslations(); // array('label.name' => 'Name', 'label.email' => 'E-mail address', ...)
$translation = $translator->getTranslation('label.hello'); // Hello %name%!
$translator->setTranslation('label.foo', 'bar');
