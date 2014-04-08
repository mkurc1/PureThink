<?php
namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;


class ExtensionRepository extends FilterRepository
{
    /**
     * Get extensions
     *
     * @param string $order
     * @param string $sequence
     * @param string $filter
     * @param string $groupId
     * @return array
     */
    public function getExtensionsQB($order, $sequence, $filter, $groupId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.series', 's');

        $this->addNameFilterQB($qb, $filter);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }

    public function getExtensionsByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('e')
            ->where('e.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
