<?php


    namespace Morningtrain\WP\View\Abstracts;


    use Morningtrain\WP\View\Classes\DirectiveHelper;
    use Morningtrain\WP\View\View;

    /**
     * @method handle
     */
    abstract class AbstractDirective
    {
        protected $method = "directive";


        public function register()
        {
            View::blade()->{$this->method}($this->getDirectiveName(), [$this, 'cleanupExpressionAndThenHandle']);
        }

        public function getDirectiveName(): string
        {
            $r = new \ReflectionClass($this);
            return mb_strtolower($r->getShortName());
        }

        public function cleanupExpressionAndThenHandle(?string $expression = null)
        {
            return $this->handle(...$this->parseExpression($expression));
        }

        public function parseExpression(?string $expression = null): array
        {
            return [trim($expression, '"\' ')];
        }
    }