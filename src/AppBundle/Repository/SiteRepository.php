<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SiteRepository extends EntityRepository
{
    public function getSiteByLocale($alias)
    {
        $qb = $this->createQueryBuilder('w')
            ->addSelect('wm')
            ->join('w.language', 'wl')
            ->join('w.metadata', 'wm')
            ->where('UPPER(wl.alias) = UPPER(:alias)')
            ->setParameter('alias', $alias);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
