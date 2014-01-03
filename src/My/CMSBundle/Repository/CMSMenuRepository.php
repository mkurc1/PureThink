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
     * @param string $order
     * @param string $sequence
     * @param string $filtr
     * @param string $languageId
     * @param string $groupId
     * @return array
     */
	public function getMenus($order, $sequence, $filtr, $languageId, $groupId)
	{
		$qb = $this->createQueryBuilder('a')
            ->leftJoin('a.language', 'l')
            ->leftJoin('a.series', 's')
            ->leftJoin('a.article', 'art')
            ->where('a.name LIKE :filtr')
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

		return $qb->getQuery();
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
            ->select('a, s')
            ->leftJoin('a.language', 'l')
            ->leftJoin('a.series', 's')
            ->leftJoin('a.article', 'art')
            ->where('a.isPublic = true')
            ->andWhere('l.alias = :locale')
            ->setParameter('locale', $locale)
            ->orderBy('a.sequence');

        return $qb->getQuery()->getResult();
    }
}
