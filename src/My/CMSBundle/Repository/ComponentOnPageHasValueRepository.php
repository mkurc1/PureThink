<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use My\CMSBundle\Entity\ExtensionHasField;

class ComponentOnPageHasValueRepository extends EntityRepository
{
    /**
     * Get elements
     *
     * @param string $order
     * @param string $sequence
     * @param string $filter
     * @param integer $componentId
     * @return array
     */
    public function getElementsQB($order, $sequence, $filter, $componentId)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a, a.content')
            ->addSelect('cophe.id, cophe.createdAt, cophe.updatedAt, cophe.isEnable')
            ->leftJoin('a.componentOnPageHasElement', 'cophe')
            ->leftJoin('a.extensionHasField', 'ehf')
            ->leftJoin('cophe.componentOnPage', 'cop')
            ->where('ehf.isMainField = true')
            ->andWhere('a.content LIKE :filter')
            ->setParameter('filter', '%'.$filter.'%');

        if ($componentId) {
            $qb->andWhere('cop.id = :componentId')
               ->setParameter('componentId', $componentId);
        }

        $qb->groupBy('a.componentOnPageHasElement');

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }

    /**
     * Get content
     *
     * @param integer $elementId
     * @param integer $typeId
     * @return object
     */
    public function getContent($elementId, $typeId)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.componentOnPageHasElement', 'cophe')
            ->join('a.extensionHasField', 'ehf')
            ->where('cophe.id = :elementId')
            ->setParameter('elementId', $elementId)
            ->andWhere('ehf.id = :typeId')
            ->setParameter('typeId', $typeId)
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

    public function getActiveComponentBySlugAndLocale($slug, $locale)
    {
        $entities = [];

        $components = $this->getActiveComponentBySlugAndLocaleQb($slug, $locale);
        $components = $components->getQuery()->getResult();

        foreach ($components as $component) {
            $title     = $component['title'];
            $elementId = $component['elementId'];
            $subname   = $component['subname'];
            $createdAt = $component['createdAt'];
            $updatedAt = $component['updatedAt'];
            $content   = $this->getComponentContent($component);

            $entities['title'] = $title;
            $entities[$elementId][$subname] = $content;
            $entities[$elementId]['createdAt'] = $createdAt;
            $entities[$elementId]['updatedAt'] = $updatedAt;
        }

        return $entities;
    }

    private function getComponentContent($component)
    {
        $content = $component['content'];
        $type = ExtensionHasField::getTypeOfFieldStringById($component['type']);

        switch ($type) {
            case 'Article':
                $content = $component['article'];
                break;
            case 'File':
                $content = $component['file'];
                break;
        }

        return $content;
    }

    private function getActiveComponentBySlugAndLocaleQb($slug, $locale)
    {
        return $this->createQueryBuilder('a')
            ->select('a.content')
            ->addSelect('cop.name AS title')
            ->addSelect('('.$this->getElementId('cophe.id')->getDQL().') AS elementId')
            ->addSelect('ehf.slug AS subname, ehf.typeOfField AS type')
            ->addSelect('cophe.createdAt, cophe.updatedAt')
            ->addSelect("art.slug AS article")
            ->addSelect("f.path AS file")
            ->join('a.componentOnPageHasElement', 'cophe')
            ->join('a.extensionHasField', 'ehf')
            ->join('cophe.componentOnPage', 'cop')
            ->join('cop.language', 'l')
            ->leftJoin('MyCMSBundle:Article', 'art', 'WITH', 'art.id=CASE WHEN ehf.typeOfField=9 THEN a.content ELSE 0 END')
            ->leftJoin('MyFileBundle:File', 'f', 'WITH', 'f.id=CASE WHEN ehf.typeOfField=10 THEN a.content ELSE 0 END')
            ->where('cop.isEnable = true')
            ->andWhere('cophe.isEnable = true')
            ->andWhere('UPPER(l.alias) = UPPER(:locale)')
            ->andWhere('cop.slug = :slug')
            ->orderBy('cop.slug', 'ASC')
            ->setParameter('slug', $slug)
            ->setParameter('locale', $locale);
    }

    /**
     * Get element ID
     *
     * @param integer $elementId
     * @return object
     */
    private function getElementId($elementId)
    {
        $qb = $this->createQueryBuilder('a2')
            ->select('a2.id')
            ->join('a2.componentOnPageHasElement', 'cophe2')
            ->join('a2.extensionHasField', 'ehf2')
            ->andWhere('cophe2.id = '.$elementId)
            ->andWhere('ehf2.isMainField = true')
            ->setMaxResults(1);

        return $qb->getQuery();
    }
}