<?php

namespace Concrete\Package\Concrete5Docs\User;

use Concrete\Core\Page\Page;
use Doctrine\ORM\EntityManager;
use PortlandLabs\Concrete5\Documentation\Entity\RelatedPage;
use League\Url\Url;

class UserInfo extends \Concrete\Core\User\UserInfo
{

    protected $communityUserID;

    public function getUserCommunityUserID()
    {
        if (!isset($this->communityUserID)) {
            $this->communityUserID = $this->connection->fetchColumn('select binding from OauthUserMap where user_id = ?', array(
                $this->getUserID()
            ));
        }
        return $this->communityUserID;
    }

    public function getUserPublicProfileUrl()
    {
        if ($this->getUserCommunityUserID()) {
            $url = Url::createFromUrl("https://www.concrete5.org/profile/-/view");
            $path = $url->getPath();
            $path->append((string) $this->getUserCommunityUserID());
            return $url->setPath($path);
        }
    }

}