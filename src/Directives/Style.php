<?php


namespace Morningtrain\WP\View\Directives;


class Style extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $style_handle = null): string
    {
        return "<?php wp_enqueue_style('$style_handle'); ?>";
    }
}