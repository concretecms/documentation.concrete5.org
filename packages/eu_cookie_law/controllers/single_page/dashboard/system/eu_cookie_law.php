<?php

/**
 * Project: EU Cookie Law Add-On
 *
 * @copyright 2017 Fabian Bitter
 * @author Fabian Bitter (f.bitter@bitter-webentwicklung.de)
 * @version 1.0.1.2
 */

namespace Concrete\Package\EuCookieLaw\Controller\SinglePage\Dashboard\System;

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Package\EuCookieLaw\Src\CookieDisclosure;
use Request;

class EuCookieLaw extends DashboardPageController
{
    public function reset()
    {
        CookieDisclosure::getInstance()->getSettings()->reset();
        
        $this->redirect("/dashboard/system/eu_cookie_law");
    }
    
    public function view()
    {
        if (Request::getInstance()->isPost()) {
            CookieDisclosure::getInstance()->getSettings()->apply($this->post());
        }

        $this->set("settings", CookieDisclosure::getInstance()->getSettings());
    }
}
