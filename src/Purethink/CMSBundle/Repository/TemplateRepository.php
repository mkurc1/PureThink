<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;


class TemplateRepository extends EntityRepository
{
    public function getEnabledTemplate()
    {
        $qb = $this->createQueryBuilder('t')
            ->addSelect('tsc, tst')
            ->leftJoin('t.scripts', 'tsc')
            ->leftJoin('t.styles', 'tst')
            ->where('t.enabled = true');

        return $qb->getQuery()->getOneOrNullResult();
    }
}
