<?php

namespace My\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function getUsersQB($order, $sequence, $filter)
    {
        $qb = $this->createQueryBuilder('a');

        if (null != $filter) {
            $qb->andWhere('a.username LIKE :filter')
                ->setParameter('filter', '%' . $filter . '%');
        }

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }

    public function getUsersByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }
}
