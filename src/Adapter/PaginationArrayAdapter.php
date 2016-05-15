<?php

namespace Pagination\Adapter;

use Pagination\Interfaces\IAdapterInterface;

class PaginationArrayAdapter implements IAdapterInterface
{

    public function getCounter($query)
    {
        return count($query);
    }

    public function getItems($query, $current, $limit)
    {
        return array_slice($query, $current * $limit - $limit, $limit);
    }

}
