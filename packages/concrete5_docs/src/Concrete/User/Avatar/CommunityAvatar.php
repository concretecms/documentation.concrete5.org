<?php
namespace Concrete\Package\Concrete5Docs\User\Avatar;

use Concrete\Core\Application\Application;
use Concrete\Package\Concrete5Docs\User\Avatar\AvatarService;
use Concrete\Core\User\Avatar\StandardAvatar;
use HtmlObject\Image;
use Concrete\Core\User\UserInfo;

class CommunityAvatar extends StandardAvatar
{

    protected $userInfo;
    protected $application;
    protected $avatarService;

    /**
     * Sigh. Again with the UserInfoInterface
     * @param UserInfo $userInfo
     * @param Application $application
     */
    public function __construct(UserInfo $userInfo, Application $application, AvatarService $avatarService)
    {
        $this->userInfo = $userInfo;
        $this->application = $application;
        $this->avatarService = $avatarService;
    }

    public function getPath()
    {
        return $this->avatarService->getAvatarPath($this->userInfo->getUserCommunityUserID());
    }

}
