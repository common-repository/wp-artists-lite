function votemeaddvote(postId)
{
	jQuery.ajax({
	type: 'POST',
	url: myAjax.ajaxurl,
	data: {
	action: 'wpa_votes_addvote',
	postid: postId
},
success:function(data, textStatus, XMLHttpRequest){
	var linkid = '#voteme-' + postId;
	jQuery(linkid).html('');
	jQuery(linkid).append(data);
	},
	error: function(MLHttpRequest, textStatus, errorThrown){
		alert(errorThrown);
		}
	});
}