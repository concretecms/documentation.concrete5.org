<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>

<fieldset>
    <div class="form-group">
        <label class="control-label" for="title"><?= t('Block Title') ?></label>
        <input type="text" class="form-control" name="title" value="<?= $title ? h($title) : t('Tutorials') ?>">
    </div>

    <div class="form-group">
        <label class="control-label" for="maxNumber"><?= t('Max Results') ?></label>
        <input type="text" class="form-control" name="maxNumber" value="<?= $maxNumber ?>">
    </div>

    <div class="form-group">
        <label class="control-label" for="filteredByTags"><?= t('Filtered by Tags') ?></label>
        

        <div class="row">
            <div class="col-xs-12">
                <input type="radio" name="filteredByTags" value="0" <?= (!$filteredByTags || $filteredByTags === 0) ? 'checked' : '' ?> />
                <?= t('No filtering by Tag') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <input type="radio" name="filteredByTags" value="1" <?= $filteredByTags ? 'checked' : '' ?> />
                <?= t('Filter by Tags on current page') ?>
            </div>
        </div>
        
    </div>

    <div class="form-group">
        <label class="control-label" for="filteredBy"><?= t('Filtered by Audience (optional)') ?></label>
        <?php
        $audienceOptions = [
            (string)$all => t('Show All'),
            (string)$developers => t('Developers'),
            (string)$editors => t('Editors'),
            (string)$designers => t('Designers')
        ];

        foreach ($audienceOptions as $audienceOptionValue => $audienceOptionLabel) {
            $isChecked = '';

            if ($filteredAudienceOption) {
                $isChecked = ($filteredAudienceOption === $audienceOptionValue) ? 'checked' : ''; 
            } else {
                $isChecked = ($audienceOptionValue === $all) ? 'checked' : '';
            }
            
        ?>

            <div class="row">
                <div class="col-xs-12">
                    <input type="radio" name="filteredAudienceOption"
                           value="<?= $audienceOptionValue ?>" <?= $isChecked ?> />
                    <?= $audienceOptionLabel ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <label class="control-label" for="sortByOptions"><?= t('Sort By') ?></label>
        <?php
        $sortOptions = [
            (string)$newest => t('By Published Date'),
            (string)$trend => t('By Trending'),
            (string)$likes => t('By Likes')
        ];

        foreach ($sortOptions as $optionValue => $optionLabel) {
            $isChecked = '';

            if ($sortByOptions) {
                $isChecked = ($sortByOptions === $optionValue) ? 'checked' : '';     
            } else {
                $isChecked = ($optionValue === $newest) ? 'checked' : '';
            }
        ?>

            <div class="row">
                <div class="col-xs-12">
                    <input type="radio" name="sortByOptions" value="<?= $optionValue ?>" <?= $isChecked ?> />
                    <?= $optionLabel ?>
                </div>
            </div>

        <?php } ?>
    </div>
</fieldset>
