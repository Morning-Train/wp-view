<?php

    use Morningtrain\WP\View\Blade\Blade;

    Blade::directive(
        'react',
        fn(string $expression) => "<?php mtvd_react({$expression}); ?>"
    );

    /**
     * Morningtrain View Directive
     * @ react is useful for preparing a DOM element for react.
     * This directive uses ReactComponent and works with ReactRenderer.js module
     *
     * @param string $component
     * @param array $props
     * @param array $options
     */
    function mtvd_react(string $component, $props = [], $options = [])
    {
        echo Morningtrain\WP\View\Classes\ReactComponent::render($component, $props, $options);
    }
