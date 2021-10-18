<?php


namespace Morningtrain\WP\View\Directives;


class Script extends \Morningtrain\WP\View\Abstracts\AbstractDirective
{
    public function handle(?string $script_handle = null): string
    {
        return "<?php wp_enqueue_script('$script_handle'); ?>";
    }
}