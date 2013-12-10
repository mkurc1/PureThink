<?php

namespace My\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * SeriesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SeriesRepository extends EntityRepository
{
	/**
	 * Get groups by menu ID no execute
	 *
	 * @param integer $menuId
	 * @return query
	 */
	public function getGroupsByMenuIdNoExecute($menuId)
	{
		$qb = $this->createQueryBuilder('s')
			->leftJoin('s.menu', 'm')
			->where('m.id = :menu_id')
		    ->setParameter('menu_id', $menuId)
			->orderBy('s.name');

		return $qb;
	}

	/**
	 * Get groups by menu ID
	 *
	 * @param integer $menuId
	 * @return array
	 */
	public function getGroupsByMenuId($menuId)
	{
		return $this->getGroupsByMenuIdNoExecute($menuId)->getQuery()->getResult();
	}
}
