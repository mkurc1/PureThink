<?php

namespace Purethink\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getMenuForModule($module)
    {
        $qb = $this->createQueryBuilder('m')
            ->where('m.module = :module')
            ->orderBy('m.sequence')
            ->setParameter('module', $module);

        return $qb->getQuery()->getResult();
    }
}
