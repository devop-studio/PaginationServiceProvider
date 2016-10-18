<?php

namespace Pagination\Adapter;

use Doctrine\ORM\QueryBuilder;
use Pagination\Interfaces\IAdapterInterface;

class PaginationORMAdapter implements IAdapterInterface
{
    /**
     * @param QueryBuilder $query
     *
     * @return int
     */
    public function getCounter($query)
    {
        $clone = clone $query;

        return $clone->select('count('.$clone->getRootAliases()[0].')')->getQuery()->getSingleScalarResult();
    }

    /**
     * @param QueryBuilder $query
     * @param int          $start
     * @param int          $end
     *
     * @return QueryBuilder
     */
    public function getItems($query, $current, $limit)
    {
        $start = $current * $limit - $limit;

        return $query->setFirstResult($start)->setMaxResults($limit)->getQuery()->getResult();
    }
}
