<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;


class TemplateRepository extends FilterRepository
{
    public function getTemplatesQB($order, $sequence, $filter)
    {
        $qb = $this->createQueryBuilder('a');

        $this->addNameFilterQB($qb, $filter);

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }

    public function getTemplatesByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
