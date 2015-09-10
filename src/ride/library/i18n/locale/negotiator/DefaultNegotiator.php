<?php

namespace ride\library\i18n\locale\negotiator;

use ride\library\i18n\locale\LocaleManager;

/**
 * Locale negotiator which always returns the default locale
 */
class DefaultNegotiator implements Negotiator {

    /**
     * Gets the default locale
     * @param \ride\library\i18n\locale\LocaleManager $manager Instance of the
     * locale manager
     * @return null|\ride\library\i18n\locale\Locale Default locale
     */
    public function getLocale(LocaleManager $manager) {
        return $manager->getDefaultLocale();
    }

}
