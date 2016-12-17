<?php

namespace Concrete\Package\Concrete5Docs\Controller\SinglePage;

use Concrete\Core\Page\Controller\PageController;
use Concrete\Core\Page\Page;
use Concrete\Core\Page\PageList;
defined('C5_EXECUTE') or die("Access Denied.");

class Contributions extends PageController
{

    public function view()
    {
        $u = new \User();
        $list = new PageList();
        $list->filterByPageTypeHandle(array('tutorial', 'editor_document', 'developer_document'));
        $list->sortByPublicDateDescending();
        $list->filterByUserID($u->getUserID());
        $list->setItemsPerPage(30);
        $list->ignorePermissions();
        $list->setPageVersionToRetrieve(PageList::PAGE_VERSION_RECENT);
        $results = $list->getPagination();
        $this->set('results', $results);
    }

    public function pageIsLive(Page $page)
    {
        $d = clone $page;
        $cp = new \Permissions($d);
        if (!$page->isActive() && (!$cp->canViewPageVersions())) {
            return false;
        }
        $d->loadVersionObject('ACTIVE');
        $v = $d->getVersionObject();
        $vp = new \Permissions($v);
        if ($vp->getError() == COLLECTION_NOT_FOUND) {
            return false;
        }
        return true;
    }
}