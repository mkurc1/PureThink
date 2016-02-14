<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function searchResults($locale, $search)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.language', 'al')
            ->where('a.published = true')
            ->andWhere('UPPER(al.alias) = UPPER(:locale)')
            ->andWhere('UPPER(a.name) LIKE UPPER(:search)')
            ->setParameter('locale', $locale)
            ->setParameter('search', '%' . $search . '%');

        return $qb->getQuery()->getResult();
    }

    public function articleBySlug($params)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('am')
            ->join('a.metadata', 'am')
            ->where('a.published = true')
            ->andWhere('a.slug = :slug')
            ->setParameters($params);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
