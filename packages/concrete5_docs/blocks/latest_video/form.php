<?php
defined('C5_EXECUTE') or die("Access Denied.");
?>
<style>
    .options-title {
        margin:15px 0 10px 0;
    }
    label.radio-option {
        font-weight: normal;
    }
</style>

<fieldset>
    <div class="form-group">
        <label class="options-title"><?= t('Filter Latest Video by Audience') ?></label>
        <?php
        $audienceOptions = [
            (string)$all => 'Most Recent Video',
            (string)$developers => 'Most Recent Developers Video',
            (string)$editors => 'Most Recent Editors Video',
            (string)$designers => 'Most Recent Designers Video'
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
                    <input type="radio" name="filteredAudienceOption" id="<?= 'option_'.$audienceOptionValue ?>"
                           value="<?= $audienceOptionValue ?>" <?= $isChecked ?> />
                    <label class="radio-option" for="<?= 'option_'.$audienceOptionValue ?>"><?= $audienceOptionLabel ?></label>
                </div>
            </div>

        <?php } ?>
    </div>
</fieldset>
