<?php

namespace Concrete\Package\Concrete5Docs\Page;

use Concrete\Core\Block\Block;
use Concrete\Core\Page\Page;

class PageInspector
{

    protected $features;
    protected $page;
    protected $conversation;

    public function canEditInDocumentationComposer()
    {
        $p = new \Permissions($this->page);
        if ($p->canEditInDocumentationComposer()) {
            $blocks = $this->page->getBlocks('Main');
            if (count($blocks) == 1) {
                return true;
            }
        }
        return false;
    }

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    public function getConversationObject()
    {
        if (!isset($this->conversation)) {
            $blocks = $this->page->getBlocks('Comments');
            $conversation = false;
            if (is_object($blocks[0])) {
                $controller = $blocks[0]->getController();
                if ($controller instanceof \Concrete\Block\CoreConversation\Controller) {
                    $this->conversation = $controller->getConversationObject();
                }
            }
        }

        return $this->conversation;
    }

    public function getTotalComments()
    {
        $conversation = $this->getConversationObject();
        if (is_object($conversation)) {
            return $conversation->getConversationMessagesTotal();
        }
        return 0;
    }


    public function getTotalLikes()
    {
        // We're gonna go with the attribute instead so we can import old likes
        return $this->page->getAttribute('likes_this_page_count');
        //$db = \Database::connection();
        //return $db->GetOne('select count(cID) from btLikesThisUserPages where cID = ?', array($this->page->getCollectionID()));
    }
}