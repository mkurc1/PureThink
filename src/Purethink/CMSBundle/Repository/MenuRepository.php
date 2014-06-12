<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getActiveMenusBySlugAndLocale($slug, $locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('t, art')
            ->join('a.language', 'l')
            ->join('a.type', 't')
            ->leftJoin('a.article', 'art')
            ->leftJoin('a.menu', 'm')
            ->where('a.published = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('art.published = true')
            ->andWhere('t.slug = :slug')
            ->orderBy('m.position, a.position')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}
