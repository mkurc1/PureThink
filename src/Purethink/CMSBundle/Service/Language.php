<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Purethink\CMSBundle\Entity\Language as LanguageEntity;

class Language
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getPublicLanguages()
    {
        $languages = $this->entityManager
            ->getRepository('PurethinkCMSBundle:Language')
            ->getPublicLanguages();

        if (null == $languages) {
            throw new NoResultException();
        }

        return $languages;
    }

    public function getAvailableLocales()
    {
        $availableLocales = [];

        $languages = $this->getPublicLanguages();
        /** @var LanguageEntity $language */
        foreach ($languages as $language) {
            $availableLocales[] = strtolower($language->getAlias());
        }

        return $availableLocales;
    }

    public function hasAvailableLocales($locale)
    {
        return (bool)(in_array($locale, $this->getAvailableLocales()));
    }
}