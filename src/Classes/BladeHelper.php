<?php


namespace Morningtrain\WP\View\Classes;


use duncan3dc\Laravel\Blade;
use Morningtrain\WP\View\View;

class BladeHelper
{
    /**
     * Sets up a Blade instance
     *
     * @param Blade $blade
     */
    public static function setup(Blade &$blade)
    {
        static::addDefaultDirectives($blade);
    }

    /**
     * Adds all default directives to a Blade instance
     *
     * @param Blade $blade
     */
    public static function addDefaultDirectives(Blade &$blade)
    {
        static::addPostLoopDirective($blade);
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
}