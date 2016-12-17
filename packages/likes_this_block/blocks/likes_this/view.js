/* ccm_blockLikesThisSetupList = function() {

	$('a.ccm-block-likes-this-link-list').each(function() {
		$(this).unbind();
		$(this).click(function() {
			var url = $(this).attr('href');
			jQuery.fn.dialog.open({
				href: url,
				modal: false,
				title: $(this).attr('title')
			});		
			return false;
		});
	});


}

$(function() {
	$('a.ccm-block-likes-this-link').each(function() {
		$(this).click(function() {			
			var url = $(this).attr('href') + '&ajax=1';
			var elem = $(this).parent();
			$.get(url, function(r) {
				$('div.ccm-block-likes-this-wrapper').before(r).remove();
				$('div.ccm-block-likes-this-wrapper').effect("highlight", {}, 800);
				ccm_blockLikesThisSetupList();
			});			
			return false;
		});
	});
	
	ccm_blockLikesThisSetupList();
});*/

$(function() {
    $('a[data-action=block-view-like-list]').magnificPopup({
        type: 'ajax',
    });

    $('a[data-action=block-like-page]').on('click', function() {
        jQuery.ajax({
            url: $(this).attr('href'),
            dataType: 'html',
            type: 'post',
            success: function(response) {
                $('div.ccm-block-likes-this-wrapper').replaceWith(response);
            }
        });
        return false;
    });
});