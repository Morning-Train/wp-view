<?php

    namespace Morningtrain\WP\View\Classes;

    use \Morningtrain\WP\View\Blade\Blade;

    class Directives
    {
        public static function register()
        {
            $class = static::class;
            Blade::if('auth', [static::class, 'auth']);
            Blade::directive('footer', fn(string $expression) => "<?php {$class}::footer({$expression}); ?>");
            Blade::directive('header', fn(string $expression) => "<?php {$class}::header({$expression}); ?>");
            Blade::directive('react', fn(string $expression) => "<?php {$class}::react({$expression}); ?>");
            Blade::directive('script', fn(string $expression) => "<?php {$class}::script({$expression}); ?>");
            Blade::directive('style', fn(string $expression) => "<?php {$class}::style({$expression}); ?>");
            Blade::directive('username', fn() => "<?php {$class}::username(); ?>");
        }

        /**
         * Morningtrain View Directive
         * @ auth is useful for making conditional views with user capabilities
         *
         * @see https://developer.wordpress.org/reference/functions/is_user_logged_in/
         * @see https://developer.wordpress.org/reference/functions/current_user_can/
         *
         * @param string|null $capability If supplied current user MUST have this capability else a simple is_user_logged_in() is used
         * @return bool
         */
        public static function auth(?string $capability = null): bool
        {
            return $capability === null ? \is_user_logged_in() : \current_user_can($capability);
        }

        /**
         * Morningtrain View Directive
         * Render a WordPress footer using Blade
         * Template must be located in the root of your views directory
         *
         * @see https://developer.wordpress.org/reference/functions/get_footer/
         *
         * @param string|null $name
         * @param array $args
         */
        public static function footer(?string $name = null, array $args = [])
        {
            \do_action('get_footer', $name, $args);
            echo \Morningtrain\WP\View\View::render($name === null ? 'footer' : 'footer-' . $name);
        }

        /**
         * Morningtrain View Directive
         * Render a WordPress header using Blade
         * Template must be located in the root of your views directory
         *
         * @see https://developer.wordpress.org/reference/functions/get_header/
         *
         * @param string|null $name
         * @param array $args
         */
        public static function header(?string $name = null, array $args = [])
        {
            \do_action('get_header', $name, $args);
            echo \Morningtrain\WP\View\View::render($name === null ? 'header' : 'header-' . $name);
        }

        /**
         * Morningtrain View Directive
         * @ react is useful for preparing a DOM element for react.
         * This directive uses ReactComponent and works with ReactRenderer.js module
         *
         * @param string $component
         * @param array $props
         * @param array $options
         */
        public static function react(string $component, $props = [], $options = [])
        {
            echo \Morningtrain\WP\View\Classes\ReactComponent::render($component, $props, $options);
        }

        /**
         * Morningtrain View Directive
         * @ script is useful for enqueueing scripts that are already registered with WordPress
         *
         * @param string $handle
         */
        public static function script(string $handle)
        {
            \wp_enqueue_script($handle);
        }

        /**
         * Morningtrain View Directive
         * @ style is useful for enqueueing stylesheets that are already registered with WordPress
         *
         * @param string $handle
         */
        public static function style(string $handle)
        {
            \wp_enqueue_style($handle);
        }

        /**
         * Morningtrain View Directive
         * @ username is useful for rendering the current users display name
         */
        public static function username()
        {
            echo is_user_logged_in() ? wp_get_current_user()->display_name : '';
        }
    }
