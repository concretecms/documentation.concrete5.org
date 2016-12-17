<?php  
namespace Concrete\Package\LikesThisBlock\Src;
use Concrete\Core\Routing\Router;
use Concrete\Core\Support\Facade\Route;

defined('C5_EXECUTE') or die(_("Access Denied."));

class RouteHelper
{
    public static function registerRoutes()
    {
        Route::register(
            Router::route(array('/list/{cID}', 'likes_this_block')),
            '\Concrete\Package\LikesThisBlock\Controller\LikeList::view',
            'LikesThisBlockList',
            array('cID' => '[0-9]+')
        );

    }
}