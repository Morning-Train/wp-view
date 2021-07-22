# Views

```php
// In Controller or Hook
use Morningtrain\WP\View\View;

echo View::render('person',['name' => 'John Edward']);
```

```html
// Views/person.blade.php
<aside class="person">
    {{ $name }}
</aside>
```