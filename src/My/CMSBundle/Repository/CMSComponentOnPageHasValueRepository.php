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

        $qb->groupBy('a.componentOnPageHasElement');

        $qb->orderBy($order, $sequence);

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

    /**
     * Get components
     *
     * @param string $locale
     * @return array
     */
    public function getComponents($locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a.content')
            ->addSelect('cop.slug')
            ->addSelect('('.$this->getElementName('cophe.id')->getDQL().') AS name')
            ->addSelect('chc.slug AS subname')
            ->leftJoin('a.componentOnPageHasElement', 'cophe')
            ->leftJoin('a.componentHasColumn', 'chc')
            ->leftJoin('cophe.componentOnPage', 'cop')
            ->where('cop.isEnable = true')
            ->andWhere('cophe.isEnable = true')
            ->orderBy('cop.slug', 'ASC');

        return $qb->getQuery()->getResult();
    }

    /**
     * Get element name
     *
     * @param integer $elementId
     * @return object
     */
    private function getElementName($elementId)
    {
        $qb = $this->createQueryBuilder('a2')
            ->select('a2.content')
            ->leftJoin('a2.componentOnPageHasElement', 'cophe2')
            ->leftJoin('a2.componentHasColumn', 'chc2')
            ->andWhere('cophe2.id = '.$elementId)
            ->andWhere('chc2.isMainField = true')
            ->setMaxResults(1);

        return $qb->getQuery();
    }
}