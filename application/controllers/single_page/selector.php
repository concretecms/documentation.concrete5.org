<?php

namespace Application\Controller\SinglePage;

use Concrete\Core\Page\Controller\PageController;

class Selector extends PageController
{

    public function save()
    {
        $keys = array('tags', 'select_single', 'favorite_band', 'os');
        $home = \Page::getByID(1);
        foreach($keys as $akHandle) {
            $ak = \CollectionAttributeKey::getByHandle($akHandle);
            $ak->saveAttributeForm($home);
        }

        $this->redirect('/selector');
    }

}