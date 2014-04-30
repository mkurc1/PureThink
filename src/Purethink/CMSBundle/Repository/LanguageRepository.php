<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;


class LanguageRepository extends EntityRepository
{
    public function getLanguages()
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.name');

        return $qb->getQuery()->getResult();
    }

    public function getFirstLanguage()
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.name')
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

    public function getPublicLanguages()
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.isPublic = true')
            ->orderBy('a.name');

        return $qb->getQuery()->getResult();
    }
}
