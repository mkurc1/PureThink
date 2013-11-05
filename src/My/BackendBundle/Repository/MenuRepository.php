<?php

namespace My\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * MenuRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MenuRepository extends EntityRepository
{
	/**
	 * Get menu
	 *
	 * @param integer $moduleId
	 * @return array
	 */
	public function getMenus($moduleId)
	{
		$qb = $this->createQueryBuilder('m')
			->leftJoin('m.module', 'mod')
			->where('mod.id = :module_id')
		    ->setParameter('module_id', $moduleId)
			->orderBy('m.sequence');

		return $qb->getQuery()->getResult();
	}
}
