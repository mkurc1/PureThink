<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ComponentHasValueRepository extends EntityRepository
{
    public function getContent($elementId, $typeId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.componentHasElement', 'che')
            ->join('a.extensionHasField', 'ehf')
            ->where('che.id = :elementId')
            ->setParameter('elementId', $elementId)
            ->andWhere('ehf.id = :typeId')
            ->setParameter('typeId', $typeId)
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }
}