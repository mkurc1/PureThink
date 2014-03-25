<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;


class LanguageRepository extends EntityRepository
{
    /**
     * Get languages
     *
     * @return array
     */
	public function getLanguages()
	{
		$qb = $this->createQueryBuilder('a')
            ->orderBy('a.name');

		return $qb->getQuery()->getResult();
	}

    /**
     * Get first language
     *
     * @return object
     */
    public function getFirstLanguage()
    {
        $qb = $this->createQueryBuilder('a')
            ->orderBy('a.name')
            ->setMaxResults(1);

        return $qb->getQuery()->getSingleResult();
    }

    /**
     * Get public languages
     *
     * @return array
     */
    public function getPublicLanguages()
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.isPublic = true')
            ->orderBy('a.name');

        return $qb->getQuery()->getResult();
    }
}
