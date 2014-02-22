<?php

namespace My\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CMSMenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CMSMenuRepository extends EntityRepository
{
    /**
     * Get menus
     *
     * @param string $filtr
     * @param string $languageId
     * @param string $groupId
     * @return array
     */
	public function getMenus($filtr, $languageId, $groupId)
	{
		$qb = $this->createQueryBuilder('a')
            ->leftJoin('a.language', 'l')
            ->leftJoin('a.series', 's')
            ->leftJoin('a.article', 'art')
            ->where('a.name LIKE :filtr')
            ->andWhere('a.menu IS NULL')
            ->setParameter('filtr', '%'.$filtr.'%');

        if ($languageId) {
            $qb->andWhere('l.id = :languageId')
                ->setParameter('languageId', $languageId);
        }

        if ($groupId) {
            $qb->andWhere('s.id = :groupId')
                ->setParameter('groupId', $groupId);
        }

        $qb->orderBy('a.sequence');

		return $qb->getQuery()->getResult();
	}

    /**
     * Get public menus
     *
     * @param string $locale
     * @return object
     */
    public function getPublicMenus($locale)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a, s, art')
            ->leftJoin('a.language', 'l')
            ->leftJoin('a.series', 's')
            ->leftJoin('a.article', 'art')
            ->leftJoin('a.menu', 'm')
            ->where('a.isPublic = true')
            ->andWhere('l.alias = :locale')
            ->setParameter('locale', $locale)
            ->orderBy('m.sequence, a.sequence');

        return $qb->getQuery()->getResult();
    }
}
