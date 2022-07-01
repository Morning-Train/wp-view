# Views

Laravel blade and view for WordPress with custom directives.

## Table of Contents

- [Introduction](#introduction)
- [Getting Started](#getting-started)
    - [Installation](#installation)
- [Dependencies](#dependencies)
    - [illuminate/view](https://github.com/illuminate/view)
    - [morningtrain/php-loader](#morningtrainphp-loader)
- [Usage](#usage)
- [Credits](#credits)
- [License](#license)

# Introduction

## Getting Started

To get started install the package as described below in [Installation](#installation).

To use the tool have a look at [Usage](#usage)

### Installation

Install with composer

```bash
composer require morningtrain/wp-route
```

## Dependencies

### illuminate/view

[illuminate/view](https://github.com/illuminate/view)

### morningtrain/php-loader

[PHP Loader](https://github.com/Morning-Train/php-loader) is used to load and initialize all Hooks

## Usage

### Registering a route

To register a route call the method on the Route class with the request type you want and supply a callback

```php
// Register a route on mysite.com/myroute that accepts GET requests
\Morningtrain\WP\Route\Route::get('/myroute',[MyRouteController::class,'view']);
// Same but for POST requests
\Morningtrain\WP\Route\Route::get('/myroute',[MyRouteController::class,'update']);
// A list of allowed request types
\Morningtrain\WP\Route\Route::match(['POST','PUT'],'/myroute',[MyRouteController::class,'update']);
// Any request type
\Morningtrain\WP\Route\Route::any('/myroute',MyRouteController::class);

```

### Naming a route

You can name a route so that you may identify it again later

```php
\Morningtrain\WP\Route\Route::get('/myroute',[MyRouteController::class,'view'])
    ->name('myroute');
```

### Getting current route

```php
$route = \Morningtrain\WP\Route\Route::current();
```

### Getting route URL

```php
$routeUrl = \Morningtrain\WP\Route\Route::route('myroute'); // site.com/myroute
```

## Credits

- [Mathias Munk](https://github.com/mrmoeg)
- [Martin Schadegg Brønniche](https://github.com/mschadegg)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
