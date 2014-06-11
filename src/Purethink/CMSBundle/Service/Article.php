<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Purethink\CMSBundle\Entity\ArticleView;
use Purethink\CMSBundle\Entity\Article as ArticleEntity;

class Article
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $slug
     * @return ArticleEntity
     * @throws EntityNotFoundException
     */
    public function getArticleBySlugAndIncrementCountViews($slug)
    {
        $article = $this->getArticleBySlug($slug);
        $this->incrementArticleViews($article->getViews());

        return $article;
    }

    /**
     * @param string $slug
     * @return ArticleEntity
     * @throws EntityNotFoundException
     */
    public function getArticleBySlug($slug)
    {
        /** @var ArticleEntity $article */
        $article = $this->entityManager
            ->getRepository('PurethinkCMSBundle:Article')
            ->getPublicArticleBySlug($slug);

        if (null == $article) {
            throw new EntityNotFoundException();
        }

        return $article;
    }

    /**
     * @param ArticleView $article
     */
    private function incrementArticleViews(ArticleView $article)
    {
        $article->incrementArticleViews();
        $this->entityManager->flush($article);
    }
}