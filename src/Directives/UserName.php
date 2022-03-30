<?php


    namespace Morningtrain\WP\View\Directives;


    class UserName extends \Morningtrain\WP\View\Abstracts\AbstractDirective
    {
        public function handle(?string $expression = null): string
        {
            return "<?php echo is_user_logged_in() ? wp_get_current_user()->display_name : '';  ?>";
        }
    }