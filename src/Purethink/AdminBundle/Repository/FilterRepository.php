<?php

namespace Purethink\AdminBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class FilterRepository extends EntityRepository
{
    protected function addLanguageAliasFilter(QueryBuilder $qb, $languageAlias = null, $alias = 'l')
    {
        if (null != $alias) {
            $qb->andWhere($alias . '.alias = :languageAlias')
                ->setParameter('languageAlias', $languageAlias);
        }
    }

    protected function addNameFilterQB(QueryBuilder $qb, $filter = null)
    {
        if (null != $filter) {
            $qb->andWhere($qb->getRootAlias() . '.name LIKE :filter')
                ->setParameter('filter', '%' . $filter . '%');
        }
    }

    protected function addLanguageIdFilterQB(QueryBuilder $qb, $languageId = null, $alias = 'l')
    {
        if (null != $languageId) {
            $qb->andWhere($alias . '.id = :languageId')
                ->setParameter('languageId', $languageId);
        }
    }

    protected function addGroupFilterQB(QueryBuilder $qb, $groupId = null, $alias = 's')
    {
        if (null != $groupId) {
            $qb->andWhere($alias . '.id = :groupId')
                ->setParameter('groupId', $groupId);
        }
    }
}
