<?php defined('C5_EXECUTE') or die('Access Denied.'); ?>

<div class="col-md-8 col-md-offset-2" style="text-align: center">
    <h1><?=t("Search Tutorials")?></h1>
    <form action="<?=$view->action('search')?>" class="tutorial-search-form" data-tutorial-search="<?=$b->getBlockID()?>">
        <input type="hidden" name="audience" value="<?=$audience?>" >
    <input type="hidden" class="input-lg" value="<?php if (is_object($selection)) { ?><?=$selection->id?><?php } ?>" placeholder="<?=$placeholder?>" style="padding: 0px; width: 100%"
           name="search" />
        <button type="submit" class="btn-bordered-white btn-lg btn"><?=t('Search')?></button>
    </form>
</div>

<style type="text/css">
    form.tutorial-search-form {padding-right: 100px; position: relative}
    form.tutorial-search-form button {
        position: absolute;
        top: 0px;
        right: 0px;
    }
    div.tutorial-search-result span.label {
        float:right;
    }

    div.select2-result-label div.tutorial-search-result span {
        margin-top: 3px;
    }

    form.tutorial-search-form .select2-container-multi .select2-choices .select2-search-choice
    div.tutorial-search-result {
        margin-top: 2px;
    }

    form.tutorial-search-form .select2-container-multi .select2-choices .select2-search-choice {
        border: 0px;
        float: none;
        height: 36px;
        text-align: left;
    }
</style>


<script type="text/javascript">
    $(function() {
        var $input = $('form[data-tutorial-search=<?=$b->getBlockID()?>] input[name=search]');
        $('form[data-tutorial-search=<?=$b->getBlockID()?>] input[name=search]').select2({
            multiple: true,
            createSearchChoice: function(term, data) {
                var filtered = $(data).filter(function() {
                    return this.text.localeCompare(term) === 0;
                });

                if (filtered.length === 0) {
                    return {
                        id: term,
                        type: 'query',
                        text: _.escape(term)
                    };
                }
            },
            initSelection: function(element, callback) {
                <?php if (is_object($selection)) { ?>
                    callback(<?=json_encode($selection)?>);
                <?php } ?>
            },
            formatResult: function(result, container, query) {
                switch(result.type) {
                    case 'question':
                        var type = 'Answer';
                        var label = "success";
                        break;
                    case 'tag':
                        var type = 'Tagged';
                        var label = 'info';
                        break;
                    case 'query':
                        var type = 'Search';
                        var label = 'default';
                        break;
                }
                var html = '<div class="tutorial-search-result tutorial-search-' + result.type + '"><span class="label label-' + label + '">' + type + '</span>' + result.text + '</div>';
                return html;
            },
            formatSelection: function(o, container) {
                return this.formatResult(o, container);
            },
            createSearchChoicePosition: 'bottom',
            maximumSelectionSize: 1,
            minimumInputLength: 2,
            ajax: { // instead of writing the function to execute the request we use Select2's convenient helper
                url: "<?=$view->action('load_questions')?>",
                dataType: 'json',
                quietMillis: 250,
                data: function (term, page) {
                    return {
                        q: term // search term
                    };
                },
                results: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to alter the remote JSON data

                    data = data.map(function(result) {
                        result.text = _.escape(result.text);
                        return result;
                    });

                    return { results: data };
                }
            }
        }).on('change', function(e) {
            if (e.added) {
                $('.select2-search-field').hide();
            } else {
                $('.select2-search-field').show();
            }
        });

        if ($input.val()) {
            $('.select2-search-field').hide();
        }

    });
</script>
