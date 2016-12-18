<?php
namespace Concrete\Package\LikesThisBlock;

use Concrete\Core\Attribute\Type;
use \Concrete\Core\Package\Package;
use \Concrete\Core\Block\BlockType\BlockType;
use \Concrete\Core\Attribute\Key\CollectionKey as CollectionAttributeKey;
use \Concrete\Package\LikesThisBlock\Src\RouteHelper;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Controller extends Package
{

    protected $pkgHandle = 'likes_this_block';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '2.0.1';

    public function getPackageDescription()
    {
        return t("Allows users to say they like a page.");
    }

    public function getPackageName()
    {
        return t("Likes This!");
    }

    public function on_start()
    {
        RouteHelper::registerRoutes();
    }

    public function install()
    {
        $pkg = parent::install();
        BlockType::installBlockType('likes_this', $pkg);
        $type = Type::getByHandle('number');
        CollectionAttributeKey::add(
            $type,
            array(
                'akHandle' => 'likes_this_page_count',
                'akName' => t('Likes this Page Count'),
                'akIsSearchable' => true
            ),
            $pkg
        );
    }


}
