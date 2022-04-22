<?php


    namespace Morningtrain\WP\View\Directives;


    class Auth extends \Morningtrain\WP\View\Abstracts\AbstractDirective
    {
        protected $method = "if";

        public function handle(?string $capability = null): string
        {
            return empty($capability) ? is_user_logged_in() : current_user_can($capability);
        }
    }