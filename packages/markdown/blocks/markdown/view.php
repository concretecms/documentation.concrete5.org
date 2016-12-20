<?php
	defined('C5_EXECUTE') or die("Access Denied.");
	$c = Page::getCurrentPage();
	if (!$content && is_object($c) && $c->isEditMode()) { ?>
		<div class="ccm-edit-mode-disabled-item"><?=t('Empty Markdown Block.')?></div>
	<? } else { ?>
		<div class="ccm-block-markdown-content"><?=$content?></div>
	<? }