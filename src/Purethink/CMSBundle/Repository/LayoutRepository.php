<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Purethink\CMSBundle\Entity\Template;


class LayoutRepository extends EntityRepository
{
    public function getLayoutForTypeOfTemplate(Template $template, $type)
    {
        $qb = $this->createQueryBuilder('l')
            ->addSelect('lsc, lst, lt')
            ->join('l.template', 'lt')
            ->leftJoin('l.scripts', 'lsc')
            ->leftJoin('l.styles', 'lst')
            ->where('l.template = :template')
            ->andWhere('l.type = :type')
            ->setParameters(compact('template', 'type'));

        return $qb->getQuery()->getOneOrNullResult();
    }
}
