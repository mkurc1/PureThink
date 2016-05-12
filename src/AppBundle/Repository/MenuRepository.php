<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getActiveMenu($typeSlug, $locale)
    {
        $articles = $this->getEntityManager()->getRepository('AppBundle:MenuArticle')
            ->getActiveMenus($typeSlug, $locale);

        $urls = $this->getEntityManager()->getRepository('AppBundle:MenuUrl')
            ->getActiveMenus($typeSlug, $locale);

        $menus = array_merge($articles, $urls);

        $qb = $this->createQueryBuilder('a')
            ->addSelect('at')
            ->join('a.translations', 'at', 'WITH', 'at.locale = :locale')
            ->where('a.published = true')
            ->andWhere('a IN (:menus)')
            ->andWhere('a.menu IS NULL')
            ->orderBy('a.position')
            ->groupBy('a.id')
            ->setParameter('menus', $menus)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}
