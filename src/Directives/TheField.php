<?php


namespace Morningtrain\WP\View\Directives;


class TheField extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $expression = null): string
    {
        if (!function_exists('the_field')) {
            return '';
        }

        return "<?php the_field('$expression'); ?>";
    }
}