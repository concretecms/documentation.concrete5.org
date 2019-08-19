<?php
defined('C5_EXECUTE') or die("Access Denied.");

use Concrete\Package\Concrete5Docs\Page\PageInspector;
?>

<div style="margin-bottom: 20px;">
    <hr>
    <h3><?= $title ?></h3>
    
    <?php
    if ($results) {

        foreach ($results as $result) {
            $username = t('Unknown');
            $ui = UserInfo::getByID($result->getCollectionUserID());
            if (is_object($ui)) {
                $username = $ui->getUserDisplayName();
            }
            $inspector = new PageInspector($result);
            ?>

            <div class="row">

                <div class="col-xs-10">
                    <a href="<?=$result->getCollectionLink()?>" style="margin-right: 10px; font-weight: bold; text-decoration: none;">
                        <?= $result->getCollectionName() ?>
                    </a>
                    <span class="tutorial-list-item-byline"><?= t('By ') ?><a href="#"><?= $username ?>.</a></span>
                </div>
                <div class="col-xs-2 text-right">
                    <span style="margin-right:10px"><i class="fa <?= $inspector->getTotalLikes() ? 'fa-heart text-danger' : 'fa-heart-o' ?>"></i> <?= $inspector->getTotalLikes() ? $inspector->getTotalLikes() : 0 ?></span>
                    <span><i class="fa fa-comment-o"></i> <?= $inspector->getTotalComments() ?></span>
                </div>
            </div>

            <?php
        }
    }
    ?>
</div>
