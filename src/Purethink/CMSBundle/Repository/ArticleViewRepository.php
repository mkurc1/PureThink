<?php

namespace Purethink\CMSBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Purethink\CMSBundle\Entity\ArticleView;

class ArticleViewRepository extends EntityRepository
{
    public function incrementViews(ArticleView $view)
    {
        $view->setViews($view->getViews() + 1);
        $this->getEntityManager()->flush($view);
    }
}