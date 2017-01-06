<?php  defined('C5_EXECUTE') or die("Access Denied.");
$dh = Core::make('helper/date'); /* @var $dh \Concrete\Core\Localization\Service\Date */
$page = Page::getCurrentPage();
$date = $dh->formatDate($page->getCollectionDatePublic(), true);
$user = UserInfo::getByID($page->getCollectionUserID());
?>
<div class="ccm-block-page-title-byline">
    <h1><?=h($title)?></h1>
    <p class="text-muted">
        Posted by

        <?php if (is_object($user)): ?>
            <span class="page-author">
    <?php print $user->getUserDisplayName(); ?>
    </span>
        <?php endif; ?>

        on
        <span class="page-date">
    <?php print $date; ?>
    </span>

    </p>
</div>
