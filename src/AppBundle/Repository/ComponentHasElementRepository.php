<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\ComponentHasElement;
use AppBundle\Entity\ComponentHasValue;

class ComponentHasElementRepository extends EntityRepository
{
    public function getActiveComponentBySlugAndLocale($slug, $locale)
    {
        $entities = [];

        $componentsQb = $this->getActiveComponentBySlugAndLocaleQb($slug, $locale);
        $components = $componentsQb->getQuery()->getResult();

        /** @var ComponentHasElement $component */
        foreach ($components as $component) {
            $created = $component->getComponent()->getCreated();
            $updated = $component->getComponent()->getUpdated();
            $elementId = $component->getId();

            $entities['title'] = $component->getComponent()->getName();
            $entities[$elementId]['created'] = $created;
            $entities[$elementId]['updated'] = $updated;

            /** @var ComponentHasValue $value */
            foreach ($component->getComponentHasValues() as $value) {
                $slug = $value->getExtensionHasField()->getSlug();
                $entities[$elementId][$slug] = $value->getContent();
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
            ->where('cop.enabled = true')
            ->andWhere('c.enabled = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('cop.slug = :slug')
            ->orderBy('c.position', 'ASC')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale);
    }
}