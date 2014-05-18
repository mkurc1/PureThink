<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Purethink\CMSBundle\Entity\Menu;


class MenuRepository extends EntityRepository
{
    public function getActiveMenusByTypeAndLocale($type, $locale)
    {
        $entities = [];

        $menus = $this->getActiveMenusByTypeAndLocaleQb($type, $locale);
        $menus = $menus->getQuery()->getResult();

        /** @var Menu $menu */
        foreach ($menus as $menu) {
            $id = $menu->getId();

            if (is_object($menu->getMenu()) &&
                $menu->getMenu()->getPublished() &&
                $menu->getMenu()->getArticle()->getPublished()) {
                $parentId = $menu->getMenu()->getId();
                $entities[$parentId]['children'][$id]['parent'] = $menu;
            } else {
                $entities[$id]['parent'] = $menu;
            }
        }

        return $entities;
    }

    private function getActiveMenusByTypeAndLocaleQb($type, $locale)
    {
        return $this->createQueryBuilder('a')
            ->select('a, t, art')
            ->join('a.language', 'l')
            ->join('a.type', 't')
            ->leftJoin('a.article', 'art')
            ->leftJoin('a.menu', 'm')
            ->where('a.published = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('art.published = true')
            ->andWhere('t.name = :type')
            ->orderBy('m.position, a.position')
            ->setParameter('type', $type)
            ->setParameter('locale', $locale);
    }
}
