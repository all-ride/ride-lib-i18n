<?php

namespace ride\library\i18n\locale\negotiator;

use ride\library\i18n\locale\LocaleManager;

/**
 * Locale negotiator is an interface to detect the locale for the current client
 */
interface Negotiator {

    /**
     * Determines which locale to use
     *
     * @param \ride\library\i18n\locale\LocaleManager $manager Instance of the
     * locale manager
     * @return null|\ride\library\i18n\locale\Locale Instance of the locale if
     * detected, false otherwise
     */
    public function getLocale(LocaleManager $manager);

}
