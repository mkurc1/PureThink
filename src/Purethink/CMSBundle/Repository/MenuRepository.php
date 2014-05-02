<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;


class MenuRepository extends EntityRepository
{
    public function getActiveMenusBySeriesNameAndLocale($type, $locale)
    {
        $entities = [];

        $menus = $this->getActiveMenusBySeriesNameAndLocaleQb($type, $locale);
        $menus = $menus->getQuery()->getResult();

        foreach ($menus as $menu) {
            $id = $menu->getId();

            if (is_object($menu->getMenu()) && $menu->getMenu()->getIsPublic() && $menu->getMenu()->getArticle()->getIsPublic()) {
                $parentId = $menu->getMenu()->getId();
                $entities[$parentId]['children'][$id]['parent'] = $menu;
            } else {
                $entities[$id]['parent'] = $menu;
            }
        }

        return $entities;
    }

    private function getActiveMenusBySeriesNameAndLocaleQb($type, $locale)
    {
        return $this->createQueryBuilder('a')
            ->select('a, t, art')
            ->join('a.language', 'l')
            ->join('a.type', 't')
            ->leftJoin('a.article', 'art')
            ->leftJoin('a.menu', 'm')
            ->where('a.isPublic = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('art.isPublic = true')
            ->andWhere('t.name = :type')
            ->orderBy('m.sequence, a.sequence')
            ->setParameter('type', $type)
            ->setParameter('locale', $locale);
    }
}
