<?php  defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$page = Page::getCurrentPage();
$date = $dh->formatDate($page->getCollectionDatePublic(), true);
$user = UserInfo::getByID($page->getCollectionUserID());
if (is_object($user)) {
    $userDisplayName = $user->getUserDisplayName();
}
$c = \Page::getCurrentPage();
$u = new \User();
$inspector = new \Concrete\Package\Concrete5Docs\Page\PageInspector($c);
$count = $inspector->getTotalLikes();
$audience = array();
$audienceObject = $c->getAttribute('audience');
if (is_object($audienceObject)) {
    foreach($audienceObject as $entry) {
        $audience[] = '<a href="' . URL::to('/tutorials', 'search') . '?audience=' . strtolower($entry) . '">' . $entry . '</a>';
    }
}
?>
<div class="ccm-block-page-title-byline-conversation-likes">
    <h1><?=$c->getCollectionName()?></h1>
    <div class="byline">
        <span>Posted

            <?php
            if (isset($userDisplayName)) {
                $profile_link = $user->getUserPublicProfileUrl();
                ?>
                by

                <?php if ($profile_link) { ?>
                    <a class="page-author" href="<?= $profile_link ?>"><?= $user->getUserDisplayName(); ?></a>
                <?php } else { ?>
                    <?= $user->getUserDisplayName(); ?>
                <?php } ?>

                <?php
            }
            ?>
            for <?=implode(', ', $audience)?> on <?php print $date; ?></span>

        <ul class="byline-meta">
            <li><i class="fa fa-comment-o"></i> <?=$inspector->getTotalComments()?></li>
            <li><i class="fa <?php if ($userLikesThis) { ?>fa-heart heart-filled<?php } else { ?>fa-heart-o<?php } ?>"></i>
            <?=t2('%s', '%s', $count, number_format($count))?>
            <?php if ($u->isRegistered()) { ?>
                <?php if (!$userLikesThis) { ?>
                    <a href="<?=$view->action('like', Loader::helper('validation/token')->generate('like_page'))?>" data-action="block-like-page" class="btn btn-xs btn-link btn-default"><?=t('Like')?></a>
                <?php } else { ?>
                    <a href="<?=$view->action('unlike', Loader::helper('validation/token')->generate('unlike_page'))?>" data-action="block-unlike-page" class="btn btn-xs btn-link btn-default"><?=t('Un-Like')?></a>
                <?php } ?>
            <?php } ?>
            <?php
            if ($inspector->canEditInDocumentationComposer()) { ?>
                <a class="btn btn-xs btn-link" href="<?=URL::to('/contribute', 'edit', $c->getCollectionID())?>"><?=t('Edit %s', $c->getPageTypeName())?></a>
            <?php } ?>
            </li>
        </ul>
    </div>
    <hr/>
</div>
