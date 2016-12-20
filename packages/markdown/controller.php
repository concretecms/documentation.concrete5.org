<?php

namespace Concrete\Package\Markdown;

defined('C5_EXECUTE') or die(_("Access Denied."));

use \Concrete\Core\Package\Package;
use \Concrete\Core\Block\BlockType\BlockType;
use \Concrete\Core\Asset\AssetList;
use Symfony\Component\ClassLoader\Psr4ClassLoader;
use Route;

class Controller extends Package
{

    protected $pkgHandle = 'markdown';
    protected $appVersionRequired = '5.7.5.2a1';
    protected $pkgVersion = '2.0';

    public function getPackageDescription()
    {
        return t('Adds a markdown block to your site.');
    }

    public function getPackageName()
    {
        return t('Markdown');
    }

    public function install()
    {
        $pkg = parent::install();

        // install block
        BlockType::installBlockTypeFromPackage('markdown', $pkg);
    }

    public function registerAssets()
    {
        $al = AssetList::getInstance();
        $pkg = \Package::getByHandle('markdown');
        $al->register(
            'javascript', 'bootstrap-markdown-editor', 'js/bootstrap-markdown-editor.js',
            array('minify' => false, 'combine' => false), $pkg
        );
        $al->register(
            'css', 'bootstrap-markdown-editor', 'css/bootstrap-markdown-editor.css',
            array('minify' => false, 'combine' => false), $pkg
        );
        $al->registerGroup('bootstrap-markdown-editor', array(
            array('javascript', 'ace'),
            array('javascript', 'bootstrap-markdown-editor'),
            array('css', 'bootstrap-markdown-editor'),
            array('css', 'core/app'),
            array('css', 'font-awesome')
        ));
    }

    public function on_start()
    {
        $this->registerAssets();
    }

}