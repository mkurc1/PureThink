<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;


class MenuRepository extends FilterRepository
{
    public function getMenusQB($filter, $languageId, $groupId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.language', 'l')
            ->join('a.series', 's')
            ->leftJoin('a.article', 'art')
            ->Where('a.menu IS NULL');

        $this->addNameFilterQB($qb, $filter);
        $this->addLanguageIdFilterQB($qb, $languageId);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy('a.sequence');

        return $qb->getQuery()->getResult();
    }

    public function getMenusByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

    public function getActiveMenusBySlugAndLocale($slug, $locale)
    {
        $entities = [];

        $menus = $this->getActiveMenusBySlugAndLocaleQb($slug, $locale);
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

    private function getActiveMenusBySlugAndLocaleQb($slug, $locale)
    {
        return $this->createQueryBuilder('a')
            ->select('a, s, art')
            ->join('a.language', 'l')
            ->join('a.series', 's')
            ->leftJoin('a.article', 'art')
            ->leftJoin('a.menu', 'm')
            ->where('a.isPublic = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('art.isPublic = true')
            ->andWhere('s.name = :slug')
            ->orderBy('m.sequence, a.sequence')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale);
    }
}
