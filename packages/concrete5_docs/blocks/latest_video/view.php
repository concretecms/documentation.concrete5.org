<?php
defined('C5_EXECUTE') or die("Access Denied."); 
?>

<?php if ($videoObj) { ?>
    <a class="popup-video"
        href="https://www.youtube.com/watch?v=<?= $videoObj->getYoutubeId() ?>?autoplay=1&rel=0"
        title="<?= $videoObj->getVideoBlockDescription() ?>">
        <img src="https://img.youtube.com/vi/<?= $videoObj->getYoutubeId() ?>/maxresdefault.jpg"
                width="100%" style="border:1px solid #ccc;"/>
    </a>
    <h4>
        <a class="popup-video" href="https://www.youtube.com/watch?v=<?= $videoObj->getYoutubeId() ?>?autoplay=1&rel=0">
            <?= t($videoObj->getVideoBlockName()) ?>
            <?php
            foreach ($videoObj->getVideoBlockAudience()->getSelectedOptions() as $option) {
                /** @var \Concrete\Core\Entity\Attribute\Value\Value\SelectValueOption $option */ ?>
                <span class="label label-default"><?= t($option->getSelectAttributeOptionValue()) ?></span>
            <?php } ?>
        </a>
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