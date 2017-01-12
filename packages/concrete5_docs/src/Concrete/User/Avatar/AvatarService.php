<?php

namespace Concrete\Package\Concrete5Docs\User\Avatar;

use Concrete\Core\Application\Application;
use Concrete\Core\User\Avatar\AvatarServiceInterface;
use Concrete\Core\User\UserInfo;
use Zend\Http\Client;
use Zend\Http\Request;

class AvatarService implements AvatarServiceInterface
{

    protected $application;

    public function __construct(Application $application)
    {
        $this->application = $application;
    }

    public function getAvatarPath($communityUserID)
    {
        return sprintf('http://www.concrete5.org/files/avatars/%s.jpg', $communityUserID);
    }

    /**
     * @param \Concrete\Package\Concrete5Docs\User\UserInfo $ui
     * @return bool
     */
    public function userHasAvatar(UserInfo $ui)
    {
        $cache = $this->application->make('cache/expensive');
        $identifier = "user.avatar.exists.{$ui->getUserID()}";
        $item = $cache->getItem($identifier);
        if (!$item->isMiss()) {
            return $item->get();
        }

        if ($ui->getUserCommunityUserID()) {

            // I know this sucks. These type hints should be UserInfoInterface so that I can swap out UserInfo with our extended implementation. sadly
            // that's a bit more than what's on our plate right now, but maybe in v8
            $request = new Request();
            $client = new Client();

            $request->setMethod(Request::METHOD_HEAD);
            $request->setUri($this->getAvatarPath($ui->getUserCommunityUserID()));

            /**
             * @var $response \Zend\Http\Response
             */
            $response = $client->dispatch($request);
            if ($response->getStatusCode() == 200) {
                $response = true;
            } else {
                $response = false;
            }
        } else {
            $response = false;
        }

        $cache->save($item->set($response)->expiresAfter(1800)); // 30 minutes

        return $response;
    }

    public function removeAvatar(UserInfo $ui)
    {
        return false;
    }

    public function getAvatar(UserInfo $ui)
    {
        if ($this->userHasAvatar($ui)) {
            return $this->application->make('Concrete\Package\Concrete5Docs\User\Avatar\CommunityAvatar', array($ui));
        } else {
            return $this->application->make('Concrete\Core\User\Avatar\EmptyAvatar', array($ui));
        }
    }


}