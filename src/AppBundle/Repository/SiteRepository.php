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
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
