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

    public function articleBySlug($slug)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('t')
            ->join('a.translations', 't')
            ->where('a.published = true')
            ->andWhere('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->setMaxResults(1);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
