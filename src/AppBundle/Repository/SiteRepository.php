<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SiteRepository extends EntityRepository
{
    public function getSiteByLocale($locale)
    {
        $qb = $this->createQueryBuilder('s')
            ->addSelect('t')
            ->join('s.translations', 't')
            ->andWhere('t.locale = :locale')
            ->setMaxResults(1)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getSite()
    {
        $qb = $this->createQueryBuilder('s')
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
