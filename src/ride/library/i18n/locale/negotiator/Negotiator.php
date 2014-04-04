<?php

namespace ride\library\i18n\locale\negotiator;

use ride\library\i18n\locale\LocaleManager;

/**
 * Locale negotiator
 */
interface Negotiator {

    /**
     * Determines which locale to use
     *
     * @param \ride\library\i18n\locale\LocaleManager $manager Instance of the
     * locale manager
     * @return null| \ride\library\i18n\locale\Locale the locale
     */
    public function getLocale(LocaleManager $manager);

}