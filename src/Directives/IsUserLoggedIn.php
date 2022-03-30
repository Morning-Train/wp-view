<?php


namespace Morningtrain\WP\View\Directives;


class IsUserLoggedIn extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    protected $method = "if";

    public function handle(?string $expression = null): string
    {
        return "<php is_user_logged_in() ?>";
    }
}