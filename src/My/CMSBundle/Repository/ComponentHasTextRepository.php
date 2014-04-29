<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ComponentHasTextRepository extends EntityRepository
{
    public function getElementsQB($order, $sequence, $filter, $componentId)
    {
        $qb = $this->createQueryBuilder('c')
            ->addSelect('ce')
            ->join('c.componentHasElement', 'ce')
            ->join('c.extensionHasField', 'cf')
            ->join('ce.component', 'cec')
            ->where('cf.isMainField = true')
            ->andWhere('c.text LIKE :filter')
            ->setParameter('filter', '%' . $filter . '%');

        if ($componentId) {
            $qb->andWhere('cec.id = :componentId')
                ->setParameter('componentId', $componentId);
        }

        $qb->orderBy($order, $sequence);

        return $qb;
    }
}