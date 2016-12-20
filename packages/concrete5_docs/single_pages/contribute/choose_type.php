<?php 	defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <h1><?=t('Write Documentation')?></h1>
            <form action="<?=$view->action('choose_type')?>" method="post">
                <p class="lead"><?=t("Choose the type of documentation you'd like to write.")?></p>
            <div class="control-group">
                <div class="radio">
                    <div class="radio">
                        <label>
                            <input type="radio" name="documentation_type" value="tutorial" checked> <?=t('Tutorial')?>
                            <p class="help-block">
                                <?=t('Tutorials are targeted, self-contained how-to documents that tackle a particular topic. They can be geared toward site editors, designers or developers. Tutorials should be about a specific topic, and hopefully answer a question about how to accomplish a task with concrete5.')?>
                            </p>
                        </label>
                    </div>
                    <label>
                        <input type="radio" name="documentation_type" value="editor_documentation"> <?=t('Editor Documentation')?>
                        <p class="help-block">
                            <?=t('Editor documentation describes how to use a particular feature of the concrete5 user interface. Good editor documentation should be targeted at someone using concrete5 to edit a website.')?>
                        </p>
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="documentation_type" value="developer_documentation"> <?=t('Developer Documentation')?>
                        <p class="help-block">
                            <?=t('Developer documentation pages should be broader than tutorials, and appear at the proper point in the table of contents. They should target someone configuring, extending or customizing concrete5.')?>
                        </p>
                    </label>
                </div>
                <div class="form-actions" style="text-align: center">
                    <button type="submit" class="btn btn-lg btn-default"><?=t('Next')?></button>
                </div>
            </form>

        </div>
    </div>
