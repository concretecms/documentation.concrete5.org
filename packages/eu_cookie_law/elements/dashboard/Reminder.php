<?php

/**
 * @author     Fabian Bitter (fabianbitter@protonmail.com)
 * @copyright  (C) 2018 Bitter Webentwicklung (www.bitter-webentwicklung.de)
 * @version    1.0.1.2
 */

defined('C5_EXECUTE') or die('Access denied');

$pkg = Package::getByHandle($packageHandle);

?>

<?php if (date("Y") <= 2018 && is_object($pkg) && !$pkg->getConfig()->get('reminder.hide')): ?>
    <div class="alert alert-info alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close" onclick="hideAlert();">&times;</a>
      
      <?php echo t("Rate this add-on on concrete5.org and as a thank-you gift can choose another add-on of mine up to $19. This offer may only be claimed once. Click <a href=\"%s\" class=\"alert-link\"> here </a> to rate now.", $rateUrl); ?>
    </div>

    <script>
        var hideAlert = function() {
          $.get("<?php echo URL::to("/bitter/" . $pkg->getPackageHandle() . "/reminder/hide"); ?>");
        };
    </script>
<?php endif; ?>