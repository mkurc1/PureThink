<?php

namespace Purethink\AdminBundle\Model;

use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;

class Pagination
{
    private $entities;
    private $pages;
    private $previousPage;
    private $nextPage;
    private $firstPage;
    private $lastPage;
    private $totalPages;


    public function __construct(SlidingPagination $pagination)
    {
        $paginationData = $pagination->getPaginationData();

        $this->entities = $pagination;
        $this->pages = $paginationData['pagesInRange'];
        $this->previousPage = (isset($paginationData['previous']) ? $paginationData['previous'] : $paginationData['current']);
        $this->nextPage = (isset($paginationData['next']) ? $paginationData['next'] : $paginationData['current']);
        $this->firstPage = $paginationData['first'];
        $this->lastPage = ($paginationData['last'] != 0) ? $paginationData['last'] : 1;
        $this->totalPages = $paginationData['totalCount'];
    }

    public function toArray()
    {
        return [
            "entities"    => $this->getEntities(),
            "pages"       => $this->getPages(),
            "previous"    => $this->getPreviousPage(),
            "next"        => $this->getNextPage(),
            "first_page"  => $this->getFirstPage(),
            "last_page"   => $this->getLastPage(),
            "total_count" => $this->getTotalPages()
        ];
    }

    public function getEntities()
    {
        return $this->entities;
    }

    public function getFirstPage()
    {
        return $this->firstPage;
    }

    public function getLastPage()
    {
        return $this->lastPage;
    }

    public function getNextPage()
    {
        return $this->nextPage;
    }

    public function getPages()
    {
        return $this->pages;
    }

    public function getPreviousPage()
    {
        return $this->previousPage;
    }

    public function getTotalPages()
    {
        return $this->totalPages;
    }
}