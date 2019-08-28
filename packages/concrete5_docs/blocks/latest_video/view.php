<?php
defined('C5_EXECUTE') or die("Access Denied.");
/** @var \Concrete\Core\Entity\Express\Entry $videoObj */ 
?>

<?php if ($videoObj) { ?>
    <a class="popup-video"
        href="https://www.youtube.com/watch?v=<?= $videoObj->getYoutubeId() ?>?autoplay=1&rel=0"
        title="<?= $videoObj->getVideoDescription() ?>">
        <img src="https://img.youtube.com/vi/<?= $videoObj->getYoutubeId() ?>/maxresdefault.jpg"
                width="100%" style="border:1px solid #ccc;"/>
    </a>
    <h4>
        <a class="popup-video" href="https://www.youtube.com/watch?v=<?= $videoObj->getYoutubeId() ?>?autoplay=1&rel=0">
            <?= t($videoObj->getVideoName()) ?>
        </a>
        <br>
        <?php $date = $videoObj->getVideoDate(); ?>
        <span class="small"><?= t('Posted on '.$date->format('F d, Y')) ?></span>
    </h4>
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