<?php


namespace Morningtrain\WP\View;


use duncan3dc\Laravel\Blade;
use duncan3dc\Laravel\BladeInterface;
use Morningtrain\WP\Core\Abstracts\AbstractSingleton;
use Morningtrain\WP\View\Classes\BladeHelper;
use Morningtrain\WP\View\Exceptions\MissingPackageException;

/**
 * Class View
 * @package Morningtrain\WP\View
 */
class View extends AbstractSingleton
{
    private Blade $blade;
    private ?string $base_dir = null;
    private ?string $cache_dir = null;


    /**
     * Creates a new Blade instance with framework custom directives
     *
     * @param string $viewDir
     * @param string $viewsCacheDir
     * @return Blade
     */
    public function newBlade(string $viewDir, string $viewsCacheDir): Blade
    {
        $this->base_dir = $viewDir;
        $this->cache_dir = $viewsCacheDir;
        $blade = new Blade($this->base_dir, $this->cache_dir);
        BladeHelper::setup($blade);
        $this->blade = $blade;
        return $blade;
    }

    /** Adds another location for packages to reside
     * You MUST call this early in your package setup!
     * @param string $dir The full path to the Views directory in the package
     * @return bool false if $dir is not a dir
     */
    public static function loadViewsFrom(string $dir): bool
    {
        if (!is_dir($dir)) {
            return false;
        }

        static::getInstance()->blade->addPath($dir);
        return true;
    }

    public static function addNamespace(string $namespace, $hints): BladeInterface
    {
        return static::getInstance()->blade->addNamespace($namespace, $hints);
    }

    /** Extracts package string and template name for a template and returns this as [string|NULL $package, string $view]
     * @param string $viewTemplateName
     * @return array
     */
    public function extractPackageAndTemplateNameFromView(string $viewTemplateName): array
    {
        if (!strpos($viewTemplateName, '::')) {
            return [null, $viewTemplateName];
        }

        return explode('::', $viewTemplateName, 2);
    }

    /** Returns the full template name by view template name. Eg. package::template could return 'vendors/package/template' if there is a template in the current project
     *
     * @param string $viewTemplateName the full name of the template eg. 'template' or 'package::template'
     * @return string
     * @throws MissingPackageException
     */
    public function getViewTemplateName(string $viewTemplateName): string
    {
        [$package, $viewName] = $this->extractPackageAndTemplateNameFromView($viewTemplateName);

        // If view name does not contain a namespace then use it as it is.
        if (empty($package)) {
            return $viewTemplateName;
        }

        // The view name if it would exist in project
        $project_view = implode('/', ['vendors', $package, $viewName]);
        // The full view file path if it would exist in project
        $project_file = trailingslashit($this->base_dir) . $project_view . '.blade.php';

        // If view file exists in project then return this view. If not then use view as is
        return file_exists($project_file) ? $project_view : $viewTemplateName;
    }

    /** Get the Blade instance for View
     *
     * @return Blade|null
     */
    public static function blade(): ?Blade
    {
        $instance = static::getInstance();

        return $instance->blade;
    }

    public static function render(string $view, array $data = []): string
    {
        $viewName = static::getInstance()->getViewTemplateName($view);
        return static::getInstance()->blade->render($viewName, $data);
    }

    public static function make($view, $data = []): \Illuminate\Contracts\View\View
    {
        $viewName = static::getInstance()->getViewTemplateName($view);

        return static::getInstance()->blade->make($viewName, $data);
    }

    public function exists($view): bool
    {
        $viewName = static::getInstance()->getViewTemplateName($view);

        return static::getInstance()->blade->exists(($viewName));
    }

}