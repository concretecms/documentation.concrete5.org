<?php

namespace Concrete\Package\Concrete5Docs;

use Concrete\Core\Asset\AssetList;
use Concrete\Core\Backup\ContentImporter;
use Concrete\Core\Foundation\Service\ProviderList;
use Concrete\Core\Job\Job;
use Concrete\Core\Routing\Redirect;
use Concrete\Core\Support\Facade\Route;
use Concrete\Package\Concrete5Docs\Page\Relater;
use Concrete\Package\Concrete5Docs\User\UserInfo;
use Package;
use Page;
use Concrete\Core\Block\BlockType\BlockType;
use PortlandLabs\Concrete5\Documentation\Migration\Publisher\Block\MarkdownPublisher;
use SinglePage;
use \Concrete\Core\Page\Theme\Theme;

class Controller extends Package
{

    protected $pkgHandle = 'concrete5_docs';
    protected $appVersionRequired = '8.3';
    protected $pkgVersion = '0.90';
    protected $pkgAutoloaderMapCoreExtensions = true;
    protected $pkgAutoloaderRegistries = [
        'src/PortlandLabs/Concrete5/Documentation' => '\PortlandLabs\Concrete5\Documentation'
    ];

    public function getPackageDescription()
    {
        return t("Documentation site.");
    }

    public function getPackageName()
    {
        return t("Documentation site");
    }

    protected function installPermissions($pkg)
    {
    }

    public function install()
    {
        $pkg = parent::install();
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/permissions.xml');
        $ci->importContentFile($pkg->getPackagePath() . '/required.xml');
        $ci->importContentFile($pkg->getPackagePath() . '/content.xml');
        $ci->importContentFile($pkg->getPackagePath() . '/videos.xml');
    }

    public function upgrade()
    {
        parent::upgrade();
        $pkg = \Package::getByHandle('concrete5_docs');
        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/permissions.xml');
        $ci->importContentFile($pkg->getPackagePath() . '/required.xml');
        $ci->importContentFile($pkg->getPackagePath() . '/videos.xml');
    }

    public function on_start()
    {
        $al = AssetList::getInstance();
        $al->register(
            'css', 'highlight-js', 'assets/highlight/css/concrete5-docs.css',
            array('minify' => false, 'combine' => false), $this
        );
        $al->register(
            'javascript', 'highlight-js', 'assets/highlight/js/highlight.pack.js',
            array('minify' => false, 'combine' => false), $this
        );
        $al->register(
            'javascript-inline', 'highlight-js', 'hljs.initHighlightingOnLoad();'
        );

        $al->registerGroup('highlight-js', array(
            array('javascript', 'highlight-js'),
            array('javascript-inline', 'highlight-js'),
            array('css', 'highlight-js')
        ));

        \Events::addListener('on_page_version_approve', function($event) {
            $page = $event->getPageObject();
            if ($page->getPageTypeHandle() == 'document' || $page->getPageTypeHandle() == 'tutorial') {
                $manager = \Database::connection()->getEntityManager();
                $relater = new Relater($manager, $page);
                $relater->clearRelations();
                foreach($relater->determineRelations() as $relation) {
                    $manager->persist($relation);
                }
                $manager->flush();

            }
        });
        \Events::addListener('on_page_delete', function($event) {
            $page = $event->getPageObject();
            if ($page->getPageTypeHandle() == 'document' || $page->getPageTypeHandle() == 'tutorial') {
                $manager = \Database::connection()->getEntityManager();
                $relater = new Relater($manager, $page);
                $relater->clearRelations();
            }
        });

        \Core::bind('Concrete\Core\User\UserInfo', 'Concrete\Package\Concrete5Docs\User\UserInfo');

        \Core::bindShared('user/avatar', function() {
            return \Core::make('Concrete\Package\Concrete5Docs\User\Avatar\AvatarService');
        });

        \Events::addListener('on_before_render', function() {
            $c = Page::getCurrentPage();
            if (is_object($c) && !$c->isError()) {
                if ($c->getAttribute('replace_link_with_first_in_nav')) {
                    $child = $c->getFirstChild();
                    if (is_object($child) && !$child->isError()) {
                        Redirect::page($child)->send();
                        exit;
                    }
                }
            }
        });


    }

    public function on_after_packages_start()
    {
        // Handle markdown block
        try {
            $manager = \Core::make('migration/manager/publisher/block');
            $manager->extend('markdown', function() {
                return new MarkdownPublisher();
            });
        } catch(\Exception $e) {}
    }
}
