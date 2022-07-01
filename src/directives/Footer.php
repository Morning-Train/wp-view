<?php

    use Morningtrain\WP\View\Blade\Blade;

    Blade::directive(
        'footer',
        fn(string $expression) => "<?php mtvd_footer({$expression}); ?>"
    );

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
    function mtvd_footer(?string $name = null, array $args = [])
    {
        do_action('get_footer', $name, $args);
        echo Morningtrain\WP\View\View::render($name === null ? 'footer' : 'footer-' . $name);
    }