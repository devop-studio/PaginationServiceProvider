<?php

namespace Pagination\Util;

use Silex\Application;
use Symfony\Component\Routing\Router;
use Symfony\Component\HttpFoundation\Request;

class Paginator
{

    /**
     *
     * @var Application $app
     */
    private $app;

    /**
     *
     * @var Router $router
     */
    private $router;

    /**
     *
     * @var Request $request
     */
    private $request;

    /**
     *
     * @var array $options
     */
    private $options;

    /**
     * 
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->router = $app['url_generator'];
        $this->request = $app['request'];
    }

    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $query
     * @param array $options
     * 
     * @return array
     * 
     * @throws \Pagination\Exception\UnknownAdapterException
     */
    public function pagination($query, $options = array())
    {

        $this->options = array_replace($this->app['paginator.options'], $options);

        switch (true) {
            case $query instanceof \Doctrine\ORM\QueryBuilder :
                $adapter = new \Pagination\Adapter\PaginationORMAdapter();
                break;
            case is_array($query) :
                $adapter = new \Pagination\Adapter\PaginationArrayAdapter();
                break;
            default :
                throw new \Pagination\Exception\UnknownAdapterException();
        }

        $current = $this->request->get('page', 1);
        $counter = $adapter->getCounter($query);

        $items = ceil($counter/$this->options['items_per_page']);
        
        return array(
            'first' => $this->createPage(1),
            'prev' => $current > 1 ? $this->createPage($current - 1) : null,
            'current' => $current,
            'items' => $adapter->getItems($query, $current, $this->options['items_per_page']),
            'pages' => $this->getPages($current, $items),
            'next' => $current < $items ? $this->createPage($current + 1) : null,
            'last' => $this->createPage($items),
            'total' => $counter,
            'total_page' => $items,
            'options' => $this->options
        );
    }

    /**
     * 
     * @param integer $current
     * @param integer $items
     * 
     * @return array
     */
    public function getPages($current, $items)
    {
        
        $start = $current - $this->options['offset_page'] > 1 ? $current - $this->options['offset_page'] : 1;
        $end = $current + $this->options['offset_page'] < $items ? $current + $this->options['offset_page'] : $items;
        
        $pages = array();
        for ($i = $start; $i <= $end; $i++)
        {
            $pages[] = $this->createPage($i);
        }
        if ($start > 1) {
            $end_min = 1 + $this->options['offset_page'] >= $start ? $start - 1 : 1 + $this->options['offset_page'];
            if ($start - $end_min > 1) {
                array_unshift($pages, null);
            }
            for ($i = $end_min; $i >= 1; $i--)
            {
                array_unshift($pages, $this->createPage($i));
            }
        }
        if ($items - $end >= 1) {
            if ($items - $this->options['offset_page'] > $end + 1) {
                $pages[] = null;
            }
            $end_max = $items - $this->options['offset_page'] <= $end ? $end + 1 : $items - $this->options['offset_page'];
            for ($i = $end_max; $i <= $items; $i++)
            {
                $pages[] = $this->createPage($i);
            }
        }
        
        return $pages;
    }

    /**
     * 
     * @param integer $page
     * 
     * @return array
     */
    public function createPage($page)
    {
        return array(
            'page' => $page,
            'url' => $this->router->generate($this->request->get('_route'), array_merge(
                $this->request->query->all(),
                $this->request->get('_route_params'),
                array('page' => $page)
            ))
        );
    }

}
