Pagination Service Provider
=============================

Provides tricky pagination for Silex Framework


Features
--------

 * Adding DoctrineORM and sample Array adapter.
 * Customized templates
 * Adding more adapters, if you wanna


Requirements
------------

 * PHP 5.3+
 * Pimple ~2.1
 * Doctrine ~2.3

Installation
------------
Install with [Composer](http://packagist.org), run:

```sh
composer require millennium/phpcache
```

### Register first
```php
<?php

use Silex\Application;

$app->register(new \Pagination\PaginationServiceProvider())

```

### Example usage

```php
<?php
$query = $this->app->getEntityManager()->getRepository('App\Entity\User')
                ->createQueryBuilder('u');

$paginator = $this->app->getPaginator()->pagination($query);

return $this->app->getTwig()->render('modules/pagination-service-provider.html.twig', ['paginator' => $paginator]);
```

```
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Created At</th>
        </tr>
        {% for user in paginator.items %}
        <tr>
            <td>{{ loop.index }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.createdAt|date('d.m.Y H:i:s') }}</td>
        </tr>
        {% endfor %}
    </table>
</div>
<div class="text-center">{{ pagination(paginator) }}</div>
  ```
=======
Pagination Service Provider
=============================

Provides tricky pagination for Silex Framework


Features
--------

 * Adding DoctrineORM and sample Array adapter.
 * Customized templates
 * Adding more adapters, if you wanna


Requirements
------------

 * PHP 5.3+
 * Pimple ~2.1
 * Doctrine ~2.3

Installation
------------
Install with [Composer](http://packagist.org), run:

```sh
composer require millennium/phpcache
```

### Register first
```php
<?php

use Silex\Application;

$app->register(new \Pagination\PaginationServiceProvider())

```

### Example usage

```php
<?php
$query = $this->app->getEntityManager()->getRepository('App\Entity\User')
                ->createQueryBuilder('u');

$paginator = $this->app->getPaginator()->pagination($query);

return $this->app->getTwig()->render('modules/pagination-service-provider.html.twig', ['paginator' => $paginator]);
```

```
<div class="table-responsive">
    <table class="table">
        <tr>
            <th>#</th>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Created At</th>
        </tr>
        {% for user in paginator.items %}
        <tr>
            <td>{{ loop.index }}</td>
            <td>{{ user.username }}</td>
            <td>{{ user.email }}</td>
            <td>{{ user.name }}</td>
            <td>{{ user.createdAt|date('d.m.Y H:i:s') }}</td>
        </tr>
        {% endfor %}
    </table>
</div>
<div class="text-center">{{ pagination(paginator) }}</div>
  ```
