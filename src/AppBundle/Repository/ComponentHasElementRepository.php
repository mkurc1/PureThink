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
        $componentHasElements = $componentsQb->getQuery()->getResult();

        /** @var ComponentHasElement $componentHasElement */
        foreach ($componentHasElements as $componentHasElement) {
            $component = $componentHasElement->getComponent();

            $validItem = true;
            $item = [
                'created_at' => $component->getCreatedAt(),
                'updated_at' => $component->getUpdatedAt()
            ];

            $entities['title'] = $component->getName();

            /** @var ComponentHasValue $value */
            foreach ($componentHasElement->getComponentHasValues() as $value) {
                $isRequired = $value->getExtensionHasField()->getRequired();
                $content = $value->getContent();

                if ($isRequired && null == $content) {
                    $validItem = false;
                } else {
                    $slug = $value->getExtensionHasField()->getSlug();
                    $item[$slug] = $content;
                }
            }

            if ($validItem) {
                $entities['entities'][] = (object)$item;
            }
        }

        $entities = (object)$entities;
        if (property_exists($entities, 'title') && property_exists($entities, 'entities')) {
            return $entities;
        }

        return null;
    }

    private function getActiveComponentBySlugAndLocaleQb($slug, $locale)
    {
        return $this->createQueryBuilder('c')
            ->addSelect('cc, cop, ehf, copt')
            ->join('c.componentHasValues', 'cc')
            ->join('cc.extensionHasField', 'ehf')
            ->join('c.component', 'cop')
            ->join('cop.translations', 'copt')
            ->where('cop.enabled = true')
            ->andWhere('c.enabled = true')
            ->andWhere('cop.slug = :slug')
            ->andWhere('copt.locale = :locale')
            ->groupBy('cc')
            ->orderBy('c.position', 'ASC')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale);
    }
}