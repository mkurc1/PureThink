<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;

class ExtensionHasFieldRepository extends FilterRepository
{
    /**
     * Get fields
     *
     * @param string  $order
     * @param string  $sequence
     * @param string  $filter
     * @param integer $extensionId
     * @return QueryBuilder
     */
    public function getFieldsQB($order, $sequence, $filter, $extensionId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.extension', 'c')
            ->where('c.id = :extensionId')
            ->setParameter('extensionId', $extensionId);

        $this->addNameFilterQB($qb, $filter);

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }

    public function getFieldsByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('f')
            ->where('f.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
