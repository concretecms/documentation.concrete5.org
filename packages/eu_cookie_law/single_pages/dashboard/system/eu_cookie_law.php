<?php

/**
* Project: EU Cookie Law Add-On
*
* @copyright 2017 Fabian Bitter
* @author Fabian Bitter (f.bitter@bitter-webentwicklung.de)
* @version 1.0.1.2
*/

defined('C5_EXECUTE') or die('Access denied');

View::element('/dashboard/Help', null, 'eu_cookie_law');

View::element('/dashboard/Reminder', array("packageHandle" => "eu_cookie_law", "rateUrl" => "https://www.concrete5.org/marketplace/addons/eu-cookie-law/reviews"), 'eu_cookie_law');

$defaults = array();

$defaults['value'] = $value;
$defaults['className'] = 'ccm-widget-colorpicker';
$defaults['showInitial'] = true;
$defaults['showInput'] = true;
$defaults['primaryEmpty'] = true;
$defaults['cancelText'] = t('Cancel');
$defaults['chooseText'] = t('Choose');
$defaults['preferredFormat'] = 'hex';
$defaults['clearText'] = t('Clear Color Selection');

?>

<style type="text/css">
    
    .ccm-widget-colorpicker, .control-label, .ccm-page-selector {
        display: block;
        float: left;
        clear: both;
    }
    
    .ccm-page-selector {
        width: 100%;
        margin-bottom: 15px;
    }
    
    .ccm-widget-colorpicker {
        margin-bottom: 15px;
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <form action="#" method="post">
            <fieldset>
                <legend>
                    <?php echo t("General"); ?>
                </legend>

                <div class="form-group">
                    <?php echo $form->label("method", t("Method")); ?>
                    <?php echo $form->select("method", $settings->getMethods(), $settings->getMethod()); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("language", t("Language")); ?>
                    <?php echo $form->select("language", $settings->getLanguages(), $settings->getLanguage()); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("customText", t("Custom Text")); ?>
                    <?php echo $form->textarea("customText", $settings->getCustomText()); ?>
                </div>
            </fieldset>
          
            <fieldset>
                <legend>
                    <?php echo t("Position"); ?>
                </legend>

                <div class="form-group">
                    <?php echo $form->label("position", t("Position")); ?>
                    <?php echo $form->select("position", $settings->getPositions(), $settings->getPosition()); ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <?php echo t("Colors"); ?>
                </legend>

                <div class="form-group">
                    <?php echo $form->label("popupBackgroundColor", t("Popup Background Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("popupBackgroundColor", $settings->getPopupBackgroundColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("popupTextColor", t("Popup Text Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("popupTextColor", $settings->getPopupTextColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("primaryButtonBackgroundColor", t("Primary Button Background Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("primaryButtonBackgroundColor", $settings->getPrimaryButtonBackgroundColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("primaryButtonBorderColor", t("Primary Button Border Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("primaryButtonBorderColor", $settings->getPrimaryButtonBorderColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("primaryButtonTextColor", t("Primary Button Text Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("primaryButtonTextColor", $settings->getPrimaryButtonTextColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("secondaryButtonBackgroundColor", t("Secondary Button Background Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("secondaryButtonBackgroundColor", $settings->getSecondaryButtonBackgroundColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("secondaryButtonBorderColor", t("Secondary Button Border Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("secondaryButtonBorderColor", $settings->getSecondaryButtonBorderColor(), $defaults); ?>
                </div>

                <div class="form-group">
                    <?php echo $form->label("secondaryButtonTextColor", t("Secondary Button Text Color")); ?>
                    <?php echo Core::make('helper/form/color')->output("secondaryButtonTextColor", $settings->getSecondaryButtonTextColor(), $defaults); ?>
                </div>
            </fieldset>

            <fieldset>
                <legend>
                    <?php echo t("Privacy Page"); ?>
                </legend>

                <div class="form-group">
                    <?php echo Loader::helper('form/page_selector')->selectPage("privacyPageId", $settings->getPrivacyPageId()); ?>
                </div>
            </fieldset>
            
            <div class="ccm-dashboard-form-actions-wrapper">
                <div class="ccm-dashboard-form-actions">

                    <div class="pull-right">

                        <a href="<?php echo $this->action("reset"); ?>" class="btn btn-default" onclick="return confirm('<?php echo t("Are you sure?"); ?>');">
                            <?php echo t("Reset"); ?>
                        </a>

                        <button type="submit" class="btn btn-primary" style="margin-left: 15px;">
                            <i class="fa fa-save" aria-hidden="true"></i> <?php echo t("Save"); ?>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>