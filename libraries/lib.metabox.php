<?php	 	
/**
* WPArtist Metabox
* By: B4uCode | www.b4ucode.com
*/
add_action( 'add_meta_boxes', 'wpa_meta_box_add' );
add_action( 'save_post', 'wpa_artist_save_meta', 10, 2 );

add_action('post_edit_form_tag', 'post_edit_form_tag');
function post_edit_form_tag() {
    echo ' enctype="multipart/form-data"';
}

function wpa_meta_box_add()
{
	add_meta_box( 'artists-meta-box', 'Details', 'WPArtist_Meta_Artists', 'wpa_artist', 'normal', 'high' );
	add_meta_box( 'labels-meta-box', 'Details', 'WPArtist_Meta_Labels', 'wpa_labels', 'normal', 'high' );
	add_meta_box( 'music-meta-box', 'Details', 'WPArtist_Meta_Music', 'wpa_music', 'normal', 'high' );
}


function WPArtist_Meta_Artists($post)
{	
	wp_nonce_field( plugin_basename( __FILE__ ), 'wpartist_class_nonce' );
	$frm = new WPArtistForm($post->ID);
	$link_user = get_post_meta($post->ID, 'link_user', $single=true);
	?>

	<p><label for="label_id">Label</label>
	<?php	 	 echo $frm->getLabels('label_id'); ?></p>
    <p><label for="featured">Featured</label>
	<?php	 	 echo $frm->boolean('featured'); ?></p>
<?php	 	
}

function WPArtist_Meta_Labels($post)
{
	wp_nonce_field( plugin_basename( __FILE__ ), 'wpartist_class_nonce' );
	$frm = new WPArtistForm($post->ID);
	?>

    <p><label for="featured">Featured</label>
	<?php	 	 echo $frm->boolean('featured'); ?></p>
<?php	 	
}

function WPArtist_Meta_Music($post)
{
	wp_nonce_field( plugin_basename( __FILE__ ), 'wpartist_class_nonce' );
	$frm = new WPArtistForm($post->ID);
	$download_id    = get_post_meta($post->ID, 'back_cover_id', true);
	?>

	<p><label for="artist_id">Artist</label>
	<?php	 	 echo $frm->getArtists('artist_id'); ?></p>
    <p><label for="featured">Featured</label>
	<?php	 	 echo $frm->boolean('featured'); ?></p>
    <p><label for="release_date">Release Date</label>
	<?php	 	 echo $frm->text('release_date'); ?></p>
    <p><label for="amazon_url">Amazon Url</label>
	<?php	 	 echo $frm->text('amazon_url'); ?></p>
    <p><label for="itunes_url">iTunes Url</label>
	<?php	 	 echo $frm->text('itunes_url'); ?></p>
  <p>
      <label for="itunes_url">Custom Link 1</label><?php	 echo $frm->text('custom_url_1'); ?>Custom Link Text 1
	<?php	 	 echo $frm->text('custom_txt_1'); ?></p>
    <p><label for="itunes_url">Custom Link 2</label>
	<?php	 	 echo $frm->text('custom_url_2'); ?>Custom Link Text 2
	<?php	 	 echo $frm->text('custom_txt_2'); ?></p>
    <p><label for="itunes_url">Custom Link 3</label>
	<?php	 	 echo $frm->text('custom_url_3'); ?>Custom Link Text 3
	<?php	 	 echo $frm->text('custom_txt_3'); ?></p>
   <p> <label for="itunes_url">Custom Link 4</label>
	<?php	 	 echo $frm->text('custom_url_4'); ?>Custom Link Text 4
	<?php	 	 echo $frm->text('custom_txt_4'); ?></p>
    <p><label for="itunes_url">Custom Link 5</label>
	<?php	 	 echo $frm->text('custom_url_5'); ?>Custom Link Text 5
	<?php	 	 echo $frm->text('custom_txt_5'); ?></p>
    <p><label for="back_cover">Back Cover</label>
    <?php	 echo $frm->media('back_cover'); ?>
<?php	 	
}

/* Save the meta box's post metadata. */
function wpa_artist_save_meta_front( $post_id, $post ) {
	
	
	 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	
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
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
}
/* Save the meta box's post metadata. */
function wpa_artist_save_meta( $post_id, $post ) {
	
	
	 if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;
	  
	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['wpartist_class_nonce'] ) || !wp_verify_nonce( $_POST['wpartist_class_nonce'], plugin_basename( __FILE__ ) ) )
		{
		return $post_id;
		}

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
	
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
	
	//video_url
	$new_meta_value = ( isset( $_POST['video_url'] ) ? esc_url( $_POST['video_url'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'video_url';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//wpa_sc_url
	$new_meta_value = ( isset( $_POST['wpa_sc_url'] ) ? esc_url( $_POST['wpa_sc_url'] ) : '' );
	/* Get the meta key. */
	$meta_key = 'wpa_sc_url';
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

	$new_meta_value = ( isset( $_POST['custom_txt_1'] ) ? sanitize_text_field( $_POST['custom_txt_1'] ) : '' );
	$meta_key = 'custom_txt_1';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_txt_2'] ) ? sanitize_text_field( $_POST['custom_txt_2'] ) : '' );
	$meta_key = 'custom_txt_2';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_txt_3'] ) ? sanitize_text_field( $_POST['custom_txt_3'] ) : '' );
	$meta_key = 'custom_txt_3';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_txt_4'] ) ? sanitize_text_field( $_POST['custom_txt_4'] ) : '' );
	$meta_key = 'custom_txt_4';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_txt_5'] ) ? sanitize_text_field( $_POST['custom_txt_5'] ) : '' );
	$meta_key = 'custom_txt_5';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_url_1'] ) ? esc_url( $_POST['custom_url_1'] ) : '' );
	$meta_key = 'custom_url_1';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_url_2'] ) ? esc_url( $_POST['custom_url_2'] ) : '' );
	$meta_key = 'custom_url_2';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_url_5'] ) ? esc_url( $_POST['custom_url_5'] ) : '' );
	$meta_key = 'custom_url_5';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	$new_meta_value = ( isset( $_POST['custom_url_3'] ) ? esc_url( $_POST['custom_url_3'] ) : '' );
	$meta_key = 'custom_url_3';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	$new_meta_value = ( isset( $_POST['custom_url_4'] ) ? esc_url( $_POST['custom_url_4'] ) : '' );
	$meta_key = 'custom_url_4';
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//featured
	$new_meta_value = ( isset( $_POST['featured'] ) ? (int) $_POST['featured'] : '' );
	/* Get the meta key. */
	$meta_key = 'featured';
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
	//featured
	$new_meta_value = ( isset( $_POST['link_user'] ) ? (int) $_POST['link_user'] : '' );
	/* Get the meta key. */
	$meta_key = 'link_user';
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
	//Save Meta Value
	wpa_save_meta($post_id,$meta_key,$new_meta_value);
	
}

function wpa_save_meta($post_id,$meta_key,$new_meta_value)
{
	/* Get the meta value of the custom field key. */
	$meta_value = get_post_meta( $post_id, $meta_key, true );

	/* If a new meta value was added and there was no previous value, add it. */
	if ( $new_meta_value && '' == $meta_value )
		add_post_meta( $post_id, $meta_key, $new_meta_value, true );

	/* If the new meta value does not match the old value, update it. */
	elseif ( $new_meta_value && $new_meta_value != $meta_value )
		update_post_meta( $post_id, $meta_key, $new_meta_value );

	/* If there is no new meta value but an old value exists, delete it. */
	elseif ( '' == $new_meta_value && $meta_value )
		delete_post_meta( $post_id, $meta_key, $meta_value );
}
?>
