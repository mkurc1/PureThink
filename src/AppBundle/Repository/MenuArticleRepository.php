<?php

namespace AppBundle\Repository;

class MenuArticleRepository extends MenuRepository
{
    public function getActiveMenus($typeSlug, $locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('art, at, artt')
            ->join('a.type', 't')
            ->join('a.article', 'art')
            ->join('a.translations', 'at', 'WITH', 'at.locale = :locale')
            ->join('art.translations', 'artt', 'WITH', 'artt.locale = :locale')
            ->where('a.published = true')
            ->andWhere('art.published = true')
            ->andWhere('t.slug = :typeSlug')
            ->setParameter('typeSlug', $typeSlug)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}