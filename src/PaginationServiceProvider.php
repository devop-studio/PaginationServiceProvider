<?php

namespace Pagination;

use Pimple\Container;
use Silex\Application;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Translation\Translator;

class PaginationServiceProvider implements ServiceProviderInterface
{

    public function register(Container $app)
    {

        $app['paginator.options'] = array(
            'offset_page' => 2,
            'page_param' => 'page',
            'items_per_page' => 10,
            'hide_prev_next' => true
        );

        $app['paginator'] = $app->factory(function($app) {

            $app['paginator.options'] = array_replace(array(
                'offset_page' => 2,
                'page_param' => 'page',
                'items_per_page' => 10,
                'hide_prev_next' => true
                    ), $app['paginator.options']);

            return new \Pagination\Util\Paginator($app);
        });

        if (!$app->offsetExists('twig')) {
            $app->register(new \Silex\Provider\TwigServiceProvider());
        }
        
        if (!$app->offsetExists('translator')) {
            $app->register(new \Silex\Provider\TranslationServiceProvider());
        }

        $app['twig'] = $app->extend('twig', function(\Twig_Environment $twig) {
            $twig->addExtension(new Twig\TwigExtension());
            return $twig;
        });

        $app['twig.path'] = array_merge_recursive($app['twig.path'], array(
            __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'views'
        ));

        $app['translator'] = $app->extend('translator', function(Translator $translator, Application $app) {
            $translationDirectory = __DIR__ . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'translations';
            $translator->addResource('yaml', $translationDirectory . DIRECTORY_SEPARATOR . 'messages.bg.yml', 'bg');
            $translator->addResource('yaml', $translationDirectory . DIRECTORY_SEPARATOR . 'messages.en.yml', 'en');
            return $translator;
        });
    }

}
