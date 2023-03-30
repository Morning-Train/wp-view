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
    - [View directory](#view-directory)
    - [Render a view](#render-a-view)
    - [Working with namespaces](#working-with-namespaces)
        - [Registering a namespace](#registering-a-namespace)
        - [Using a namespace](#using-a-namespace)
    - [Custom @directives](#custom-directives)
        - [@wpauth()](#wpauth)
        - [@header()](#header)
        - [@footer()](#footer)
        - [@script()](#script)
        - [@style()](#style)
        - [@username()](#username)
        - [@cache()](#cache)
        - [@react()](#react)
- [Credits](#credits)
- [License](#license)

# Introduction

## Getting Started

To get started install the package as described below in [Installation](#installation).

To use the tool have a look at [Usage](#usage)

### Installation

Install with composer

```bash
composer require morningtrain/wp-view
```

## Dependencies

### illuminate/view

[illuminate/view](https://github.com/illuminate/view)

### morningtrain/php-loader

[PHP Loader](https://github.com/Morning-Train/php-loader) is used to load and initialize all Hooks

## Usage

For an overview see the [official Laravel documentation](https://laravel.com/docs/views)

### View directory

To set the main directory for views

```php
\Morningtrain\WP\View\View::setup(__DIR__ . "/resources/views");
```

### Render a view

```php
echo \Morningtrain\WP\View\View::render('person',['name' => 'John','email' => 'john@doe.com']);
```

### Working with namespaces

You may register a namespaced for a set of views. This is especially useful when writing plugins as you may group all
your plugin views and not worry about duplicate naming. Views in a namespace may be overwritten in the main namespace as
long as you use `first()` instead of `render()`.

Eg. `View::first(['vendor/myPlugin/myview','myPlugin::myview])` will render from the vendor dir first if the view
exists, thereby allowing theme authors to overwrite this view when necessary.

#### Registering a namespace

```php
echo \Morningtrain\WP\View\View::addNamespace('myPlugin', __DIR__ . "/resources/views");
```

#### Using a namespace

```php
echo \Morningtrain\WP\View\View::render('myPlugin::person',['name' => 'John','email' => 'john@doe.com']);
```

### Custom @directives

This package contains some custom [blade directives](https://laravel.com/docs/blade#blade-directives) that you may use:

#### @wpauth()

```php

<div>
  @wpauth()
    Hello @username!
  @else
    <a>Login</a>
  @endwpauth
</div>
```

#### @header()

Acts the same as : https://developer.wordpress.org/reference/functions/get_header/

The following will render the `header.blade.php` view or `header-small.blade.php`

```php
@header()
@header('small')
```

#### @footer()

Acts the same as : https://developer.wordpress.org/reference/functions/get_footer/

The following will render the `footer.blade.php` view or `footer-dark.blade.php`

```php
@footer()
@footer('dark')
```

#### @script()

An easy way to enqueue an already registered script.

Using this directive is the same as calling `wp_enqueue_script()` with only the handle.

```php
@script('swiper')
<section id="my-cool-slider">
  ...
</section>
```

#### @style()

An easy way to enqueue an already registered stylesheet.

Using this directive is the same as calling `wp_enqueue_style()` with only the handle.

```php
@style('employees')
<section id="employees" class="employees list">
  ...
</section>
```

#### @username()

Prints the username of the currently logged in user or an empty string if no one is logged in.

#### @cache()

Caches content in a transient and uses the cached data if it exists

```php
<div>
    <h3>Cache test for post: {!! $postId !!}</h3>
    @if(!empty($postId))
        @cache("post_card_{$postId}")
        <aside @class(['post-card', "post-card__".get_post_type($postId)])>
            <h3>{!! get_the_title($postId) !!}</h3>
            <p>{{ get_the_excerpt($postId) }}</p>
            <span>Yes</span>
            <a href="{!! get_permalink($postId) !!}">{{__('Read more','domain')}}</a>
        </aside>
        @endcache
    @else
        <p>{{__('This is not a post','domain')}}</p>
    @endif
</div>

```

#### @react()

Prints a Morningtrain ReactRenderer compatible element with optional props. This makes it easy to prepare components for
react to handle in the client.

```php
@react('myComponent', [
'someData' => 'someValue'
])
```

The @react directive also supports a child view that will be rendered inside the component-wrapper until the react
component is rendered. This is especially useful for skeletons and to avoid popping ins.

```php
@react('myComponent', [
'someData' => 'someValue'
],
'my-skeleton-view'),
['skeletonProp' => 'skeletonValue']
```

## Credits

- [Mathias Munk](https://github.com/mrmoeg)
- [Martin Schadegg Brønniche](https://github.com/mschadegg)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
