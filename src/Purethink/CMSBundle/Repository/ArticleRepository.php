<?php

namespace Purethink\CMSBundle\Repository;

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

    public function getPublicArticleBySlug($slug)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('am, at')
            ->join('a.metadata', 'am')
            ->leftJoin('a.tags', 'at', 'WITH', 'at.enabled = true')
            ->where('a.published = true')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getPublicArticles()
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('l')
            ->join('a.language', 'l')
            ->where('a.published = true');

        return $qb->getQuery()->getResult();
    }
}
