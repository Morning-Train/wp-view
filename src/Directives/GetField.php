<?php


namespace Morningtrain\WP\View\Directives;


class GetField extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $expression = null): string
    {
        if (!function_exists('get_field')) {
            return '';
        }

        return "<?php get_field('$expression'); ?>";
    }
}