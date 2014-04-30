<?php

namespace Purethink\CMSBundle\Repository;

use Purethink\AdminBundle\Repository\FilterRepository;


class TemplateRepository extends FilterRepository
{
    public function getTemplatesQB($order, $sequence, $filter, $groupId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.series', 's');

        $this->addNameFilterQB($qb, $filter);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy($order, $sequence);

        return $qb;
    }

    public function getTemplatesByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
