<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;


class LanguageRepository extends EntityRepository
{
    public function getPublicLanguages()
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.enabled = true')
            ->orderBy('a.name');

        return $qb->getQuery()->getResult();
    }
}
