<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getActiveMenu($typeSlug, $locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('t, art, at, artt')
            ->join('a.type', 't')
            ->leftJoin('a.article', 'art')
            ->join('a.translations', 'at', 'WITH', 'at.locale = :locale')
            ->join('art.translations', 'artt', 'WITH', 'artt.locale = :locale')
            ->where('a.published = true')
            ->andWhere('art.published = true')
            ->andWhere('t.slug = :typeSlug')
            ->andWhere('a.menu IS NULL')
            ->orderBy('a.position')
            ->setParameter('typeSlug', $typeSlug)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}
