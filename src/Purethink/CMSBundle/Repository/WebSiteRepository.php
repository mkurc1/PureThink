<?php

namespace Purethink\CMSBundle\Repository;

use Purethink\AdminBundle\Repository\FilterRepository;


class WebSiteRepository extends FilterRepository
{
    public function getWebSite($languageId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.language', 'l');

        $this->addLanguageIdFilterQB($qb, $languageId);

        $qb->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getWebsiteByLocale($locale)
    {
        $qb = $this->createQueryBuilder('w')
            ->addSelect('wm')
            ->join('w.language', 'wl')
            ->join('w.metadata', 'wm');

        $this->addLanguageAliasFilter($qb, $locale, 'wl');

        return $qb->getQuery()->getOneOrNullResult();
    }
}
