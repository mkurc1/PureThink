<?php

namespace Purethink\AdminBundle\Service;

use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Paginator;
use Purethink\AdminBundle\Model\Pagination;

class PaginationService
{
    private $paginator;

    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function setPagination(QueryBuilder $entitiesQb, $page = 1, $rowsOnPage = 10)
    {
        $pagination = $this->paginator->paginate($entitiesQb, $page, $rowsOnPage);

        return new Pagination($pagination);
    }
}
