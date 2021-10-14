<?php


namespace Morningtrain\WP\View;


use Morningtrain\WP\Core\Abstracts\AbstractModule;
use Morningtrain\WP\Core\Abstracts\AbstractProject;

/**
 * Class View
 * @package Morningtrain\WP\View
 *
 * @property AbstractProject $context
 */
class Module extends AbstractModule
{

    /**
     * Initializes the module
     *
     * @throws \ReflectionException
     */
    public function init()
    {
        parent::init();

        if ($this->context !== null && is_a($this->context, AbstractProject::class)) {
            $this->registerContextAsDefaultViewNamespace();
        }
        // TODO: Implement solution for uses where no context is present
    }

    /**
     * Sets the module context as the default namespace for views
     *
     * @throws \ReflectionException
     */
    public function registerContextAsDefaultViewNamespace()
    {
        $dir = $this->context->getBaseDir() . $this->context->getNamedDir('views');
        View::getInstance()->newBlade($dir, trailingslashit($dir) . "_cache");
        View::loadViewsFrom($dir);
    }

}