<?php


namespace Morningtrain\WP\View\Directives;


class TheField extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $expression = null): string
    {
        return "<?php the_field('$expression'); ?>";
    }
}