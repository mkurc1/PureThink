<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;

class ComponentHasColumnRepository extends FilterRepository
{
    /**
     * Get columns
     *
     * @param string $order
     * @param string $sequence
     * @param string $filter
     * @param integer $extensionId
     * @return QueryBuilder
     */
	public function getColumnsQB($order, $sequence, $filter, $extensionId)
	{
		$qb = $this->createQueryBuilder('a')
            ->join('a.extension', 'c')
            ->where('c.id = :extensionId')
            ->setParameter('extensionId', $extensionId);

        $this->addNameFilterQB($qb, $filter);

        $qb->orderBy($order, $sequence);

		return $qb->getQuery();
	}
}
