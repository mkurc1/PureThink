<?php

namespace AppBundle\Repository;

class MenuUrlRepository extends MenuRepository
{
    public function getActiveMenus($typeSlug, $locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.type', 't')
            ->join('a.translations', 'at', 'WITH', 'at.locale = :locale')
            ->where('a.published = true')
            ->andWhere('t.slug = :typeSlug')
            ->groupBy('a.id')
            ->setParameter('typeSlug', $typeSlug)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}