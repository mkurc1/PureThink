<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ComponentHasElementRepository extends EntityRepository
{
    public function getElementsByIds(array $ids)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

    public function getActiveComponentBySlugAndLocale($slug, $locale)
    {
        $entities = [];

        $componentsQb = $this->getActiveComponentBySlugAndLocaleQb($slug, $locale);
        $components = $componentsQb->getQuery()->getResult();

        foreach ($components as $component) {
            $createdAt = $component->getComponent()->getCreatedAt();
            $updatedAt = $component->getComponent()->getUpdatedAt();
            $elementId = $component->getId();

            $entities['title'] = $component->getComponent()->getName();
            $entities[$elementId]['createdAt'] = $createdAt;
            $entities[$elementId]['updatedAt'] = $updatedAt;

            foreach ($component->getComponentHasValues() as $value) {
                $slug = $value->getExtensionHasField()->getSlug();
                $content = $value->getStringContent();

                $entities[$elementId][$slug] = $content;
            }
        }

        return $entities;
    }

    private function getActiveComponentBySlugAndLocaleQb($slug, $locale)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('cc, cop, ehf')
            ->join('c.componentHasValues', 'cc')
            ->join('cc.extensionHasField', 'ehf')
            ->join('c.component', 'cop')
            ->join('cop.language', 'l')
            ->where('cop.isEnable = true')
            ->andWhere('c.isEnable = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('cop.slug = :slug')
            ->orderBy('cop.slug', 'ASC')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale);
    }
}