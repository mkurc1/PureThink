<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class MenuRepository extends EntityRepository
{
    public function getActiveMenu($typeSlug, $locale)
    {
        $articleIds = $this->getEntityManager()->getRepository('AppBundle:MenuArticle')
            ->getActiveMenuIds($typeSlug, $locale);

        $urlIds = $this->getEntityManager()->getRepository('AppBundle:MenuUrl')
            ->getActiveMenuIds($typeSlug, $locale);

        $ids = array_merge($articleIds, $urlIds);

        $qb = $this->createQueryBuilder('a')
            ->addSelect('at')
            ->join('a.translations', 'at', 'WITH', 'at.locale = :locale')
            ->where('a.published = true')
            ->andWhere('a.id IN (:ids)')
            ->andWhere('a.menu IS NULL')
            ->orderBy('a.position')
            ->setParameter('ids', $ids)
            ->setParameter('locale', $locale);

        return $qb->getQuery()->getResult();
    }
}
