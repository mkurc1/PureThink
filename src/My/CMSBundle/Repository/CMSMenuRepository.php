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

        $qb->orderBy($order, $sequence);

		return $qb->getQuery();
	}
}