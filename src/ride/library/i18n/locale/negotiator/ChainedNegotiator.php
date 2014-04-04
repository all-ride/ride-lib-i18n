<?php

namespace ride\library\i18n\locale\negotiator;

use ride\library\i18n\locale\LocaleManager;

/**
 * Chained locale negotiator
 */
class ChainedNegotiator implements Negotiator {

    /**
     * Negotiators to chain
     * @var array
     */
    protected $negotiators;

    /**
     * Constructs a new negotiatior chain
     * @return null
     */
    public function __construct() {
        $this->negotiators = array();
    }

    /**
     * Adds a negotiator to the chain, last added negotiator is the first to
     * be checked, the first added is last.
     * @param Negotiator $negotiator
     * @return null
     */
    public function addNegotiator(Negotiator $negotiator) {
        array_unshift($this->negotiators, $negotiator);
    }

    /**
     * Determines which locale to use.
     *
     * @param \ride\library\i18n\locale\LocaleManager $manager Instance of the
     * locale manager
     * @return null| \ride\library\i18n\locale\Locale the locale
     */
    public function getLocale(LocaleManager $manager) {
       foreach ($this->negotiators as $negotiator) {
           $locale = $negotiator->getLocale($manager);
           if ($locale) {
               return $locale;
           }
       }

       return null;
    }

}