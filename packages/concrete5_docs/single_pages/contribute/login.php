<?php 	defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3" style="text-align: center">
            <h1><?=t('Write Documentation')?></h1>
            <p class="text-muted">You must be logged in with a <a href="//concrete5.org">concrete5.org</a> account to contribute documentation to concrete5.</p>

            <br/>
                <a href="<?=URL::to('/login')?>" class="btn-lg btn btn-primary"><?=t('Sign In')?></a>

            <hr/>

            <br/>

            <p class="text-muted">Don't have an account? Sign up today! We'd love the help.</p>

            <br/>

                <a href="//www.concrete5.org/register" class="btn-lg btn btn-default"><?=t('Register')?></a>

        </div>
    </div>
