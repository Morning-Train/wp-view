<?php

    namespace Morningtrain\WP\View\Directives;

    use Morningtrain\WP\View\Module;

    class Footer extends \Morningtrain\WP\View\Abstracts\AbstractDirective
    {
        public function handle(?string $name = ''): string
        {
            $action = empty($name) ? "\do_action('get_footer');" : "\do_action('get_footer', '$name');";
            $view = empty($name) ? "footer" : "footer-{$name}";
            $code = <<<EOT
<?php
    $action
    echo Morningtrain\WP\View\View::render('$view');
?>
EOT;

            return $code;
        }
    }