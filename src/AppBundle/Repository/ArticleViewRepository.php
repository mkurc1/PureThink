<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\ArticleView;

class ArticleViewRepository extends EntityRepository
{
    public function incrementViews(ArticleView $view)
    {
        $view->setViews($view->getViews() + 1);
        $this->getEntityManager()->flush($view);
    }
}