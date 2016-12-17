<?php  
defined('C5_EXECUTE') or die("Access Denied.");
$c = Page::getCurrentPage();
?>

<div class="ccm-block-likes-this-wrapper">

    <i class="fa fa-heart"></i>

    <?php   if ($count > 0): ?>

    <p>
        <?php   if ($count == 1 && $userLikesThis) { ?>
            <?php  echo t('You like this page.')?>
        <?php   } else { ?>
            <a target="_blank" href="<?php  echo URL::route(array('/list', 'likes_this_block'), $c->getCollectionID())?>" data-action="block-view-like-list" title="<?php   echo t('View User List')?>">
                <?php  echo t2('%s person likes this page', '%s people like this page', $count, number_format($count))?>
            </a>
        <?php   } ?>
    </p>

    <?php   endif; ?>

    <?php   if (!$userLikesThis): ?>

    <p>
    <?php   if ($u->isRegistered()) { ?>
        <a href="<?php  echo $view->action('like', Loader::helper('validation/token')->generate('like_page'))?>" data-action="block-like-page"><?php  echo t('I like this page!')?></a>
    <?php   } else { ?>
        <?php   echo t('You must <a href="%s">sign in</a> to mark this page as one you like.', $this->url('/login', 'forward', $c->getCollectionID()));?>
    <?php   } ?>
    </p>

    <?php   endif; ?>

</div>