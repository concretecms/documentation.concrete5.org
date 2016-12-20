<?php defined('C5_EXECUTE') or die(_("Access Denied.")); ?>

<?php
$time = ini_get('max_execution_time');
if ($time == 0 || $time > 30) {
    ?>

    <div class="alert alert-warning">
        <?php echo t(
            '<strong>Attention!</strong> Clearing your site\'s content prior to installing this theme is highly ' .
            'recommended.') ?>
    </div>

<?php } else { ?>

    <div class="alert alert-danger">
        <?php echo t(
            '<strong>Attention!</strong> While it is strongly recommended that you clear your site\'s content prior ' .
            'to installing this theme, your maximum execution time is only set at %s seconds. ' .
            'This operation may time out.',
            $time) ?>
    </div>

<?php } ?>
