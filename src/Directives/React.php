<?php


    namespace Morningtrain\WP\View\Directives;


    class React extends \Morningtrain\WP\View\Abstracts\AbstractDirective
    {
        public function parseExpression(?string $expression = null): array
        {
            if (str_contains($expression, ',')) {
                list($component, $props) = explode(',', $expression, 2);
            } else {
                $component = trim($expression, "\"' ");
                $props = null;
            }
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
         * @param array|null $props
         *
         * @return string
         */
        public function handle(string $component, ?array $props = null): string
        {
            $props = $props === null ? '' : "data-react-props='" . json_encode($props) . "'";
            return "<div data-react-class=\"$component\" $props></div>";
        }
    }