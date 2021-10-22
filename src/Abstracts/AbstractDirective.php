<?php


namespace Morningtrain\WP\View\Abstracts;


use Morningtrain\WP\View\View;

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
        $expression = trim($expression, '"\'');
        return $this->handle($expression);
    }

    public function handle(?string $expression = null): string
    {
        $directive = $this->getDirectiveName();
        return "Directive \"{$directive}\" is missing handle function.";
    }
}