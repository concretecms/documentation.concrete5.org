<?php

namespace Application\Controller\PageType;

use Concrete\Core\Page\Controller\PageController;
use Concrete\Core\Page\Type\Type;

class Tutorial extends PageController
{

    public function getSearchURL($tag)
    {
        $search = \URL::to('/tutorials', 'search') . '?search=' . $tag->getSelectAttributeOptionID();
        return $search;
    }

    public function view()
    {
        $tutorials = array();
        $documentation = array();
        $manager = \Database::connection()->getEntityManager();
        foreach($manager->getRepository('\PortlandLabs\Concrete5\Documentation\Entity\RelatedPage')->findBy(array(
            'page_id' => $this->getPageObject()->getCollectionID()
            )) as $relatedPage) {
            $c = \Page::getByID($relatedPage->getRelatedPageID(), 'RECENT');
            if (is_object($c)) {
                if ($c->getPageTypeHandle() == 'tutorial') {
                    $tutorials[] = $c;
                } else if ($c->getPageTypeHandle() == 'document') {
                    $documentation[] = $c;
                }
            }
        }
        shuffle($tutorials);
        shuffle($documentation);
        $this->set('tutorials', $tutorials);
        $this->set('documentation', $documentation);
        $this->set('tags', $this->getPageObject()->getAttribute('tags'));
    }
}