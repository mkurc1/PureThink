<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;


class ArticleRepository extends EntityRepository
{
    public function search($alias, $search)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.language', 'al')
            ->where('a.isPublic = true')
            ->andWhere('UPPER(al.alias) = UPPER(:alias)')
            ->andWhere('a.name LIKE :search')
            ->setParameter('alias', $alias)
            ->setParameter('search', '%'.$search.'%');

        return $qb->getQuery()->getResult();
    }

    public function getPublicArticleBySlug($slug)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('am')
            ->join('a.metadata', 'am')
            ->where('a.isPublic = true')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getPublicArticles()
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('l')
            ->join('a.language', 'l')
            ->where('a.isPublic = true');

        return $qb->getQuery()->getResult();
    }
}
