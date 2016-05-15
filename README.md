| SensioLabs Insight | Travis CI | Scrutinizer CI|
| ------------------------|-------------|-----------------|
|[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f6e15c47-013b-4c08-a301-683859b94b58/mini.png)](https://insight.sensiolabs.com/projects/f6e15c47-013b-4c08-a301-683859b94b58)|[![Build Status](https://travis-ci.org/development-x/PaginationServiceProvider.svg?branch=master)](https://travis-ci.org/development-x/PaginationServiceProvider)|[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/development-x/PaginationServiceProvider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/development-x/PaginationServiceProvider/?branch=master) [![Code Coverage](https://scrutinizer-ci.com/g/development-x/PaginationServiceProvider/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/development-x/PaginationServiceProvider/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/development-x/PaginationServiceProvider/badges/build.png?b=master)](https://scrutinizer-ci.com/g/development-x/PaginationServiceProvider/build-status/master)

[![Dependency Status](https://www.versioneye.com/user/projects/5738988ea0ca350034be7d2e/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5738988ea0ca350034be7d2e) [![Latest Stable Version](https://poser.pugx.org/development-x/pagination-service-provider/v/stable)](https://packagist.org/packages/development-x/pagination-service-provider) [![Total Downloads](https://poser.pugx.org/development-x/pagination-service-provider/downloads)](https://packagist.org/packages/development-x/pagination-service-provider) [![Latest Unstable Version](https://poser.pugx.org/development-x/pagination-service-provider/v/unstable)](https://packagist.org/packages/development-x/pagination-service-provider) [![License](https://poser.pugx.org/development-x/pagination-service-provider/license)](https://packagist.org/packages/development-x/pagination-service-provider)

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
