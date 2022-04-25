<?php


    namespace Morningtrain\WP\View\Directives;


    use Morningtrain\WP\View\Classes\ReactComponent;

    class React extends \Morningtrain\WP\View\Abstracts\AbstractDirective
    {
        public function parseExpression(?string $expression = null): array
        {
            if (str_contains($expression, ',')) {
                list($component, $props) = explode(',', $expression, 2);
            } else {
                $component = $expression;
                $props = [];
            }
            $component = trim($component, "\"' ");
            if (!empty($props)) {
                eval("\$props = " . $props . ";");
            }

            return [$component, $props];
        }

        /**
         * React Component
         * Using this directive will make it easy to initialize top-level components with our React Renderer
         *
         * @param string $component
         * @param array $props
         *
         * @return string
         */
        public function handle(string $component, array $props = []): string
        {
            return ReactComponent::render($component, $props);
        }
    }