<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
$user = new User();
$token = \Core::make('token');

?>

<div id="header-notifications">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <?php
                if ($user && $user->isLoggedIn()) {
                    ?>
                    <a class="profile-link" href="<?= \URL::to("/contributions") ?>">
                        <?=t("Your Contributions")?>
                    </a>
                    <a class="profile-link" href="<?= \URL::to("profile:{$user->getUserID()}") ?>">
                        <?= $user->getUserName() ?>
                    </a>
                    <a class="logout" href="<?= \URL::to("login", "logout", $token->generate('logout')) ?>">
                        <?= t('Logout') ?>
                    </a>
                    <?php
                } else {
                    ?>
                    <a class="profile-link" href="<?= \URL::to("/contribute") ?>">
                        <?=t("Contribute")?>
                    </a>
                    <a href="https://www.concrete5.org/register" class="sign-up">
                        <?= t('Join our Community') ?>
                    </a>
                    <a href="<?= \URL::to('/login') ?>" class="sign-in">
                        <?= t('Sign In') ?>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
