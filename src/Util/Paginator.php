<?php

namespace Pagination\Util;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var array
     */
    private $options;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param \Doctrine\ORM\QueryBuilder|array $query
     * @param array                      $options
     *
     * @throws \Pagination\Exception\UnknownAdapterException
     *
     * @return array
     */
    public function pagination($query, $options = [])
    {
        $this->options = array_replace($this->app['paginator.options'], $options);

        switch (true) {
            case $query instanceof \Doctrine\ORM\QueryBuilder:
                $adapter = new \Pagination\Adapter\PaginationORMAdapter();
                break;
            case is_array($query):
                $adapter = new \Pagination\Adapter\PaginationArrayAdapter();
                break;
            default:
                throw new \Pagination\Exception\UnknownAdapterException();
        }

        $current = 1;
        if ($this->app['request_stack']->getCurrentRequest()) {
            $current = $this->app['request_stack']->getCurrentRequest()->get('page', 1);
        }
        $counter = $adapter->getCounter($query);

        $items = ceil($counter / $this->options['items_per_page']);

        return [
            'first'      => 1,
            'prev'       => $current > 1 ? $current - 1 : null,
            'current'    => $current,
            'items'      => $adapter->getItems($query, $current, $this->options['items_per_page']),
            'pages'      => $this->getPages($current, $items),
            'next'       => $current < $items ? $current + 1 : null,
            'last'       => $items,
            'total'      => $counter,
            'total_page' => $items,
            'options'    => $this->options,
        ];
    }

    /**
     * @param int $current
     * @param int $items
     *
     * @return array
     */
    public function getPages($current, $items)
    {
        $start = $current - $this->options['offset_page'] > 1 ? $current - $this->options['offset_page'] : 1;
        $end = $current + $this->options['offset_page'] < $items ? $current + $this->options['offset_page'] : $items;

        $pages = [];
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }
        if ($start > 1) {
            $end_min = 1 + $this->options['offset_page'] >= $start ? $start - 1 : 1 + $this->options['offset_page'];
            if ($start - $end_min > 1) {
                array_unshift($pages, null);
            }
            for ($i = $end_min; $i >= 1; $i--) {
                array_unshift($pages, $i);
            }
        }
        if ($items - $end >= 1) {
            if ($items - $this->options['offset_page'] > $end + 1) {
                $pages[] = null;
            }
            $end_max = $items - $this->options['offset_page'] <= $end ? $end + 1 : $items - $this->options['offset_page'];
            for ($i = $end_max; $i <= $items; $i++) {
                $pages[] = $i;
            }
        }

        return $pages;
    }
}
