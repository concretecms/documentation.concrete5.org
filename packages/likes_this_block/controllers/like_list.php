<?php   

namespace Concrete\Package\LikesThisBlock\Controller;
use Concrete\Core\Controller\Controller;
use Concrete\Core\Block\BlockType\BlockType;

class LikeList extends Controller {

    protected $viewPath = '/like_list';

    public function view($cID)
    {
        $bt = BlockType::getByHandle('likes_this');
        $list = $bt->controller->getLikesList($cID);
        $this->set('list', $list);
    }
}