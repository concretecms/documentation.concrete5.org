<?php
defined('C5_EXECUTE') or die("Access Denied.");
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
                <?
                $a = new Area('Sidebar');
                $a->display($c);
                ?>

                <?
                $inspector = new \Concrete\Package\Concrete5Docs\Page\PageInspector($c);
                if ($inspector->canEditInDocumentationComposer()) { ?>
                    <div class="well text-muted">
                        <p style="text-align: center">
                        <?=t('Could this page use improvement? Edit it!')?><br/><br/>
                    <a class="btn btn-default btn-lg" href="<?=URL::to('/contribute/', 'edit', $c->getCollectionID())?>"><?=t('Edit Page')?></a>
                        </p>
                    </div>
                <? } ?>

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
