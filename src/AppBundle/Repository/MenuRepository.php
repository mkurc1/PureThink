<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getActiveMenu($typeSlug, $locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('t, art')
            ->join('a.language', 'l')
            ->join('a.type', 't')
            ->leftJoin('a.article', 'art')
            ->join('art.translations', 'artt', 'WITH', 'artt.locale = :locale')
            ->where('a.published = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
//            ->andWhere('artt.locale = :locale')
            ->andWhere('art.published = true')
            ->andWhere('t.slug = :typeSlug')
            ->andWhere('a.menu IS NULL')
            ->orderBy('a.position')
            ->setParameter('typeSlug', $typeSlug)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}
