<?php defined('C5_EXECUTE') or die("Access Denied.");
$nh = Loader::helper('navigation');
$previousLinkURL = is_object($previousCollection) ? $nh->getLinkToCollection($previousCollection) : '';
$parentLinkURL = is_object($parentCollection) ? $nh->getLinkToCollection($parentCollection) : '';
$nextLinkURL = is_object($nextCollection) ? $nh->getLinkToCollection($nextCollection) : '';
$previousLinkText = is_object($previousCollection) ? $previousCollection->getCollectionName() : '';
$nextLinkText = is_object($nextCollection) ? $nextCollection->getCollectionName() : '';
?>

<?php if ($previousLinkURL || $nextLinkURL || $parentLinkText): ?>

	<div class="ccm-block-next-previous-wrapper">

		<?php if ($previousLinkText): ?>
			<p class="pull-left">
				<?php echo $previousLinkURL ? '<i class="fa fa-caret-left"></i> <a href="' . $previousLinkURL . '">'. $previousLinkText . '</a>' : '' ?>
			</p>
		<?php endif; ?>


		<?php if ($nextLinkText): ?>
			<p class="pull-right">
				<?php echo $nextLinkURL ? '<a href="' . $nextLinkURL . '">
				' . $nextLinkText . '</a> <i class="fa fa-caret-right"></i>' : '' ?>
			</p>
		<?php endif; ?>


	</div>

<?php endif; ?>
