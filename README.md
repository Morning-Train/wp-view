# Views

```php
// In Controller or Hook
use Morningtrain\WP\View\View;

echo View::render('person',['name' => 'John Edward']);
```

```html
<!-- Views/person.blade.php -->
<aside class="person">
    {{ $name }}
</aside>
```

## Packages
To use views in a package you must first register your package into View.
```php
// PackageClass.php
class PackageClass{
    public static function init(){
        View::loadViewsFrom(__DIR__ . "/Views",'my-package');
    } 
}
```

To use a template from a package, whether you are working in this package or in the project use:
```php
    View::render('my-package::person',['name' => 'Svante']);
```

If you need to use a custom template instead of the one the package introduces then you can simply add your own template in your project eg. `Views/vendors/my-package/person.blade.php`
