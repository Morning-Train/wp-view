<?php


namespace Morningtrain\WP\View;


use duncan3dc\Laravel\Blade;
use Morningtrain\WP\Core\Abstracts\AbstractSingleton;
use Morningtrain\WP\Core\Classes\FileSystem;
use Morningtrain\WP\Core\Traits\FileSystemTrait;
use Morningtrain\WP\View\Classes\BladeHelper;
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


    /**
     * Creates a new Blade instance with framework custom directives
     *
     * @param string $viewDir
     * @param string $viewsCacheDir
     * @return Blade
     */
    public function newBlade(string $viewDir, string $viewsCacheDir): Blade
    {
        $blade = new Blade($viewDir, $viewsCacheDir);
        BladeHelper::setup($blade);

        return $blade;
    }

    /** Sets the filesystem for this view. This MUST be called before use (wp-core automatically does this)
     * @param FileSystem $fileSystem
     */
    public function setFileSystem(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
        $this->blade = $this->newBlade($this->fileSystem->viewsDir(), $this->fileSystem->viewsCacheDir());
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
     * @throws MissingPackageException
     */
    public function getViewTemplateName(string $viewTemplateName): string
    {
        [$package, $viewname] = $this->extractPackageAndTemplateNameFromView($viewTemplateName);

        if (empty($package)) {
            return $viewname;
        }

        $project_view = implode('/', ['vendors', $package, $viewname]);
        $project_file = $this->fileSystem->viewsDir() . '/' . $project_view . '.blade.php';

        return file_exists($project_file) ? $project_view : $package."/".$viewname;
    }

    /** Get the Blade instance for View or package
     * Using this you can use other Blade methods such as Blade::directive()
     * @param ?string $package
     * @return Blade|null
     */
    public static function blade($package = null): ?Blade
    {
        $instance = static::getInstance();

        return $instance->blade;
    }

    public static function render(string $view, array $data = [], array $mergeData = []): string
    {
        $viewname = static::getInstance()->getViewTemplateName($view);

        return static::getInstance()->blade->render($viewname, $data, $mergeData);
    }

    public static function make($view, $data = [], $mergeData = []): \Illuminate\Contracts\View\View
    {
        $viewname = static::getInstance()->getViewTemplateName($view);

        return $blade->make($viewname, $data, $mergeData);
    }

    public function exists($view): bool
    {
        $viewname = static::getInstance()->getViewTemplateName($view);

        return $blade->exists(($viewname));
    }

}