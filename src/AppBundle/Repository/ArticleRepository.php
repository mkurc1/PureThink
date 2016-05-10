<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ArticleRepository extends EntityRepository
{
    public function searchResults($locale, $search)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('t')
            ->join('a.translations', 't')
            ->where('a.published = true')
            ->andWhere('t.locale = :locale')
            ->andWhere('UPPER(t.name) LIKE UPPER(:search)')
            ->setParameter('locale', $locale)
            ->setParameter('search', '%' . $search . '%');

        return $qb->getQuery()->getResult();
    }

    public function articleBySlug($locale, $slug)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('am, t')
            ->join('a.metadata', 'am')
            ->join('a.translations', 't')
            ->where('a.published = true')
            ->andWhere('t.slug = :slug')
            ->andWhere('t.locale = :locale')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
