<?php

    use Morningtrain\WP\View\Blade\Blade;

    Blade::directive(
        'script',
        fn(string $expression) => "<?php mtvd_script({$expression}); ?>"
    );

    /**
     * Morningtrain View Directive
     * @ script is useful for enqueueing scripts that are already registered with WordPress
     *
     * @param string $handle
     */
    function mtvd_script(string $handle)
    {
        \wp_enqueue_script($handle);
    }
