<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;


class TemplateRepository extends FilterRepository
{
    /**
     * Get templates
     *
     * @param string $order
     * @param string $sequence
     * @param string $filter
     * @return array
     */
    public function getTemplatesQB($order, $sequence, $filter)
    {
        $qb = $this->createQueryBuilder('a');

        $this->addNameFilterQB($qb, $filter);

        $qb->orderBy($order, $sequence);

        return $qb->getQuery();
    }
}
