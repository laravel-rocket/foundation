<?php
namespace LaravelRocket\Foundation\Helpers\Production;

use LaravelRocket\Foundation\Helpers\PaginationHelperInterface;

class PaginationHelper implements PaginationHelperInterface
{
    public function render(
        $offset,
        $limit,
        $count,
        $path,
        $query,
        $paginationNumber = 5,
        $template = 'shared.pagination'
    ): \Illuminate\Contracts\View\Factory | \Illuminate\Contracts\View\View {
        $data = $this->data($offset, $limit, $count, $path, $query, $paginationNumber);

        return view($template, $data);
    }

    public function data(
        $offset,
        $limit,
        $count,
        $path,
        $query,
        $paginationNumber = 5
    ): array {
        if (empty($query) || !is_array($query)) {
            $query = [];
        }
        $data   = $this->normalize($offset, $limit, 100, 10);
        $offset = $data['offset'];
        $limit  = $data['limit'];
        $page   = intval($offset / $limit) + 1;
        $data   = [];
        if ($page != 1) {
            $data['firstPageLink'] = $this->generateLink(1, $path, $query, $limit);
        }
        $lastPage = intval(($count - 1) / $limit) + 1;

        if ($page < $lastPage) {
            $data['lastPageLink'] = $this->generateLink($lastPage, $path, $query, $limit);
        }
        $minPage = $page - intval($paginationNumber / 2);
        if ($minPage < 1) {
            $minPage = 1;
        }

        $data['pageListContainFirstPage'] = $minPage == 1 ? true : false;
        $data['pageListContainLastPage']  = false;

        $data['lastPage']    = $lastPage;
        $data['currentPage'] = $page;

        $data['pages'] = [];
        for ($i = $minPage; $i < ($minPage + $paginationNumber); ++$i) {
            if ($i > $lastPage) {
                break;
            }
            $data['pages'][] = [
                'number'  => $i,
                'link'    => $this->generateLink($i, $path, $query, $limit),
                'current' => ($i == $page) ? true : false,
            ];
            if ($i == $lastPage) {
                $data['pageListContainLastPage'] = true;
            }
        }

        $data['previousPageLink'] = $page <= 1 ? '' : $this->generateLink($page - 1, $path, $query, $limit);
        $data['nextPageLink']     = $page >= $lastPage ? '' : $this->generateLink($page + 1, $path, $query, $limit);

        if (count($data['pages']) > 0) {
            $firstListPage = $data['pages'][0]['number'];
            $lastListPage  = $data['pages'][count($data['pages']) - 1]['number'];

            $data['jumpBackPage']  = $firstListPage - $paginationNumber <= 1 ? '' : $firstListPage - $paginationNumber;
            $data['jumpAheadPage'] = $lastListPage + $paginationNumber >= $lastPage ? '' : $lastListPage + $paginationNumber;

            $data['jumpBackPageLink'] = $firstListPage - $paginationNumber <= 1 ? '' : $this->generateLink(
                $firstListPage - $paginationNumber,
                $path,
                $query,
                $limit
            );
            $data['jumpAheadPageLink'] = $lastListPage + $paginationNumber >= $lastPage ? '' : $this->generateLink(
                $lastListPage + $paginationNumber,
                $path,
                $query,
                $limit
            );
        } else {
            $data['jumpBackPage']      = '';
            $data['jumpAheadPage']     = '';
            $data['jumpBackPageLink']  = '';
            $data['jumpAheadPageLink'] = '';
        }

        return $data;
    }

    public function normalize($offset, $limit, $maxLimit, $defaultLimit): array
    {
        if ($limit <= 0 || $limit > $maxLimit) {
            $limit = $defaultLimit;
        }
        $page   = intval($offset / $limit);
        $offset = $limit * $page;

        return [
            'limit'  => $limit,
            'offset' => $offset,
        ];
    }

    private function generateLink($page, $path, $query, $limit): string
    {
        return $path.'?'.http_build_query(array_merge($query, ['offset' => ($page - 1) * $limit, 'limit' => $limit]));
    }
}
