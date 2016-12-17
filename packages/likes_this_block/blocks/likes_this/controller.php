<?php  
namespace Concrete\Package\LikesThisBlock\Block\LikesThis;

use Concrete\Core\Block\BlockController;
use Concrete\Core\Block\View\BlockView;
use User;
use Page;
use Database;
use Core;
use Redirect;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends BlockController
{

    protected $btTable = 'btLikesThis';
    protected $btDefaultSet = 'social';

    /**
     * Used for localization. If we want to localize the name/description we have to include this
     */
    public function getBlockTypeDescription()
    {
        return t("Allows users to say they like a page");
    }

    public function getBlockTypeName()
    {
        return t("Like this Page");
    }

    public function view()
    {
        $this->requireAsset('css', 'core/font-awesome');
        $this->requireAsset('javascript', 'jquery');
        $this->requireAsset('core/lightbox');

        $u = new User();
        $page = Page::getCurrentPage();

        $this->set('page', $page);
        $this->set('u', $u);
        $this->set('count', $this->getLikeCount($page->getCollectionID()));
        $this->set('userLikesThis', $this->hasMarked($page->getCollectionID()));
    }

    public function getLikesList($cID)
    {
        $db = Database::get();
        $a = $db->GetCol('select uID from btLikesThisUserPages where cID = ?', array($cID));
        return $a;
    }

    public function action_like($token = false, $bID = false)
    {
        if ($this->bID != $bID) {
            return false;
        }

        if (Core::make('helper/validation/token')->validate('like_page', $token)) {
            $page = Page::getCurrentPage();
            $u = new User();
            $this->markLike($page->getCollectionID(), $page->getCollectionTypeID(), $u->getUserID());
            if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                $b = $this->getBlockObject();
                $bv = new BlockView($b);
                $bv->render('view');
            } else {
                Redirect::page($page)->send();
            }
        }

        exit;
    }

    public function action_unlike($token = false, $bID = false)
    {
        if ($this->bID != $bID) {
            return false;
        }

        if (Core::make('helper/validation/token')->validate('unlike_page', $token)) {
            $page = Page::getCurrentPage();
            $u = new User();
            $db = \Database::connection();
            $db->Execute('delete from btLikesThisUserPages where cID = ? and uID = ?', array(
                $page->getCollectionID(), $u->getUserID()
            ));

            $res = $this->getLikeCount($page->getCollectionID());
            $res--;
            $page->setAttribute('likes_this_page_count', $res);

            if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
                $b = $this->getBlockObject();
                $bv = new BlockView($b);
                $bv->render('view');
            } else {
                Redirect::page($page)->send();
            }
        }

        exit;
    }


    public function markLike($cID, $ctID, $uID)
    {
        if (!$this->hasMarked($cID)) {
            $db = Database::get();
            $db->query("REPLACE INTO btLikesThisUserPages (cID, uID, ctID) VALUES (?,?,?)", array($cID, $uID, $ctID));
            $res = $this->getLikeCount($cID);
            $res++;

            $page = Page::getByID($cID);
            $page->setAttribute('likes_this_page_count', $res);

            if ($_COOKIE['LikesThisBlockLikes']) {
                $lt = $_COOKIE['LikesThisBlockLikes'];
                if ($lt) {
                    $lt = explode(',',$lt);
                }
            }

            if (!is_array($lt)) {
                $lt = array();
            }

            $lt[$cID] = $cID;
            setcookie('LikesThisBlockLikes', implode(',',$lt), time() + 3600, DIR_REL . '/');
            $GLOBALS['LikesThisBlockLikes'] = $lt; // I know, this is BAD.
        }
    }

    protected function hasMarked($cID)
    {
        $u = new User();
        if ($u->isRegistered()) {
            $db = Database::get();
            $uID = $u->getUserID();
            $has_marked = $db->getOne("SELECT uID FROM btLikesThisUserPages WHERE uID = ? AND cID = ?", array($uID, $cID));
            return $has_marked;
        } else {
            if (isset($GLOBALS['LikesThisBlockLikes'])) {
                $lt = $GLOBALS['LikesThisBlockLikes'];
            } else if ($_COOKIE['LikesThisBlockLikes']) {
                $lt = $_COOKIE['LikesThisBlockLikes'];
                if ($lt) {
                    $lt = explode(',', $lt);
                }
            }
            if (is_array($lt) && in_array($cID, $lt)) {
                return true;
            }
        }
    }

    protected function getLikeCount($cID)
    {
        $page = Page::getByID($cID);
        return $page->getAttribute('likes_this_page_count');
    }

    protected function getAbsoluteLikeCount($cID)
    {
        $db = Database::get();
        $res = $db->getOne("SELECT COUNT(cID) FROM btLikesThisUserPages WHERE cID = ?", array($cID));
        return $res;
    }

}

?>