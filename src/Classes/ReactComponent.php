<?php

    namespace Morningtrain\WP\View\Classes;

    /**
     * Create a React components markup
     */
    class ReactComponent
    {
        private string $componentName;
        private array $props;
        private string $markup = '';
        private array $options;
        private string $innerHtml = '';

        /**
         * ReactComponent constructor.
         *
         * @param string $componentName
         * @param array $props
         * @param array $options
         */
        public function __construct(
            string $componentName,
            array $props = [],
            array $options = [],
            string $innerHtml = ''
        ) {
            $this->componentName = $componentName;
            $this->props = $props;
            $this->options = $options;
            $this->innerHtml = $innerHtml;
        }

        /**
         * @param string $componentName
         * @param array $props
         *
         * @param array $options
         *
         * @return static
         */
        public static function create(
            string $componentName,
            array $props = [],
            array $options = [],
            string $innerHtml = ''
        ): static {
            return new static($componentName, $props, $options, $innerHtml);
        }

        private function toHtml(): string
        {
            $options = array_merge([
                'tag' => 'div',
                'markup' => $this->markup,
                'class' => 'react-component'
            ], $this->options);

            $tag = $options['tag'];

            $props = htmlentities(json_encode($this->props, ENT_QUOTES));

            $attrs = $this->toHtmlAttributesString($options);

            return "<{$tag} data-react-class=\"{$this->componentName}\" data-react-props=\"$props\" $attrs>{$this->innerHtml}</$tag>";
        }

        protected function toHtmlAttributesString(array $attributes): string
        {
            $htmlAttributesString = '';

            foreach ($attributes as $attribute => $value) {
                if (in_array($attribute, ['tag', 'markup', 'class'])) {
                    continue;
                }

                $htmlAttributesString .= "{$attribute}='{$value}'";
            }

            return $htmlAttributesString;
        }

        public function props(array $props): static
        {
            $this->props = array_merge($this->props, $props);

            return $this;
        }

        public function options(array $options): static
        {
            $this->options = array_merge($this->options, $options);

            return $this;
        }

        public function innerHtml(string $html): static
        {
            $this->innerHtml = $html;

            return $this;
        }

        public function __destruct()
        {
            $this->toHtml();
        }

        public static function render(
            string $componentName,
            array $props = [],
            array $options = [],
            string $innerHtml = ''
        ): string {
            return self::create($componentName, $props, $options, $innerHtml)->toHtml();
        }
    }