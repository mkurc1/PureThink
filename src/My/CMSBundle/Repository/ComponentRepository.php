<?php

namespace My\CMSBundle\Repository;

use My\AdminBundle\Repository\FilterRepository;


class ComponentRepository extends FilterRepository
{
    public function getComponentsQB($order, $sequence, $filter, $languageId, $groupId)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('a, e')
            ->join('a.language', 'l')
            ->join('a.series', 's')
            ->join('a.extension', 'e');

        $this->addNameFilterQB($qb, $filter);
        $this->addLanguageIdFilterQB($qb, $languageId);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy($order, $sequence);

        return $qb;
    }

    public function getComponentsByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
