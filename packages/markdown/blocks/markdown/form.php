<?php
if (isset($composerContent)) {
    $content = $composerContent;
}
?>

<div id="ccm-block-markdown-editor"><?=h($content)?></div>
<?php if (!isset($fieldName)) {
    $fieldName = $view->field('content');
} ?>
<textarea style="display: none" id="ccm-block-markdown-value-textarea" name="<?=$fieldName?>"></textarea>


<script type="text/javascript">
    $(function() {
        var stupidAceEditorChangeEvent = function() {
            $('#ccm-block-markdown-value-textarea').val(editor.getValue());
        }

        $(document).ajaxError(function(e, request, settings) {
            if (settings.url == '<?=$view->action('upload')?>') {
                ConcreteAlert.dialog('<?=t('Error')?>', request.responseJSON.error.message);
            }
        });
        $('#ccm-block-markdown-editor').markdownEditor({
            imageUpload: true,
            fullscreen: true,
            uploadPath: '<?=$view->action('upload')?>',
            preview: true,
            // This callback is called when the user click on the preview button:
            onPreview: function (content, callback) {
                // Example of implementation with ajax:
                $.ajax({
                    url: '<?=$view->action('preview')?>',
                    type: 'POST',
                    dataType: 'html',
                    data: {content: content},
                }).done(function(result) {
                    // Return the html:
                    callback(result);
                });
            }
        });

        var editor = $('#ccm-block-markdown-editor').markdownEditor('getEditor');
        editor.getSession().on('change', stupidAceEditorChangeEvent);

        stupidAceEditorChangeEvent();
    });
</script>
