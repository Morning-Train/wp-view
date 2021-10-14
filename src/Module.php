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

    public function init()
    {
        parent::init();

        if($this->context !== null && is_a($this->context,AbstractProject::class)){
            $this->registerContextAsDefaultViewNamespace();
        }
    }

    public function registerContextAsDefaultViewNamespace()
    {
        $dir = $this->context->getBaseDir().$this->context->getNamedDir('views');
        View::getInstance()->newBlade($dir, trailingslashit($dir) . "_cache");
        View::loadViewsFrom($dir);
    }

}