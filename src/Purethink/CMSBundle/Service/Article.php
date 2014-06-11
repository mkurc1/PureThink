<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityNotFoundException;
use Purethink\CMSBundle\Entity\ArticleView;

class Article
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getArticleBySlugAndIncrementCountViews($slug)
    {
        $article = $this->getArticleBySlug($slug);
        $this->incrementArticleViews($article->getViews());

        return $article;
    }

    public function getArticleBySlug($slug)
    {
        $article = $this->entityManager
            ->getRepository('PurethinkCMSBundle:Article')
            ->getPublicArticleBySlug($slug);

        if (null == $article) {
            throw new EntityNotFoundException();
        }

        return $article;
    }

    private function incrementArticleViews(ArticleView $article)
    {
        $article->incrementArticleViews();
        $this->entityManager->flush($article);
    }
}