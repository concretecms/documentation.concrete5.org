<?php  

defined('C5_EXECUTE') or die(_("Access Denied."));

?>

<div id="ccm-block-likes-this-dialog">

    <h3><?php  echo t('User List')?></h3>

<?php  
if (count($list) > 0) { ?>
	<p><?php   echo t('The following users like this page:')?></p>
	<?php  
	foreach($list as $uID) {
        $ui = UserInfo::getByID($uID);
        if (is_object($ui)) { ?>
            <p><?php  echo $ui->getUserName()?></p>
        <?php   }
    } ?>
<?php   } else { ?>
    <p><?php  echo t('No users have said they like this page.')?></p>
<?php   } ?>


</div>