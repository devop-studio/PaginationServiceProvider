# PaginationServiceProvider
---
 Simple pagination service for Silex Framework, with friendly template rendering
 
 # Requirements
 ---
 - php>=5.3.9
 - Silex ~1.0
 - dflydev/dflydev-doctrine-orm-service-provider ^2.0
  
# Installation
---
**Adding composer dependency**
`composer require development-x/pagination-service-provider && composer install --prefer-dist`

**Register new service**
```
<?php
new \Silex\Application;
$app = new Application();

...

$app->register(new \Pagination\PaginationServiceProvider(), array(
    'paginator.options' => array(
        'offset_pages' => 1,
        'items_per_page' => 10,
        'show_prev_next' => false
    )
));

...

return $app->run();
```

**Use it in your controller**
```
$query = $app['orm.em']->getEntityRepository('\App\Entity\Entity')->createQueryBuilder('e');

$paginator = $app['paginator']->pagination($query, array());

return $app['twig']->render('layout.twig', array('paginator' => $paginator));
```

**Render in template**
```
{% for item in paginator.items %}
    {# dump(item) #}
{% endfor %}

{% pagination(paginator) %}
```

# License
MIT, see LICENSE.

# TODO
- [ ] Adding PHPUnit tests
- [ ] Update README.md file with more informations and examples