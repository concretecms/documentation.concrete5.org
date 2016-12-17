ConcreteLikesThisBlock = {

    init: function()
    {
        $('a[data-action=block-like-page],a[data-action=block-unlike-page]').on('click.likes-this', function() {
            jQuery.ajax({
                url: $(this).attr('href'),
                dataType: 'html',
                type: 'post',
                success: function(response) {
                    $('div.ccm-block-page-title-byline-conversation-likes').replaceWith(response);
                    ConcreteLikesThisBlock.init();

                }
            });
            return false;
        });
    }
}

$(function() {
    ConcreteLikesThisBlock.init();
});