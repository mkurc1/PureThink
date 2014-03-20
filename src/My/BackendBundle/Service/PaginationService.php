<?php

namespace My\BackendBundle\Service;

class PaginationService
{
    private $knpPaginator;

    public function __construct($knpPaginator)
    {
        $this->knpPaginator = $knpPaginator;
    }

    public function setPagination($entitiesQB, $page, $rowsOnPage)
    {
        $paginator = $this->knpPaginator->paginate($entitiesQB, $page, $rowsOnPage);

        $paginationData = $paginator->getPaginationData();

        return [
            "entities" => $paginator,
            "pages" => $paginationData['pagesInRange'],
            "previous" => (isset($paginationData['previous']) ? $paginationData['previous'] : $paginationData['current']),
            "next" => (isset($paginationData['next']) ? $paginationData['next'] : $paginationData['current']),
            "first_page" => $paginationData['first'],
            "last_page" => ($paginationData['last'] != 0) ? $paginationData['last'] : 1,
            "total_count" => $paginationData['totalCount']
            ];
    }
}
