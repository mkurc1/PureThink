<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class WebsiteRepository extends EntityRepository
{
    public function getWebsiteByLocale($alias)
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
