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

### View directory

To set the main directory for views

```php
\Morningtrain\WP\View\View::setup(__DIR__ . "/resources/views");
```

### Render a view 

```php
echo \Morningtrain\WP\View\View::render('person',['name' => 'John','email' => 'john@doe.com']);
```

## Credits

- [Mathias Munk](https://github.com/mrmoeg)
- [Martin Schadegg Brønniche](https://github.com/mschadegg)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
