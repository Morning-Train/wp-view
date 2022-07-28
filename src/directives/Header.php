<?php

    use Morningtrain\WP\View\Blade\Blade;

    Blade::directive(
        'header',
        fn(string $expression) => "<?php mtvd_header({$expression}); ?>"
    );

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
    function mtvd_header(?string $name = null, array $args = [])
    {
        do_action('get_header', $name, $args);
        echo Morningtrain\WP\View\View::render($name === null ? 'header' : 'header-' . $name);
    }