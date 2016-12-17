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

                <? if ($profile_link) { ?>
                    <a class="page-author" href="<?= $profile_link ?>"><?= $user->getUserDisplayName(); ?></a>
                <? } else { ?>
                    <?= $user->getUserDisplayName(); ?>
                <? } ?>

                <?php
            }
            ?>
            for <?=implode(', ', $audience)?> on <? print $date; ?></span>

        <ul class="byline-meta">
            <li><i class="fa fa-comment-o"></i> <?=$inspector->getTotalComments()?></li>
            <li><i class="fa <? if ($userLikesThis) { ?>fa-heart heart-filled<? } else { ?>fa-heart-o<? } ?>"></i>
            <?=t2('%s', '%s', $count, number_format($count))?>
            <? if ($u->isRegistered()) { ?>
                <? if (!$userLikesThis) { ?>
                    <a href="<?=$view->action('like', Loader::helper('validation/token')->generate('like_page'))?>" data-action="block-like-page" class="btn btn-xs btn-link btn-default"><?=t('Like')?></a>
                <? } else { ?>
                    <a href="<?=$view->action('unlike', Loader::helper('validation/token')->generate('unlike_page'))?>" data-action="block-unlike-page" class="btn btn-xs btn-link btn-default"><?=t('Un-Like')?></a>
                <? } ?>
            <? } ?>
            <?
            if ($inspector->canEditInDocumentationComposer()) { ?>
                <a class="btn btn-xs btn-link" href="<?=URL::to('/contribute', 'edit', $c->getCollectionID())?>"><?=t('Edit %s', $c->getPageTypeName())?></a>
            <? } ?>
            </li>
        </ul>
    </div>
    <hr/>
</div>
