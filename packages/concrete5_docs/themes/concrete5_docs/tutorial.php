<?php
defined('C5_EXECUTE') or die("Access Denied.");
$view->requireAsset('highlight-js');
$this->inc('elements/header.php'); ?>

<main>

    <?
    $a = new Area('Page Header');
    $a->enableGridContainer();
    $a->display($c);
    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-content">
                <?
                $a = new Area('Main');
                $a->setAreaGridMaximumColumns(12);
                $a->display($c);
                ?>
                <?
                $a = new Area('Conversation');
                $a->setAreaGridMaximumColumns(12);
                $a->display($c);
                ?>
            </div>
            <div class="col-sm-4 col-sidebar">
                <? if (is_object($tags)) { ?>
                <section class="sidebar-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Tags</h3>
                        </div>
                        <div class="panel-body">
                            <? foreach($tags as $tag) {
                                $search = $controller->getSearchURL($tag);
                                ?>
                                <a href="<?=$search?>" class="label label-primary"><?=$tag->getSelectAttributeOptionValue()?></a>
                            <? } ?>
                        </div>
                    </div>
                </section>
                <? } ?>
                <? if (count($tutorials)) { ?>
                <section class="sidebar-item">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Related Tutorials</h3>
                        </div>
                        <div class="panel-body">
                            <? foreach($tutorials as $result) {
                                $inspector = new \Concrete\Package\Concrete5Docs\Page\PageInspector($result);
                                $ui = UserInfo::getByID($result->getCollectionUserID());
                                if (is_object($ui)) {
                                    $username = $ui->getUserDisplayName();
                                }?>
                                <article class="tutorial-list-item">
                                    <div class="tutorial-list-item-name"><a href="<?=$result->getCollectionLink()?>"><?=$result->getCollectionName()?></a></div>
                                    <div class="tutorial-metadata">
                                        <ul>
                                            <li><i class="fa fa-heart"></i> <?=$inspector->getTotalLikes()?></li>
                                            <li><i class="fa fa-comment-o"></i> <?=$inspector->getTotalComments()?></li>
                                        </ul>
                                    </div>
                                    <div class="tutorial-time"><?= $result->getCollectionDatePublicObject()->format('F d, Y')?></div>
                                </article>
                            <? } ?>
                        </div>
                    </div>
                </section>
                <? } ?>
                <? if (count($documentation)) { ?>
                    <section class="sidebar-item">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Related Documentation</h3>
                            </div>
                            <div class="panel-body">
                                <? foreach($documentation as $result) {

                                    $parent = Page::getByID($result->getCollectionParentID());
                                    ?>
                                    <article class="tutorial-list-item">
                                        <div class="tutorial-list-item-name">
                                            <a href="<?=$result->getCollectionLink()?>"><?=$result->getCollectionName()?></a>
                                            <div><small class="text-muted">Posted In <?=$parent->getCollectionName()?></small></div>
                                        </div>
                                    </article>
                                <? } ?>
                            </div>
                        </div>
                    </section>
                <? } ?>

                <?
                $a = new Area('Sidebar');
                $a->display($c);
                ?>

            </div>
        </div>
    </div>

    <?
    $a = new Area('Page Footer');
    $a->enableGridContainer();
    $a->display($c);
    ?>

</main>

<?php  $this->inc('elements/footer.php'); ?>
