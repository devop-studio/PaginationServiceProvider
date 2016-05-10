<?php

namespace Pagination\Tests;

class PaginationServiceProviderTest extends \PHPUnit_Framework_TestCase 
{

    public function testRegisterPaginationServiceProvider() 
    {
        // register Silex application
        $this->app = new \Silex\Application;
        // enable debug
        $this->app["debug"] = false;
        // register url_generator service provider
        $this->app->register(new \Silex\Provider\UrlGeneratorServiceProvider());
        // register paginator service provider
        $this->app->register(new \Pagination\PaginationServiceProvider());
        // assert true exception
        $this->assertTrue('Pagination\Util\Paginator', $this->app['paginator']);
        // return applicatio instance
        return $this->app;
    }

}
