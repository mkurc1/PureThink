<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;


class ComponentRepository extends FilterRepository
{
    /**
     * Get components
     *
     * @param string $order
     * @param string $sequence
     * @param string $filter
     * @param string $groupId
     * @return array
     */
	public function getComponentsQB($order, $sequence, $filter, $groupId)
	{
		$qb = $this->createQueryBuilder('a')
            ->join('a.series', 's');

        $this->addNameFilterQB($qb, $filter);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy($order, $sequence);

		return $qb->getQuery();
	}

    public function getComponentsByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('c')
            ->where('c.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
