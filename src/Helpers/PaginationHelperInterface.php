<?php

namespace LaravelRocket\Foundation\Helpers;

interface PaginationHelperInterface
{
    /**
     * @param  int  $offset
     * @param  int  $limit
     * @param  int  $maxLimit
     * @param  int  $defaultLimit
     * @return mixed
     */
    public function normalize($offset, $limit, $maxLimit, $defaultLimit): array;

    /**
     * @param  int  $offset
     * @param  int  $limit
     * @param  int  $count
     * @param  string  $path
     * @param  array  $query
     * @param  int  $paginationNumber
     */
    public function data($offset, $limit, $count, $path, $query, $paginationNumber = 5): array;

    /**
     * @param  int  $offset
     * @param  int  $limit
     * @param  int  $count
     * @param  string  $path
     * @param  array  $query
     * @param  int  $paginationNumber
     * @param  string  $template
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function render(
        $offset,
        $limit,
        $count,
        $path,
        $query,
        $paginationNumber = 5,
        $template = 'shared.pagination'
    ): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View;
}
