<?php


namespace Morningtrain\WP\View;


use Illuminate\View\Compilers\BladeCompiler;
use Morningtrain\WP\Core\Abstracts\AbstractSingleton;
use Morningtrain\WP\Core\Classes\FileSystem;
use Morningtrain\WP\Core\Traits\FileSystemTrait;
use Jenssegers\Blade\Blade;
use Morningtrain\WP\View\Exceptions\MissingPackageException;

/**
 * Class View
 * @package Morningtrain\WP\View
 */
class View extends AbstractSingleton
{
    use FileSystemTrait;

    private FileSystem $fileSystem;
    private Blade $blade;
    private array $packages = [];

    /** Sets the filesystem for this view. This MUST be called before use (wp-core automatically does this)
     * @param FileSystem $fileSystem
     */
    public function setFileSystem(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
        $this->blade = new Blade($this->viewsDir(), $this->viewsCacheDir());
    }

    /** Tells the View class where to look for templates in a package and registers this package for use with its own Blade instance.
     * You MUST call this early in your package setup!
     * @param string $dir The full path to the Views directory in the package
     * @param string $package The name of your package eg. wp-package
     * @return bool false if $dir is not a dir
     */
    public static function loadViewsFrom(string $dir, string $package): bool
    {
        if (!is_dir($dir)) {
            return false;
        }
        static::getInstance()->packages[$package] = new Blade($dir, $dir . '/Cache');
        return true;
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
     * @param string $viewTemplateName the full name of the template eg. 'template' or 'package::template'
     * @return string
     * @throws \MissingPackageException
     */
    public function getViewTemplateName(string $viewTemplateName): string
    {
        [$package, $viewname] = $this->extractPackageAndTemplateNameFromView($viewTemplateName);

        if (empty($package) || !key_exists($package, $this->packages)) {
            throw new MissingPackageException('No such package as "' . $package . '" registered in View');
        }

        $project_view = implode('/', ['vendors', $package, $viewname]);
        $project_file = $this->fileSystem->viewsDir() . '/' . $project_view . '.blade.php';
        return file_exists($project_file) ? $project_view : $viewname;
    }

    /** Returns the Blade instance by view template name. Project Blade if template exists in project else the package Blade
     * @param string $viewTemplateName the full name of the template eg. 'template' or 'package::template'
     * @return string
     * @throws \MissingPackageException
     */
    public function getViewTemplateBlade($viewTemplateName): Blade
    {
        $default_blade = $this->blade;
        [$package, $viewname] = $this->extractPackageAndTemplateNameFromView($viewTemplateName);

        if (empty($package) || !key_exists($package, $this->packages)) {
            throw new MissingPackageException('No such package as "' . $package . '" registered in View');
        }

        if (!key_exists($package, $this->packages)) {
            return $default_blade; // TODO: Throw
        }

        $project_view = implode('/', ['vendors', $package, $viewname]);
        $project_file = $this->fileSystem->viewsDir() . '/' . $project_view . '.blade.php';

        return file_exists($project_file) ? $default_blade : $this->packages[$package];
    }

    /** Get the Blade instance for View or package
     * Using this you can use other Blade methods such as Blade::directive()
     * @param ?string $package
     * @return Blade|null
     */
    public static function blade($package = NULL) : ?Blade
    {
        $instance = static::getInstance();
        if($package === NULL) return $instance->blade;
        if(key_exists($package,$instance->packages)) return $instance->packages[$package];
        return NULL;
    }

    public static function render(string $view, array $data = [], array $mergeData = []): string
    {
        $viewname = static::getInstance()->getViewTemplateName($view);
        $blade = static::getInstance()->getViewTemplateBlade($view);
        return $blade->render($viewname, $data, $mergeData);
    }

    public static function make($view, $data = [], $mergeData = []): View
    {
        $viewname = static::getInstance()->getViewTemplateName($view);
        $blade = static::getInstance()->getViewTemplateBlade($view);
        return $blade->make($view, $data, $mergeData);
    }

    public function exists($view): bool
    {
        $viewname = static::getInstance()->getViewTemplateName($view);
        $blade = static::getInstance()->getViewTemplateBlade($view);
        return $blade->exists(($view));
    }

}