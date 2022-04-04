<?php


namespace Morningtrain\WP\View\Classes;


use Morningtrain\WP\View\Blade\Blade;
use Morningtrain\WP\Core\Classes\ClassLoader;
use Morningtrain\WP\View\Abstracts\AbstractDirective;
use Morningtrain\WP\View\View;
use Symfony\Component\Finder\Finder;

class BladeHelper
{
    /**
     * Sets up a Blade instance
     *
     */
    public static function setup()
    {
        static::loadDirectives();
    }

    /**
     * Adds the Post Loop directive to a Blade instance
     *
     * @param Blade $blade
     */
    public static function addPostLoopDirective(Blade &$blade)
    {
        $blade->directive(
            'theLoop',
            function ($expression) {
                return View::make('wp-core::theloop', ['template' => $expression]);
            }
        );
    }


    /**
     * Loads and registers all standard Directives
     */
    public static function loadDirectives()
    {
        $finder = new Finder();
        $finder->files()->name('*.php')->in(dirname(__DIR__) . "/Directives");

        if (!$finder->hasResults()) {
            return;
        }

        $directive_files = [];
        foreach ($finder as $file) {
            $directive_files[] = $file->getRealPath();
        }

        ClassLoader::requireAndCall($directive_files,'register', null, AbstractDirective::class);
    }
}