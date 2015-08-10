<?php

namespace Purethink\CMSBundle\Service;

use Doctrine\ORM\EntityManager;
use Purethink\CMSBundle\Entity\ArticleView;

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

    public function incrementArticleViews(ArticleView $article)
    {
        $article->incrementArticleViews();
        $this->entityManager->flush($article);
    }
}