<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use My\CMSBundle\Entity\ComponentHasColumn;

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
            ->leftJoin('a.componentHasColumn', 'chc')
            ->leftJoin('cophe.componentOnPage', 'cop')
            ->where('chc.isMainField = true')
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
            ->join('a.componentHasColumn', 'chc')
            ->where('cophe.id = :elementId')
            ->setParameter('elementId', $elementId)
            ->andWhere('chc.id = :typeId')
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
        $type = ComponentHasColumn::getColumnTypeStringById($component['type']);

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
            ->addSelect('chc.slug AS subname')
            ->addSelect('chc.columnType AS type')
            ->addSelect('cophe.createdAt AS createdAt, cophe.updatedAt AS updatedAt')
            ->addSelect("art.slug AS article")
            ->addSelect("f.path AS file")
            ->join('a.componentOnPageHasElement', 'cophe')
            ->join('a.componentHasColumn', 'chc')
            ->join('cophe.componentOnPage', 'cop')
            ->join('cop.language', 'l')
            ->leftJoin('MyCMSBundle:Article', 'art', 'WITH', 'art.id=CASE WHEN chc.columnType=9 THEN a.content ELSE 0 END')
            ->leftJoin('MyFileBundle:File', 'f', 'WITH', 'f.id=CASE WHEN chc.columnType=10 THEN a.content ELSE 0 END')
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
            ->join('a2.componentHasColumn', 'chc2')
            ->andWhere('cophe2.id = '.$elementId)
            ->andWhere('chc2.isMainField = true')
            ->setMaxResults(1);

        return $qb->getQuery();
    }
}