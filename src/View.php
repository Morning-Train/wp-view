<?php


namespace Morningtrain\WP\View;


use Morningtrain\WP\Core\Abstracts\AbstractSingleton;
use Morningtrain\WP\Core\Classes\FileSystem;
use Morningtrain\WP\Core\Traits\FileSystemTrait;
use Jenssegers\Blade\Blade;

class View extends AbstractSingleton
{
    use FileSystemTrait;

    private FileSystem $fileSystem;
    private Blade $blade;

    public function setFileSystem(FileSystem $fileSystem)
    {
        $this->fileSystem = $fileSystem;
        $this->blade = new Blade($this->viewsDir(), $this->viewsCacheDir());
    }

    public static function render(...$args)
    {
        return static::getInstance()->blade->render(...$args);
    }
    public static function make(...$args)
    {
        return static::getInstance()->blade->make(...$args);
    }
    public static function file(...$args)
    {
        return static::getInstance()->blade->file(...$args);
    }
    public static function addNamespace(...$args)
    {
        return static::getInstance()->blade->addNamespace(...$args);
    }
    public static function compiler(...$args)
    {
        return static::getInstance()->blade->compiler(...$args);
    }
    public static function composer(...$args)
    {
        return static::getInstance()->blade->composer(...$args);
    }
    public static function creator(...$args)
    {
        return static::getInstance()->blade->creator(...$args);
    }
    public static function directive(...$args)
    {
        return static::getInstance()->blade->directive(...$args);
    }
    public static function exists(...$args)
    {
        return static::getInstance()->blade->exists(...$args);
    }
    public static function if(...$args)
    {
        return static::getInstance()->blade->if(...$args);
    }
    public static function replaceNamespace(...$args)
    {
        return static::getInstance()->blade->replaceNamespace(...$args);
    }
    public static function share(...$args)
    {
        return static::getInstance()->blade->share(...$args);
    }
}