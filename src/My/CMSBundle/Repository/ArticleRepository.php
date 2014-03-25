<?php

namespace My\CMSBundle\Repository;

use My\BackendBundle\Repository\FilterRepository;


class ArticleRepository extends FilterRepository
{
    /**
     * Get articles
     *
     * @param string $order
     * @param string $sequence
     * @param string $filter
     * @param string $languageId
     * @param string $groupId
     * @return array
     */
	public function getArticlesQB($order, $sequence, $filter, $languageId, $groupId)
	{
		$qb = $this->createQueryBuilder('a')
            ->join('a.language', 'l')
            ->join('a.series', 's');

        $this->addNameFilterQB($qb, $filter);
        $this->addLanguageIdFilterQB($qb, $languageId);
        $this->addGroupFilterQB($qb, $groupId);

        $qb->orderBy($order, $sequence);

		return $qb->getQuery();
	}

    /**
     * Get articles by ID
     *
     * @param  $ids
     * @return array
     */
    public function getArticlesByIds($ids = [])
    {
        $qb = $this->createQueryBuilder('a')
            ->where('a.id IN (:ids)')
            ->setParameter('ids', $ids);

        return $qb->getQuery()->getResult();
    }

    /**
     * Search
     *
     * @param string $locale
     * @param string $search
     * @return array
     */
    public function search($locale, $search)
    {
        $qb = $this->createQueryBuilder('a')
            ->join('a.language', 'l')
            ->where('a.isPublic = true');

        $this->addLanguageAliasFilter($qb, $locale);
        $this->addNameFilterQB($qb, $search);

        return $qb->getQuery()->getResult();
    }

    public function getArticleBySlug($slug)
    {
        $qb = $this->createQueryBuilder('a')
            ->addSelect('am')
            ->join('a.metadata', 'am')
            ->where('a.isPublic = true')
            ->andWhere('a.slug = :slug')
            ->setParameter('slug', $slug);

        return $qb->getQuery()->getOneOrNullResult();
    }
}
