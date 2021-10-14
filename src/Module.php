<?php


namespace Morningtrain\WP\View;


use Morningtrain\WP\Core\Abstracts\AbstractModule;
use Morningtrain\WP\Core\Abstracts\AbstractProject;

/**
 * Class View
 * @package Morningtrain\WP\View
 *
 * @property AbstractProject $project_context
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

        if ($this->hasProjectContext()) {
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
        $dir = $this->project_context->getBaseDir() . $this->project_context->getNamedDir('views');
        View::getInstance()->newBlade($dir, trailingslashit($dir) . "_cache");
        View::loadViewsFrom($dir);
    }

}