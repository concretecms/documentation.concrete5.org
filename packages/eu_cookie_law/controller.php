<?php

/**
 * @project:   Urheberrechts Zentrale
 *
 * @author     Fabian Bitter
 * @copyright  (C) 2016 Bitter Webentwicklung (www.bitter-webentwicklung.de)
 * @version    1.0.1.2
 */

namespace Concrete\Package\EuCookieLaw;

defined('C5_EXECUTE') or die('Access denied');

use Package;
use SinglePage;
use AssetList;
use Concrete\Package\EuCookieLaw\Src\CookieDisclosure;
use Events;
use Route;
use BlockType;

class Controller extends Package
{
    protected $pkgHandle = 'eu_cookie_law';
    protected $pkgVersion = '1.0.1.2';
    protected $appVersionRequired = '5.7.0.4';

    public function getPackageDescription()
    {
        return t('EU Cookie Law add-on for concrete5.');
    }

    public function getPackageName()
    {
        return t('EU Cookie Law');
    }
  
    private function addReminderRoute()
    {
        Route::register("/bitter/" . $this->pkgHandle . "/reminder/hide", function () {
            $this->getConfig()->save('reminder.hide', true);
        });
    }

    public function on_start()
    {
        $this->initComponents();
    }

    public function initComponents()
    {
        $this->loadComposerDependencies();
        $this->registerAssets();
        $this->injectCookieCode();
        $this->addReminderRoute();
    }
    
    private function loadComposerDependencies()
    {
        // load composer packages
        if (file_exists($this->getPackagePath() . '/vendor/autoload.php')) {
            require $this->getPackagePath() . '/vendor/autoload.php';
        }
    }
    
    private function registerAssets()
    {
        AssetList::getInstance()->register('javascript', 'cookie-disclosure', "js/cookie-disclosure.js", array(), $this->pkgHandle);
        AssetList::getInstance()->register('css', 'cookie-disclosure', "css/cookie-disclosure.css", array(), $this->pkgHandle);
        
        // register bower assets
        AssetList::getInstance()->register('javascript', 'js-cookie', "bower_components/js-cookie/src/js.cookie.js", array(), $this->pkgHandle);
        
        AssetList::getInstance()->registerGroup("cookie-disclosure", array(
                array("javascript", "jquery"),
                array("javascript", "js-cookie"),
                array("javascript", "cookie-disclosure"),
                array("css", "cookie-disclosure"),
            )
        );
    }
    
    private function injectCookieCode()
    {
        Events::addListener("on_before_render", function () {
            CookieDisclosure::getInstance()->injectCode();
        });
    }

    /**
     *
     * @param type $pathToCheck
     * @return boolean
     *
     */
    private function pageExists($pathToCheck)
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        $pages = SinglePage::getListByPackage($pkg);

        foreach ($pages as $page) {
            if ($page->getCollectionPath() === $pathToCheck) {
                return true;
            }
        }

        return false;
    }

    private function addPageIfNotExists($path, $name, $excludeNav = false)
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        if ($this->pageExists($path) === false) {
            $singlePage = SinglePage::add($path, $pkg);

            if ($singlePage) {
                $singlePage->update(
                        array(
                            'cName' => $name
                        )
                );

                if ($excludeNav) {
                    $singlePage->setAttribute('exclude_nav', 1);
                }
            }
        }
    }

    private function installOrUpdateBlockType($blockTypeName)
    {
        $pkg = Package::getByHandle($this->pkgHandle);
      
        if (!is_object(BlockType::getByHandle($blockTypeName))) {
            BlockType::installBlockType($blockTypeName, $pkg);
        }
    }
  
    private function installBlockTypes()
    {
        $this->installOrUpdateBlockType("cookie_control");
    }

    private function installOrUpdatesPages()
    {
        $this->addPageIfNotExists("/dashboard/system/eu_cookie_law", t("EU Cookie Law"));
        $this->addPageIfNotExists("/eu_cookie_law", t("EU Cookie Law"), true);
    }
    
    
    private function installOrUpdate()
    {
        $this->installOrUpdatesPages();
        $this->installBlockTypes();
    }

    public function upgrade()
    {
        $this->installOrUpdate();

        parent::upgrade();
    }

    public function install()
    {
        parent::install();

        $this->installOrUpdate();
    }
}
