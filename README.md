# Views

This package adds Laravel Blade to WordPress.

You can use `Morningtrain\WP\View\View` the same way as you would use the View class in Laravel.

To render a view in a non-blade context use the View::render method.

```php
    View::setup(__DIR__ . '/resources/views', __DIR__ . '/resources/views/_cache');
// or 
    View::setup(__DIR__ . '/resources/views'); // Since cache default to /_cache relative to the views dir
```

```php
// In Controller, Hook or WordPress template file
use Morningtrain\WP\View\View;
// This will render the person view with the variable $name set as "John Edward"
// Views must be placed in the /views directory. To render a view from a sub directory to /view simply use the full path: eg. pages/contact
echo View::render('person',['name' => 'John Edward']);
```

```html
<!-- Views/person.blade.php -->
<aside class="person">
    {{ $name }}
</aside>
```

## Directives

We support basic Blade directives.

### Auth

Checks current user capabilities Note: that @auth uses is_user_logged_in and current_use_can()

```html
@auth
<p>User is logged in</p>
@else
<p>User is NOT logged in</p>
@endauth
```

@auth takes an optional param. If set current user MUST have this capability.

```html
@auth('administrator')
<p>Hello Admin!</p>
@endauth
```

### @react

Outputs markup ready for react initialization using our React Renderer

```html
@react('MyComponent', ['someProp' => 'some value'])
// Will return:
<div data-react-class="MyComponent" data-react-props='{"someProp": "some value"}'></div>
```

### @username

```html
@auth
<p>Hej <strong>@username</strong></p>
@else
<a href="{!! wp_login_url() !!}">Log ind</a>
@endauth
```

### @header & @footer

Loads the header or footer view from /views.

Same as WordPress inbuilt [get_header()](https://developer.wordpress.org/reference/functions/get_header/)
and [get_footer()](https://developer.wordpress.org/reference/functions/get_footer/)

```html
@header
// @header(small) for loading views/header-small.blade.php in views
<main>
    ... some content here
</main>
@footer
```

### @get_field

```html
<p>Phone: @get_field(phone_number)</p>
```

## View Composers

You can use view [composing](https://laravel.com/docs/9.x/views#view-composers)!!
It is recommended that you do this in a Hook using init on a lower priority than 10.

```php
\Morningtrain\WP\View\View::composer('footer',function ($view){
                $view->with('menu_items', [
                    'Home'=> home_url(),
                    'Kontakt'=> '/kontakt',
                ]);
            });
```

## Namespacing

```php
// Render a view called view from the foo namespace
echo \Morningtrain\WP\View\View::render('foo::view')
@include('foo::view')
```

```php
// Add a namespace
\Morningtrain\WP\View\View::addNamespace('foo',__DIR__ . '/views');
```

```php
// Render a namespaced view, but prioritize the project vendor directory 
// This is useful when creating a standalone block in a package or a module of sorts
// This tells blade to render the first view it finds. So if the view in vendor exists it will be used
echo \Morningtrain\WP\View\View::first('vendor/foo/view','foo::view');
```