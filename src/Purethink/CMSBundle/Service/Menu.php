<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Purethink\CMSBundle\Entity\Menu as MenuEntity;
use Doctrine\Common\Collections\ArrayCollection;

class Menu
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param $slug
     * @param $locale
     * @return array
     */
    public function getActiveMenusBySlugAndLocale($slug, $locale)
    {
        $entities = [];

        /** @var ArrayCollection $menus */
        $menus = $this->entityManager
            ->getRepository('PurethinkCMSBundle:Menu')
            ->getActiveMenusBySlugAndLocale($slug, $locale);

        /** @var MenuEntity $menu */
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
}