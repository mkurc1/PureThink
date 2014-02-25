<?php

namespace My\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

class FilterRepository extends EntityRepository
{
    /**
     * Add language alias filter
     *
     * @param QueryBuilde $qb
     * @param string $alias
     */
    protected function addLanguageAliasFilter($qb, $languageAlias = null, $alias = 'l')
    {
        if (null != $alias) {
            $qb->andWhere($alias.'.alias = :languageAlias')
               ->setParameter('languageAlias', $languageAlias);
        }
    }

    /**
     * Add name filter
     *
     * @param QueryBuilde $qb
     * @param string $filter
     */
    protected function addNameFilterQB($qb, $filter = null)
    {
        if (null != $filter) {
            $qb->andWhere($qb->getRootAlias().'.name LIKE :filter')
               ->setParameter('filter', '%'.$filter.'%');
        }
    }

    /**
     * Add language filter
     *
     * @param QueryBuilde $qb
     * @param string $filter
     */
    protected function addLanguageIdFilterQB($qb, $languageId = null, $alias = 'l')
    {
        if (null != $languageId) {
            $qb->andWhere($alias.'.id = :languageId')
               ->setParameter('languageId', $languageId);
        }
    }

    /**
     * Add group filter
     *
     * @param QueryBuilde $qb
     * @param string $filter
     */
    protected function addGroupFilterQB($qb, $groupId = null, $alias = 's')
    {
        if (null != $groupId) {
            $qb->andWhere($alias.'.id = :groupId')
               ->setParameter('groupId', $groupId);
        }
    }
}
