<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CMSComponentOnPageHasValueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CMSComponentOnPageHasValueRepository extends EntityRepository
{
    /**
     * Get elements
     *
     * @param string $order
     * @param string $sequence
     * @param string $filtr
     * @param integer $componentId
     * @return array
     */
    public function getElements($order, $sequence, $filtr, $componentId)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a, a.content')
            ->addSelect('cophe.id, cophe.createdAt, cophe.updatedAt, cophe.isEnable')
            ->leftJoin('a.componentOnPageHasElement', 'cophe')
            ->leftJoin('a.componentHasColumn', 'chc')
            ->leftJoin('cophe.componentOnPage', 'cop')
            ->where('chc.isMainField = true')
            ->andWhere('a.content LIKE :filtr')
            ->setParameter('filtr', '%'.$filtr.'%');

        if ($componentId) {
            $qb->andWhere('cop.id = :componentId')
                ->setParameter('componentId', $componentId);
        }

        $qb->orderBy($order, $sequence);

        $qb->groupBy('a.componentOnPageHasElement');

        return $qb->getQuery();
    }

    /**
     * Get content
     *
     * @param integer $elementId
     * @param integer $typeId
     * @return object
     */
    public function getContent($elementId, $typeId)
    {
        $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.componentOnPageHasElement', 'cophe')
            ->leftJoin('a.componentHasColumn', 'chc')
            ->where('cophe.id = :elementId')
            ->setParameter('elementId', $elementId)
            ->andWhere('chc.id = :typeId')
            ->setParameter('typeId', $typeId)
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}