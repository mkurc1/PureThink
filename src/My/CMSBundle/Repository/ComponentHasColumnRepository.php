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
     * @param integer $componentId
     * @return QueryBuilder
     */
	public function getColumnsQB($order, $sequence, $filter, $componentId)
	{
		$qb = $this->createQueryBuilder('a')
            ->join('a.component', 'c')
            ->where('c.id = :componentId')
            ->setParameter('componentId', $componentId);

        $this->addNameFilterQB($qb, $filter);

        $qb->orderBy($order, $sequence);

		return $qb->getQuery();
	}
}
