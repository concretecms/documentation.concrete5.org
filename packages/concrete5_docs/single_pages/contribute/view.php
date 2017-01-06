<?php 	defined('C5_EXECUTE') or die("Access Denied."); ?>

    <div class="row">
        <div class="col-sm-12">
            <h1><?=$pageTitle?></h1>
        </div>
        <div class="col-sm-8">
            <form action="<?=$action?>" method="post" enctype="multipart/form-data">
                <?=$form->hidden('documentation_type', $documentationType)?>
                <?=$token->output('save')?>
                <?php $pagetype->renderComposerOutputForm($document, $parent); ?>

                <?php if (is_object($document)) { ?>
                    <hr/>
                    <div class="form-group">
                        <?=$form->label('versionComment', t('Reason for Changes'))?>
                        <?=$form->textarea('versionComment', array('rows' => 4))?>
                    </div>

                    <?php if ($canEditDocumentAuthor) { ?>
                        <div class="form-group">
                            <?=$form->label('documentAuthor', t('Author'))?>
                            <?php
                                $selector = Core::make('helper/form/user_selector');
                                print $selector->quickSelect('documentAuthor', $documentAuthor);
                            ?>
                        </div>
                    <?php } ?>

                <?php } ?>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary pull-right"><?=$buttonTitle?></button>
                </div>
            </form>

        </div>
    </div>
