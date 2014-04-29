<?php
namespace My\CMSBundle\Repository;

use My\AdminBundle\Repository\FilterRepository;


class ExtensionRepository extends FilterRepository
{
    public function getExtensionsQB($order, $sequence, $filter, $groupId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.series', 's');

        $this->addNameFilterQB($qb, $filter);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy($order, $sequence);

        return $qb;
    }

    public function getExtensionsByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
