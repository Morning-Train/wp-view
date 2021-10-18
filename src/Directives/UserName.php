<?php


namespace Morningtrain\WP\View\Directives;


class UserName extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $expression = null): string
    {
        if(!is_user_logged_in()){
            return '';
        }

        $user = wp_get_current_user();

        return $user->display_name;
    }
}