<?php

namespace App\Helpers;

trait PaginationHelperTraits
{
    protected function getMeta(mixed $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'from' => $paginator->firstItem(),
            'last_page' => $paginator->lastPage(),
            'links' => $paginator->linkCollection(),
            'path' => $paginator->path(),
            'per_page' => $paginator->perPage(),
            'to' => $paginator->lastItem(),
            'total' => $paginator->total(),
            'has_pages' => $paginator->hasPages(),
            'has_more_pages' => $paginator->hasMorePages(),
        ];
    }

    protected function getLinks(mixed $paginator): array
    {
        return [
            'first' => $paginator->url(1),
            'last' => $paginator->url($paginator->lastPage()),
            'prev' => $paginator->previousPageUrl(),
            'next' => $paginator->nextPageUrl(),
        ];
    }

    protected function getMetaLinks(mixed $paginator): array
    {
        return [
            'links' => $this->getLinks($paginator),
            'meta' => $this->getMeta($paginator),
        ];
    }
}
