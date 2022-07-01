<?php

    use Morningtrain\WP\View\Blade\Blade;

    Blade::directive(
        'style',
        fn(string $expression) => "<?php mtvd_style({$expression}); ?>"
    );

    /**
     * Morningtrain View Directive
     * @ style is useful for enqueueing stylesheets that are already registered with WordPress
     *
     * @param string $handle
     */
    function mtvd_style(string $handle)
    {
        \wp_enqueue_style($handle);
    }
