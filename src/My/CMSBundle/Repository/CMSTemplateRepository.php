<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CMSTemplateRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CMSTemplateRepository extends EntityRepository
{
    /**
     * Get templates
     *
     * @param string $order
     * @param string $sequence
     * @param string $filtr
     * @return array
     */
    public function getTemplates($order, $sequence, $filtr)
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.name LIKE :filtr')
            ->setParameter('filtr', '%'.$filtr.'%');

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }
}
