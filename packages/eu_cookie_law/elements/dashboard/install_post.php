<?php

/**
 * @author     Fabian Bitter
 * @copyright  (C) 2017 Bitter Webentwicklung (www.bitter-webentwicklung.de)
 * @version    1.0.1.2
 */

defined('C5_EXECUTE') or die('Access Denied.');

View::getInstance()->addFooterItem("<script src=\"https://apis.google.com/js/platform.js\" async defer></script>");

?>

<style type="text/css">
    .ui-dialog-title {
        visibility: hidden;
    }
</style>

<div class="row">
    <div class="col-xs-12">
        <h2>
            <?php echo t("Thank You for purchasing my Software!"); ?>
        </h2>

        <p>
            <?php echo t("Follow me on Google, Twitter and Facebook to get the latest news and notifications about updates, new add-ons/themes and special offers."); ?>
        </p>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="g-follow" data-annotation="bubble" data-height="20" data-href="//plus.google.com/u/1/109963429259217213902" data-rel="author"></div>

        <iframe src="https://www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fbitter.de%2F&width=114&layout=button_count&action=like&size=small&show_faces=false&share=false&height=21&appId=211616379422132" width="114" height="21" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>

        <a href="https://twitter.com/fabian_bitter?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @fabian_bitter</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
    </div>
</div>
