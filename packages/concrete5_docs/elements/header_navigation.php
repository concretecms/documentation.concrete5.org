<?php defined('C5_EXECUTE') or die("Access Denied."); ?>

<?php
$user = new User();
$token = \Core::make('token');

?>

<header class="navbar navbar-static-top documentation-header" role="banner">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="navbar-header">
                    <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target=".documentation-navbar-collapse">
                        <i class="fa fa-bars"></i>
                    </button>
                    <a href="https://www.concrete5.org/" class="header-logo"><img src="<?=$view->getThemePath()?>/images/logo.png" style="width: 160px"></a>
                </div>
                <nav class="collapse navbar-collapse documentation-navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active">
                            <a href="<?=DIR_REL?>/editors">Editors</a>
                        </li>
                        <li>
                            <a href="<?=DIR_REL?>/developers">Developers</a>
                        </li>
                        <li>
                            <a href="<?=DIR_REL?>/tutorials">Tutorials</a>
                        </li>
                        <li>
                            <a href="<?=DIR_REL?>/api">API</a>
                        </li>
                        <li>
                            <a href="<?=DIR_REL?>/contribute">Contribute</a>
                        </li>
                        <li class="hidden-sm">
                            <form action="<?=DIR_REL?>/search">
                                <i class="fa fa-search"></i>
                                <input type="text" placeholder="Search" name="query" class="form-control">
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    <div id="header-notifications">
        <div class="container">
            <div class="row">
                <div class="span12">
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
</header>
