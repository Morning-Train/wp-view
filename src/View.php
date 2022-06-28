<?php


    namespace Morningtrain\WP\View;


    use Morningtrain\PHPLoader\Loader;
    use Morningtrain\WP\View\Blade\Blade;
    use Morningtrain\WP\View\Blade\BladeInstance;
    use Morningtrain\WP\View\Blade\BladeInterface;
    use Morningtrain\WP\View\Classes\BladeHelper;
    use Morningtrain\WP\View\Exceptions\MissingPackageException;

    /**
     * Class View
     * @package Morningtrain\WP\View
     */
    class View
    {
        /**
         * The full path to the views directory
         * @var string|null $baseDir
         */
        private static ?string $baseDir = null;
        /**
         * The full path to the views cache directory
         * @var string|null $cacheDir
         */
        private static ?string $cacheDir = null;


        /**
         * Creates a new Blade instance with framework custom directives
         *
         * @param string $viewDir
         * @param string $viewsCacheDir
         */
        public static function setup(string $viewDir, string $viewsCacheDir)
        {
            static::$baseDir = $viewDir;
            static::$cacheDir = $viewsCacheDir;

            Blade::setInstance(new BladeInstance(static::$baseDir, static::$cacheDir));

            Loader::create(__DIR__ . '/directives');
        }

        /**
         * Register a namespace for blade
         *
         * @param string $namespace The namespace name. Eg. wp-package for accessing templates as "wp-package::template-name"
         * @param string $path The absolute path for the views directory for your namespace
         * @return BladeInterface
         */
        public static function addNamespace(string $namespace, string $path): BladeInterface
        {
            return Blade::addNamespace($namespace, $path);
        }

        /**
         * Get the Blade instance for View
         *
         * @return BladeInterface|null
         */
        public static function blade(): ?BladeInterface
        {
            return Blade::getInstance();
        }

        /**
         * Render (return) the template view
         *
         * @see https://laravel.com/docs/views#creating-and-rendering-views
         *
         * @param string $view
         * @param array $data
         *
         * @see https://laravel.com/docs/9.x/views#view-composers
         *
         * @return string
         */
        public static function render(string $view, array $data = []): string
        {
            return Blade::render($view, $data);
        }

        /**
         * Register a composer.
         *
         * @param string $key The name of the composer to register
         * @param mixed $value The closure or class to use
         *
         * @return array
         */
        public static function composer(string $key, $value): array
        {
            return Blade::composer($key, $value);
        }

        /**
         * Make the view instance.
         * You can use this for other views
         *
         * @see https://laravel.com/docs/views#creating-and-rendering-views
         *
         * @param string $view
         * @param array $data
         * @return \Illuminate\Contracts\View\View
         */
        public static function make(string $view, array $data = []): \Illuminate\Contracts\View\View
        {
            return Blade::make($view, $data);
        }

        /**
         * Determine if a given view exists
         *
         * @param string $view
         * @return bool
         */
        public static function exists(string $view): bool
        {
            return Blade::exists($view);
        }

    }