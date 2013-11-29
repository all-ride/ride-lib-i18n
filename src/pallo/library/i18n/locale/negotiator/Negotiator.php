<?php

namespace pallo\library\i18n\locale\negotiator;

use pallo\library\i18n\locale\LocaleManager;

/**
 * Locale negotiator
 */
interface Negotiator {

    /**
     * Determines which locale to use
     *
     * @param pallo\library\i18n\locale\LocaleManager $manager Instance of the
     * locale manager
     * @return null|pallo\library\i18n\locale\Locale the locale
     */
    public function getLocale(LocaleManager $manager);

}