<?php

namespace Pagination\Twig;

class TwigExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('pagination', array($this, 'pagination'), array(
                'is_safe' => array('html'),
                'needs_environment' => true
                    ))
        );
    }

    public function pagination(\Twig_Environment $twig, $paginator)
    {
        return $twig->render('pagination.html.twig', ['paginator' => $paginator]);
    }

    public function getName()
    {
        return "pagination_extension";
    }

}
