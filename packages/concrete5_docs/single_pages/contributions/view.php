<?php 	defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php if (count($results) > 0) { ?>

    <h1><?=t('Your Contributions')?></h1>
    <a href="<?=URL::to('/contribute')?>" class="btn-documentation btn-info btn btn-lg"><?=t('Write Documentation')?></a>

    <p>Here is all the documentation you've written.</p>

    <table class="table table-striped contributions-table">
    <thead>
    <tr>
        <th><?=t('Date Posted')?></th>
        <th><?=t('Page')?></th>
        <th><?=t('Type')?></th>
        <th><?=t('Status')?></th>
        <th><?=t('Edit')?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($results as $page) { ?>
        <tr>
            <td class="contribution-date"><span class="text-muted"><?=$page->getCollectionDatePublicObject()->format('F d, Y')?></span></td>
            <td class="contribution-name">
                <?php if ($controller->pageIsLive($page)) { ?>
                    <a href="<?=URL::to($page)?>"><?=$page->getCollectionName()?></a>
                <?php } else { ?>
                    <?=$page->getCollectionName()?>
                <?php } ?>
            </td>
            <td>
                <?php print $page->getPageTypeObject()->getPageTypeName();
                ?>
            </td>
            <td class="contribution-status">
                <?php if ($controller->pageIsLive($page)) { ?>
                    Live
                <?php } else { ?>
                    <span class="text-danger">Not Live</span>
                <?php } ?>
            </td>
            <td><a class="icon-link" href="<?=URL::to('/contribute', 'edit', $page->getCollectionID())?>"><i class="fa fa-pencil"></i></a></td>
        </tr>
    <?php } ?>
    </tbody>
    </table>

    <?php if ($results->haveToPaginate()) { ?>
    <div style="text-align: center">
        <?php print $results->renderDefaultView();?>
    </div>
        <?php } ?>



<?php } else { ?>


    <div class="" style="text-align: center"><br/><br/><br/>
<p class="lead">
    <?=t('You have not contributed any documentation to concrete5.')?>
    <br/><br/>
    <a href="<?=URL::to('/contribute')?>" class="btn-info btn btn-large"><?=t('Write some Documentation')?></a>
</p>    </div>

<?php } ?>
