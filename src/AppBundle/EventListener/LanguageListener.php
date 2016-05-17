<?php

namespace AppBundle\EventListener;

use AppBundle\Service\Language;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LanguageListener
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var Language
     */
    private $language;

    public function __construct(Language $language)
    {
        $this->language = $language;
    }

    public function setSession(Session $session)
    {
        $this->session = $session;
    }

    public function setLocale(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }


        $request = $event->getRequest();


        if ($locale = $request->attributes->get('_locale')) {
            if ($this->language->hasAvailableLocales($locale)) {
                $request->getSession()->set('_locale', $locale);
            }
        } else {
            $defaultLocale = $request->getPreferredLanguage($this->language->getAvailableLocales());
            $request->setLocale($request->getSession()->get('_locale', $defaultLocale));
        }
    }
}