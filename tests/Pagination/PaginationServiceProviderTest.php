<?php

namespace Pagination\Tests;

use Silex\Application;

class PaginationServiceProviderTest extends \Silex\WebTestCase
{
    /* @var $app \Silex\Application */
    protected $app;

    public function setUp()
    {
        $this->app = new Application(['request' => new \Symfony\Component\HttpFoundation\Request()]);
    }

    public function testRegisterPaginationServiceProvider()
    {
        $this->app->register(new \Pagination\PaginationServiceProvider());
        $this->assertInstanceOf('\Pagination\Util\Paginator', $this->app['paginator']);
    }

    public function testPaginationServiceProviderDefaultOptions()
    {
        $this->app->register(new \Pagination\PaginationServiceProvider());
        $this->assertEquals('2', $this->app['paginator.options']['offset_page']);
        $this->assertEquals('10', $this->app['paginator.options']['items_per_page']);
        $this->assertTrue($this->app['paginator.options']['hide_prev_next']);
    }

    public function testPaginationServiceProviderCustomSettings()
    {
        $this->app->register(new \Pagination\PaginationServiceProvider(), [
            'paginator.options' => [
                'offset_page'    => 1,
                'items_per_page' => 50,
                'hide_prev_next' => false,
            ],
        ]);
        $this->assertEquals('1', $this->app['paginator.options']['offset_page']);
        $this->assertEquals('50', $this->app['paginator.options']['items_per_page']);
        $this->assertFalse($this->app['paginator.options']['hide_prev_next']);
    }

    public function testPaginationServiceProviderArrayPagination()
    {
        $this->app->register(new \Pagination\PaginationServiceProvider(), [
            'paginator.options' => [
                'offset_page'    => 1,
                'items_per_page' => 10,
                'hide_prev_next' => true,
            ],
        ]);

        // generate random elements
        $items = [];
        foreach (range(1, 100) as $num) {
            $items[] = ['num' => $num];
        }

        $this->app->get('/{page}', function ($page) {
            echo $page;
        })->bind('pagination')->value('page', 1);

        // create fake request
        $this->app['request'] = \Symfony\Component\HttpFoundation\Request::create('/2', 'GET', ['_route' => 'pagination']);

        $paginator = $this->app['paginator']->pagination($items);

        $this->assertEquals(1, $paginator['current']);
        $this->assertCount(10, $paginator['items']);
        $this->assertEquals(100, $paginator['total']);
        $this->assertEquals(10, $paginator['total_page']);
    }

    public function testPaginationServiceProviderUnknownAdapterException()
    {
        $this->app->register(new \Pagination\PaginationServiceProvider());

        try {
            $this->app['paginator']->pagination(false);
        } catch (\Pagination\Exception\UnknownAdapterException $ex) {
            $this->assertInstanceOf('\Pagination\Exception\UnknownAdapterException', $ex);
        }
    }

    public function createApplication()
    {
        $this->app = new Application(['request' => new \Symfony\Component\HttpFoundation\Request()]);
    }
}
