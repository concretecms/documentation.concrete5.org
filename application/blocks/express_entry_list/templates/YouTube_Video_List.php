<?php defined('C5_EXECUTE') or die('Access Denied.');

if ($entity) { ?>

    <div class="row">
        <div class="col-xs-12 text-center">
            <h1><?= t('Video Library') ?></h1>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12">
            <?php
            $results = $result->getItemListObject()->getResults();

            if (count($results)) { ?>

                <div class="row" style="margin-bottom: 10px;">

                <?php
                $column = 0;
                foreach ($result->getItems() as $item) {
                    /** @var Concrete\Core\Express\Entry\Search\Result\Item $item */
                    /** @var Concrete\Core\Entity\Express\Entry $video */
                    $video = $item->getEntry(); ?>

                    <div class="col-xs-3">
                        <a class="popup-video"
                           href="https://www.youtube.com/watch?v=<?= $video->getYoutubeId() ?>?autoplay=1&rel=0"
                           title="<?= $video->getVideoBlockDescription() ?>">
                            <img src="https://img.youtube.com/vi/<?= $video->getYoutubeId() ?>/maxresdefault.jpg"
                                 width="100%" style="border:1px solid #ccc;"/>
                        </a>
                        <h4><a class="popup-video"
                               href="https://www.youtube.com/watch?v=<?= $video->getYoutubeId() ?>?autoplay=1&rel=0">
                                <?= $video->getVideoBlockName() ?></a></h4>
                    </div>

                    <?php
                    $column++;
                    if ($column === 4) {
                        $column = 0;
                        echo "</div><div class='row' style='margin-bottom: 10px;'>";
                     }

                } //ends foreach. ?>
                </div>

                <div class="row">
                    <div class="col-xs-12 text-center">
                        <?php if ($pagination) { ?>
                            <?= $pagination ?>
                        <?php } ?>
                    </div>
                </div>

            <?php } ?>
        </div>
    </div>
<?php } ?>

<script>
  $(document).ready(function () {
    $('.popup-video').magnificPopup({
      type: 'iframe',
      mainClass: 'mfp-fade',
      preloader: true
    })
  })
</script>
