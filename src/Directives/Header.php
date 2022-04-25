<?php

    namespace Morningtrain\WP\View\Directives;

    use Morningtrain\WP\View\Module;

    class Header extends \Morningtrain\WP\View\Abstracts\AbstractDirective
    {
        /**
         * Render the header template
         *
         * @see get_header
         * @param string|null $name
         *
         * @return string
         */
        public function handle(?string $name = ''): string
        {
            $action = empty($name) ? "\do_action('get_header');" : "\do_action('get_header', '$name');";
            $view = empty($name) ? "header" : "header-{$name}";
            $code = <<<EOT
<?php
    $action
    echo Morningtrain\WP\View\View::render('$view');
?>
EOT;

            return $code;
        }
    }