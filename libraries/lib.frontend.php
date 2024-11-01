<?php
add_action( 'edit_page_form', 'wpa_editor' );
add_action('init', 'wpa_form_processer');
add_shortcode( 'wpa_profile_edit', 'wpa_view_my_artists' );


function wpa_editor() {
	$settings = array(
    'textarea_name' => 'post_content',
    'media_buttons' => false,
    'tinymce' => array(
        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
            'bullist,blockquote,|,justifyleft,justifycenter' .
            ',justifyright,justifyfull,|,link,unlink,|' .
            ',spellchecker,wp_fullscreen,wp_adv'
    )
);
	wp_editor( $content, 'my_second_editor', $settings );
}
function wpa_form_processer() {
	if ( !isset($_POST['submitted']) || !wp_verify_nonce($_POST['wpa_artist_nonce'],'wpa_artist_nonce') ) return;
	global $wpdb;
	$post_id = 0;
	$post_title  = ( isset($_POST['post_title']) )  ? trim(strip_tags($_POST['post_title'])) : null;
 
 if ( $post_title == '' ) wp_die('Error: please fill the required field (title).'); 
  $post_status  = ( isset($_POST['post_status']) )  ? trim(strip_tags($_POST['post_status'])) : null;
 $post_type  = ( isset($_POST['post_type']) )  ? trim(strip_tags($_POST['post_type'])) : null;
 $id  = ( isset($_POST['ID']) )  ? (int)$_POST['ID'] : null;
$post_author = 1;
  $post_information = array(
       'post_title'    => wp_strip_all_tags( $_POST['post_title'] ),
  		'post_content'  => $_POST['post_content'],
		'post_status' => $post_status,
		'post_type' => $post_type,
		'post_author' => $post_author,
		'ID' => $id
    );
	
	
	if(isset($id) && $id != 0){
	wp_update_post( $post_information  );
	$post_id = $id;
	}else{	
	 $post_id = wp_insert_post( $post_information,true );
	 // 
	$post_id = $wpdb->insert_id;
	}
	
	
	 $thumb = $_POST['upload_image'];
	  $thumbnail_id = $wpdb->get_var( "SELECT id FROM  $wpdb->posts WHERE guid = '$thumb'");

	if(!empty($thumbnail_id)){
		
		set_post_thumbnail( $post_id , $thumbnail_id );
	}
	//Address
	/* Get the posted data and sanitize it for use as an HTML class. */
	$new_meta_value = ( isset( $_POST['address'] ) ? esc_textarea( $_POST['address'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'address';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//Artist_Id
	$new_meta_value = ( isset( $_POST['artist_id'] ) ? (int) $_POST['artist_id'] : '' );
	/* Get the meta key. */
	$meta_key = 'artist_id';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//link_user
	$new_meta_value = ( isset( $_POST['link_user'] ) ? (int) $_POST['link_user'] : '' );
	/* Get the meta key. */
	$meta_key = 'link_user';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//video_url
	$new_meta_value = ( isset( $_POST['video_url'] ) ? esc_url( $_POST['video_url'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'video_url';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//link_url
	$new_meta_value = ( isset( $_POST['link_url'] ) ? esc_url( $_POST['link_url'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'link_url';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//amazon_url
	$new_meta_value = ( isset( $_POST['amazon_url'] ) ? esc_url( $_POST['amazon_url'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'amazon_url';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//itunes_url
	$new_meta_value = ( isset( $_POST['itunes_url'] ) ? esc_url( $_POST['itunes_url'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'itunes_url';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//featured
	$new_meta_value = ( isset( $_POST['featured'] ) ? (int) $_POST['featured'] : '' );
	/* Get the meta key. */
	$meta_key = 'featured';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//label
	$new_meta_value = ( isset( $_POST['label_id'] ) ? (int) $_POST['label_id'] : '' );
	/* Get the meta key. */
	$meta_key = 'label_id';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//video_url
	$new_meta_value = ( isset( $_POST['release_date'] ) ? sanitize_text_field( $_POST['release_date'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'release_date';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	
	//date
	$new_meta_value = ( isset( $_POST['event_date'] ) ? sanitize_text_field( $_POST['event_date'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'event_date';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//date
	$new_meta_value = ( isset( $_POST['year'] ) ? sanitize_text_field( $_POST['year'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'year';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//date
	$new_meta_value = ( isset( $_POST['day'] ) ? sanitize_text_field( $_POST['day'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'day';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//date
	$new_meta_value = ( isset( $_POST['month'] ) ? sanitize_text_field( $_POST['month'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'month';
	
	 if(!empty($_FILES['back_cover'])) {
        $file   = $_FILES['back_cover'];
        $upload = wp_handle_upload($file, array('test_form' => false));
        if(!isset($upload['error']) && isset($upload['file'])) {
            $filetype   = wp_check_filetype(basename($upload['file']), null);
            $title      = $file['name'];
            $ext        = strrchr($title, '.');
            $title      = ($ext !== false) ? substr($title, 0, -strlen($ext)) : $title;
            $attachment = array(
                'post_mime_type'    => $wp_filetype['type'],
                'post_title'        => addslashes($title),
                'post_content'      => '',
                'post_status'       => 'inherit',
                'post_parent'       => $post->ID
            );

            $attach_key = 'back_cover_id';
            $attach_id  = wp_insert_attachment($attachment, $upload['file']);
            $existing_download = (int) get_post_meta($post->ID, $attach_key, true);

            if(is_numeric($existing_download)) {
                wp_delete_attachment($existing_download);
            }

            update_post_meta($post_id, $attach_key, $attach_id);
        }
    }
	
 $wpa_dashboard_page_id = get_option('wpa_dashboard_page_id');	
 header('Location: ' . get_permalink($wpa_dashboard_page_id ) );
 exit();
//
} 

function wpa_get_user_artists($user_id)
{
	$list = array();
	$args = array(
			 'post_type' => 'wpa_artist', 
			 'posts_per_page' =>'-1', 
			 'post_status' => array('publish', 'draft'),
			 'meta_query' => array(
				array(
					'key' => 'link_user',
					'value' => $user_id,
					'compare' => 'IN'
				)
   			 ));
	$query = new WP_Query($args ); 
	while ($query->have_posts()) : $query->the_post();
	array_push($list, get_the_ID());
	endwhile;
	wp_reset_postdata();
	return $list;
}
function wpa_view_my_artists($wpa_view = 'wpa_artist',$show_menu=0)
{
	
	$nonce = wp_create_nonce("wpartist_class_nonce");
	global $current_user;
      get_currentuserinfo();
	global $wp_post_types;

	
	$author_id = get_the_author_meta( 'ID',$current_user->ID);
	
	$views = array('wpa_artist'=>'Artist', 'wpa_page'=>'Pages', 'wpa_events'=>'Events','wpa_labels'=>'Labels', 'wpa_links'=>'Links','wpa_music'=>'Music', 'wpa_photos'=>'Photos', 'wpa_videos'=>'Videos' );
	
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	
	$html='';
	if(empty($wpa_view))
		{
			$wpa_view = 'wpa_artist';
		}
	 $obj = $wp_post_types[$wpa_view];
	 
	if($show_menu == 0){
	$html.='<div class="profile-menu">';
		$html.='<ul class="drop">';
			foreach($views as $key=>$value){
		$html.='<li><a class="wpa_dash" href="javascript:void(0);" data-nonce="'.$nonce.'" data-wpa_view="'.$key.'">'.$value.'</a></li>';
		}
	$html.='</ul><div class="clr"></div></div>';
	}
	$html.='<div id="wpartist">';
		
		$html.= '<h2>'.$obj->labels->name.'</h2>'; 
		$html.='<table>
			<tr>
				<th>Post Title</th>
				<th>&nbsp;</th>
				<th>Post Status</th>
				<th>Actions</th>
			</tr>';
			$args = array(
			 'post_type' => $wpa_view, 
			 'posts_per_page' =>'-1', 
			 'post_status' => array('publish', 'draft') );
			if($wpa_view == 'wpa_artist')
			{
				$label_query = $args['meta_query'] = array(
						array(
							'key' => 'link_user',
							'value' => $current_user->ID,
							'compare' => 'IN'
						)
					 );
				array_merge($args, $label_query);
			}else{
				$label_query = $args['meta_query'] = array(
						array(
							'key' => 'artist_id',
							'value' => wpa_get_user_artists($current_user->ID),
							'compare' => 'IN'
						)
					 );
				array_merge($args, $label_query);
			}
			
			 $query = new WP_Query($args ); 
			 
			 
			  $wpa_edit_page_id = get_option('wpa_edit_page_id');
			 $add_post = add_query_arg(array('wpa_view'=>$wpa_view,'wpa_edit'=>'edit','wpa_nonce'=> $nonce), get_permalink( $wpa_edit_page_id + $_POST['_wp_http_referer'] )); 
			 $html.='<tr><td colspan="3"></td><td><div>
			 <a href="'.$add_post.'">+ Add New</a><div class="clr"></div></div></td></tr>'; 
			 if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();
			
			$html.='<tr>
				<td><a href="'. get_permalink(get_the_ID()).'">'.get_the_title().'</a></td>
				<td>&nbsp;</td>
				<td>'.$states[get_post_status( get_the_ID() )].'</td>';
			   $edit_post = add_query_arg(array('wpa_view'=>$wpa_view,'wpa_edit'=>'edit','wpa_nonce'=> $nonce), get_permalink( get_the_ID() + $_POST['_wp_http_referer'] )); 
				$html.='<td>
					<a href="'.$edit_post.'"  data-wpa_view="'.$wpa_view.'"  data-nonce="'.$nonce.'" data-post_id="'.get_the_ID().'">Edit</a>&nbsp;&nbsp;';
					  if( !(get_post_status() == 'trash') ) : 
						$html.='<a onclick="return confirm(\'Are you sure you wish to delete post: '.get_the_title().'?\')"href="'.get_delete_post_link( get_the_ID() ).'>">Delete</a>';
						 endif;
				$html.='</td>
			</tr>';
		 endwhile; endif;
		$html.='</table>
	</div>';
	return $html;
}

function wpa_edit_my_artists($post_id = 0)
{
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
		<div>
			<h2>Artist</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="label_id">Label</label>'.$frm->getLabels('label_id').'</li>';
				echo '
				<input class="upload_image" id="upload_image" type="hidden" name="upload_image" value="">
				<a href="#" class="upload_image_button">Thumbnail</a><br />';
				if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
				}
				echo '<br />';
				$settings = array(
    'textarea_name' => 'post_content',
    'media_buttons' => true,
    'tinymce' => array(
        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
            'bullist,blockquote,|,justifyleft,justifycenter' .
            ',justifyright,justifyfull,|,link,unlink,|' .
            ',spellchecker,wp_fullscreen,wp_adv'
    )
);
	wp_editor( $post->post_content, 'my_second_editor', $settings );
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_artist" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>

			</fieldset>

		</form>

	</div>';
	//return $html;
}
function wpa_edit_my_pages($post_id = 0)
{
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
		<div>
			<h2>Page</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="artist_id">Artist</label>'.$frm->getArtistsByUser('artist_id').'</li>';
				echo '
				<input class="upload_image" id="upload_image" type="hidden" name="upload_image" value="">
				<a href="#" class="upload_image_button">Thumbnail</a><br />';
				if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
				}
				echo '<br />';
				$settings = array(
    'textarea_name' => 'post_content',
    'media_buttons' => true,
    'tinymce' => array(
        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
            'bullist,blockquote,|,justifyleft,justifycenter' .
            ',justifyright,justifyfull,|,link,unlink,|' .
            ',spellchecker,wp_fullscreen,wp_adv'
    )
);
	wp_editor( $post->post_content, 'my_second_editor', $settings );
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){
						$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_page" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>

			</fieldset>

		</form>

	</div>';
	
}
function wpa_edit_my_events($post_id = 0)
{
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
		$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
	<div>
			<h2>Event</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="artist_id">Artist</label>'.$frm->getArtistsByUser('artist_id').'</li>
				<li><label for="day">Day</label>'.$frm->day('day').'</li>
				<li><label for="month">Month</label>'.$frm->month('month').'</li>
				 <li><label for="year">Year</label>'.$frm->text('year').'</li>
				<li><label for="address">Address</label>'.$frm->textarea('address').'</li>';
				echo '
				<input class="upload_image" id="upload_image" type="hidden" name="upload_image" value="">
				<a href="#" class="upload_image_button">Thumbnail</a><br />';
				if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
				}
				echo '<br />';
				$settings = array(
    'textarea_name' => 'post_content',
    'media_buttons' => true,
    'tinymce' => array(
        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
            'bullist,blockquote,|,justifyleft,justifycenter' .
            ',justifyright,justifyfull,|,link,unlink,|' .
            ',spellchecker,wp_fullscreen,wp_adv'
    )
);
	wp_editor( $post->post_content, 'my_second_editor', $settings );
				
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_events" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>

			</fieldset>

		</form>

	</div>';
}
function wpa_edit_my_labels($post_id = 0)
{
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
		<div>
			<h2>Label</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li>Content</li><textarea name="post_content" rows="8" id="my_second_editor">'.$post->post_content.'</textarea>';
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<input class="upload_image" id="upload_image" type="hidden" name="upload_image" value="">
				<a href="#" class="upload_image_button">Thumbnail</a><br />';
				if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
				}
				echo '<br />';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_labels" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>

			</fieldset>

		</form>

	</div>';
}

function wpa_edit_my_links($post_id = 0)
{
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
	<div>
			<h2>Link</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="artist_id">Artist</label>'.$frm->getArtistsByUser('artist_id').'</li>';
    			echo '<li><label for="link_url">Link Url</label>'.$frm->text('link_url','size="60"').'</li>';
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_links" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>

			</fieldset>

		</form>

	</div>';
}
function wpa_edit_my_music($post_id = 0)
{
	$form_action    = get_permalink();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
       			 $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	
	
	
	
	
	$html='';
	echo '
	<div id="wpa_edit_form">
		<div>
			<h2>Music</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="artist_id">Artist</label>'.$frm->getArtistsByUser('artist_id').'</li>';
				echo '
				<input class="upload_image" id="upload_image" type="hidden" name="upload_image" value="">
				<a href="#" class="upload_image_button">Thumbnail</a><br />';
				if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
				}
				echo '<br />';
				$settings = array(
    'textarea_name' => 'post_content',
    'media_buttons' => true,
    'tinymce' => array(
        'theme_advanced_buttons1' => 'formatselect,|,bold,italic,underline,|,' .
            'bullist,blockquote,|,justifyleft,justifycenter' .
            ',justifyright,justifyfull,|,link,unlink,|' .
            ',spellchecker,wp_fullscreen,wp_adv'
    )
);
	wp_editor( $post->post_content, 'my_second_editor', $settings );
				echo '<li><label for="release_date">Release Date</label>'.$frm->text('release_date').'</li>';
   				echo '<li><label for="amazon_url">Amazon Url</label>'.$frm->text('amazon_url').'</li>';
    			echo '<li><label for="itunes_url">iTunes Url</label>'.$frm->text('itunes_url').'</li>';
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_music" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>
				
			</fieldset>

		</form>

	</div>';
	//return $html;
}
function wpa_edit_my_photos($post_id = 0)
{
	wpa_media_scripts(); // Get Media Uploader
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	$frm = new WPArtistForm($post->ID);
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	global $current_user;
    get_currentuserinfo();
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
	<div>
			<h2>Photos</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="artist_id">Artist</label>'.$frm->getArtistsByUser('artist_id').'</li>';
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<input class="upload_image" id="upload_image" type="hidden" name="upload_image" value="">
				<a href="#" class="upload_image_button">Thumbnail</a><br />';
				if ( has_post_thumbnail() ) {
				echo get_the_post_thumbnail( $post_id, 'thumbnail', $attr );
				}
				echo '<br />
<button type="submit">Submit</button>';
				$settings = array(
    'textarea_name' => 'post_content',
    'media_buttons' => true,
    'tinymce' => true
);
	wp_editor( $post->post_content, 'my_second_editor', $settings );
				echo '<div id="photoContainer"></div>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_photos" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'

			</fieldset>

		</form>

	</div>';
	//return $html;
}
function wpa_edit_my_videos($post_id = 0)
{
	
	$form_action    = get_permalink();
	$post = get_post( $post_id, $output );
	$frm = new WPArtistForm($post->ID);
	global $current_user;
    get_currentuserinfo();
	$states = array('draft'=>'Unpublished','publish'=>'Published');
	if(is_page())
	{
		$post_id = null;
		$post->ID = null;
		$title = "";
				$post->post_content = "";
        $post->post_statuts = "";
	}else{
		$post = get_post( $post_id, $output );
		if(get_the_title(0))
		{
			$title = get_the_title($post->ID);
		}else{
			$title = "";
		}
	}
	
	$html='';
	echo '
	<div id="wpa_edit_form">
	<div>
			<h2>Video</h2>
		</div>
		<form action="'.$form_action.'" id="artist-form" method="POST">
			<fieldset>';
				echo '<li><label for="post_title">Title</label><input name="post_title" value="'.$title.'" /></li>';
				echo '<li><label for="artist_id">Artist</label>'.$frm->getArtistsByUser('artist_id').'</li>';
			    echo '<li><label for="video_url">Video Url</label>'.$frm->text('video_url','size="60"').'</li>';
				echo '<li><label>Status</label><select name="post_status">';
					foreach($states as $key=>$value){
						if($key==$post->post_status){$selected= 'selected="selected"';}else{$selected = '';}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
					}
				echo '</select></li>';
				echo '
				<li><label>&nbsp;</label><input type="hidden" name="submitted" id="submitted" value="true" /></li>
				<input type="hidden" name="link_user" id="link_user" value="'.$current_user->ID.'" />
				<input type="hidden" name="post_type" id="post_type" value="wpa_videos" />
				<input type="hidden" name="ID" id="ID" value="'.$post_id.'" />'.wp_nonce_field('wpa_artist_nonce','wpa_artist_nonce').'
				<button type="submit">Submit</button>

			</fieldset>

		</form>

	</div>';
}

