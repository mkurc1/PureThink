<?php

namespace My\BackendBundle\Pagination;

/**
 * Pagination
 */
class Pagination
{
    /**
     * Get pagination
     *
     * @param  \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination $pagination
     * @return array
     */
    static function helper(\Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination $pagination)
    {
        $paginationData = $pagination->getPaginationData();

        return array(
            "pages" => $paginationData['pagesInRange'],
            "previous" => (isset($paginationData['previous']) ? $paginationData['previous'] : $paginationData['current']),
            "next" => (isset($paginationData['next']) ? $paginationData['next'] : $paginationData['current']),
            "first_page" => 1,
            "last_page" => $paginationData['last']
            );
    }
}
