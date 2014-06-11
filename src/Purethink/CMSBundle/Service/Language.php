<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Purethink\CMSBundle\Entity\Language as LanguageEntity;
use Doctrine\Common\Collections\ArrayCollection;

class Language
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return ArrayCollection
     * @throws noResultException
     */
    public function getPublicLanguages()
    {
        /** @var ArrayCollection $languages */
        $languages = $this->entityManager
            ->getRepository('PurethinkCMSBundle:Language')
            ->getPublicLanguages();

        if (null == $languages) {
            throw new NoResultException();
        }

        return $languages;
    }

    /**
     * @return array
     * @throws NoResultException
     */
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

    /**
     * @param string $locale
     * @return bool
     */
    public function hasAvailableLocales($locale)
    {
        return (bool)(in_array($locale, $this->getAvailableLocales()));
    }
}