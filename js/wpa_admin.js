jQuery(document).ready( function() {
								 
      var windowsize = jQuery(".item-page").width();
	 //Profile Menu
	 jQuery(".wpamenu").live("click",  function() {					
      nonce = jQuery(this).attr("data-nonce");
	  object = jQuery(this).attr("data-object");
	  artist_id = jQuery(this).attr("data-artist_id");
	  count = jQuery(this).attr("data-count");
	  jQuery('.more_pages').hide();
	   jQuery('.more_pages').children().hide();
	   jQuery('#wpartist').html('<p><img src="'+ myAjax.loader +'" width="400" height="352" /></p>');
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "wpa_process_request", artist_id : artist_id, count: count, object: object, nonce: nonce},
		 success: function(response) {
            if(response.type == "success") {
               jQuery("#wpartist").html(response.result);
			   jQuery(".wpamenu_more").attr("data-count",response.count);
            }
         }
      })  
	  });
	 
	//Dashboard Menu							   
	 jQuery(".wpa_dash").live("click", function() {					
      var view = jQuery(this).attr("data-wpa_view");
	   nonce = jQuery(this).attr("data-nonce");
		jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "wpa_processajax_form",view : view, activity: "get_list",nonce:nonce},
		 success: function(response) {
            if(response.type == "success") {
               jQuery("#wpartist").html(response.result);
            }else{
				alert('no');
			}
         }
      })
	  });
	 // New Form
	 jQuery(".wpa_new_form").live("click", function() {					
      nonce = jQuery(this).attr("data-nonce");
	  post_id = jQuery(this).attr("data-post_id");
	  view = jQuery(this).attr("data-wpa_view");
	  jQuery('#wpartist').html('<p><img src="'+ myAjax.loader +'" width="400" height="352" /></p>');
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "wpa_new_ajax_form",view: view,nonce: nonce},
		 success: function(response) {
            if(response.type == "success") {
               jQuery("#wpartist").html(response.result);
            }
            else {
			   jQuery("#wpartist").html("<div>Result Failed</div>");
            }
         }
      })  
	  });
	 //Form
	 jQuery(".wpaform").live("click", function() {					
      //nonce = jQuery(this).attr("data-wpartist_class_nonce");
	  post_id = jQuery(this).attr("data-post_id");
	  view = jQuery(this).attr("data-wpa_view");
	   jQuery('#wpartist').html('<p><img src="'+ myAjax.loader +'" width="400" height="352" /></p>');
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "wpa_processajax_form",post_id : post_id, view: view},
		 success: function(response) {
            if(response.type == "success") {
               jQuery("#wpartist").html(response.result);
			   //jQuery(".wpamenu_more").attr("data-count",response.count);
            }
            else {
               alert("Your vote could not be added");
            }
         }
      })  
	  });
	 
	 
	 
	 
	 
	 
	 jQuery(".wpa_more_menu").live('click', function() {					     
	  page_id = jQuery(this).attr("data-pageid");
	 // var ouput = jQuery('.more_pages div#' + page_id).html();
	  //alert(ouput);
	  jQuery('#wpartist').empty();
	  jQuery('.more_pages').show();
	    jQuery('.more_pages').children().hide();
	  jQuery('.more_pages div#' + page_id).fadeIn();
	  });
	 
	 jQuery('.Pagination a').live('click', function(e){ //check when pagination link is clicked and stop its action.
 e.preventDefault();
 	 nonce = jQuery(this).attr("data-nonce");
	  object = jQuery(this).attr("data-object");
	  artist_id = jQuery(this).attr("data-artist_id");
 var link = jQuery(this).attr('href'); //Get the href attribute
 jQuery('#wpartist').fadeOut(500, function(){ //fade out the content area
jQuery('#wpartist').html('<p><img src="'+ myAjax.loader +'" width="400" height="352" /></p>'); // show the loader animation
 }).load(link + ' #wpartist', function(){ jQuery('#wpartist').fadeIn(500, function(){ //load data from the content area from paginator link page that we just get from the top
jQuery("#loader").hide(); //hide the loader
 }); });
 });
	 
   jQuery(".user_vote").click( function() {					
      post_id = jQuery(this).attr("data-post_id");
      nonce = jQuery(this).attr("data-nonce");
      jQuery.ajax({
         type : "post",
         dataType : "json",
         url : myAjax.ajaxurl,
         data : {action: "my_user_vote", post_id : post_id, nonce: nonce},
		 success: function(response) {
            if(response.type == "success") {
               jQuery("#wpartist").html(response.vote_count);
			  
            }
            else {
               alert("Your vote could not be added");
            }
         }
      })   
		//evt.preventDefault();
   })

})


//when the DOM is ready
	jQuery(document).ready(function($){	
		//first, take care of the "load more"
		//when someone clicks on the "load more" DIV
		var start = 0;
		var desiredPosts = 2;
		var loadMore = $('#load-more');
		//load event / ajax
		loadMore.click(function(){
			//add the activate class and change the message
			loadMore.addClass('activate').text('Loading...');
			//begin the ajax attempt
			offset = jQuery(this).attr("data-offset");
     		count = jQuery(this).attr("data-count");
			artist_id = jQuery(this).attr("data-artist_id");
			
			$.ajax({
				url : myAjax.ajaxurl,
				data : {action: "wpa_souncloud_load", count : count, offset : offset, artist_id: artist_id},
				type: 'post',
				dataType: 'json',
				cache: false,
				success: function(response) {
					if(response.type == "success") {
						   $('<div></div>')
							.addClass('music_item2')
							.html(response.result)
							.appendTo($('.display_row_soundcloud'))
							.hide()
								.slideDown(250,function() {
								});
						  var num	= 2;
						  var offset_new = parseInt(offset) + num;
						  loadMore.attr('data-offset',offset_new);
						  loadMore.text('Load More');
					}
					
					if(response.type == "fail") {
						  loadMore.text('Load Complete')
						  .fadeOut();
					}
				},
				fail: function() {
					loadMore.text('Load Complete');
				}
			});
		});
	});
