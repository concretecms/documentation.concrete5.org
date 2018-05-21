<?php

/**
 * Project: EU Cookie Law Add-On
 *
 * @copyright 2017 Fabian Bitter
 * @author Fabian Bitter (f.bitter@bitter-webentwicklung.de)
 * @version 1.0.1.2
 */

namespace Concrete\Package\EuCookieLaw\Controller\SinglePage;

defined('C5_EXECUTE') or die('Access denied');

use Concrete\Core\Page\Controller\PageController;
use Concrete\Package\EuCookieLaw\Src\CookieDisclosure;
use Symfony\Component\HttpFoundation\JsonResponse;

class EuCookieLaw extends PageController
{
    public function optIn()
    {
        return new JsonResponse(array(
            "success" => CookieDisclosure::getInstance()->optIn()
        ));
    }

    public function optOut()
    {
        return new JsonResponse(array(
            "success" => CookieDisclosure::getInstance()->optOut()
        ));
    }
    
    public function view()
    {
    }
}
