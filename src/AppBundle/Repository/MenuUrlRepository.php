<?php

namespace AppBundle\Repository;

class MenuUrlRepository extends MenuRepository
{
    public function getActiveMenuIds($typeSlug, $locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.id')
            ->join('a.type', 't')
            ->join('a.translations', 'at', 'WITH', 'at.locale = :locale')
            ->where('a.published = true')
            ->andWhere('t.slug = :typeSlug')
            ->groupBy('a.id')
            ->setParameter('typeSlug', $typeSlug)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getArrayResult();
    }
}