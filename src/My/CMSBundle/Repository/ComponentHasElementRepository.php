<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use My\CMSBundle\Entity\ExtensionHasField;

class ComponentHasElementRepository extends EntityRepository
{
    public function getElementsQB($order, $sequence, $filter, $componentId)
    {
        $qb = $this->createQueryBuilder('c')
            ->addSelect('cc')
            ->join('c.componentHasValues', 'cc')
            ->join('cc.extensionHasField', 'ehf')
            ->join('c.component', 'cop')
            ->where('ehf.isMainField = true');
//            ->andWhere('cc.content LIKE :filter')
//            ->setParameter('filter', '%' . $filter . '%');

        if ($componentId) {
            $qb->andWhere('cop.id = :componentId')
                ->setParameter('componentId', $componentId);
        }

//        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
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

            foreach ($component->getComponentHasValues() as $value) {
                $slug = $value->getExtensionHasField()->getSlug();
                $content = $this->getComponentContent($value);

                $entities[$elementId][$slug] = $content;
                $entities[$elementId]['createdAt'] = $createdAt;
                $entities[$elementId]['updatedAt'] = $updatedAt;
            }
        }

        return $entities;
    }

    private function getComponentContent($component)
    {
        $type = $component->getExtensionHasField()->getTypeOfField();
        $content = $component->getContent();

        switch ($type) {
            case ExtensionHasField::TYPE_ARTICLE:
                $content = $content->getSlug();
                break;
            case ExtensionHasField::TYPE_FILE:
                $content = $content->getPath();
                break;
        }

        return $content;
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