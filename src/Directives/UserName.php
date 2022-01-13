<?php


namespace Morningtrain\WP\View\Directives;


class UserName extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $expression = null): string
    {
        if (!is_user_logged_in()) {
            return '';
        }

        return "<?php echo wp_get_current_user()->display_name; ?>";
    }
}