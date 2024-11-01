<?php 
//Artist
add_action('init', 'wpa_artist_taxonomies', 0);
add_action( 'init', 'wp_artists_type_artists' );
add_filter( 'manage_edit-wpa_artist_columns', 'wpartist_column_head' );
add_action( 'manage_wpa_artist_posts_custom_column', 'wpartist_columns_content');


//Labels
add_action( 'init', 'wp_artists_type_labels' );
add_filter( 'manage_edit-wpa_labels_columns', 'wplabels_column_head' );
add_action( 'manage_wpa_labels_posts_custom_column', 'wplabels_columns_content');



//Music
add_action( 'init', 'wp_artists_type_music' );
add_filter( 'manage_edit-wpa_music_columns', 'wpmusic_column_head' );
add_action( 'manage_wpa_music_posts_custom_column', 'wpmusic_columns_content');




function wp_artists_type_artists() {
    $labels = array( 
        'name' => _x( 'Artists', 'wpa_artist' ),
        'singular_name' => _x( 'Artist', 'wpa_artist' ),
        'add_new' => _x( 'Add New', 'wpa_artist' ),
        'add_new_item' => _x( 'Add New Artist', 'wpa_artist' ),
        'edit_item' => _x( 'Edit Artist', 'wpa_artist' ),
        'new_item' => _x( 'New Artist', 'wpa_artist' ),
        'view_item' => _x( 'View Artist', 'wpa_artist' ),
        'search_items' => _x( 'Search Artists', 'wpa_artist' ),
        'not_found' => _x( 'No artists found', 'wpa_artist' ),
        'not_found_in_trash' => _x( 'No artists found in Trash', 'wpa_artist' ),
        'parent_item_colon' => _x( 'Parent Artist:', 'wpa_artist' ),
        'menu_name' => _x( 'Artists', 'wpa_artist' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Artists Description',
        'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'wpartist_admin',
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array( 'with_front' => false, 'slug' => 'artist' ),
        'capability_type' => 'post'
    );
    register_post_type( 'wpa_artist', $args );
	$set = get_option('post_type_rules_flased_wpa_artist');
	if ($set !== true){
	   flush_rewrite_rules(false);
	   update_option('post_type_rules_flased_wpa_artist',true);
	}
	
}
function wpa_artist_taxonomies() {
    register_taxonomy('genres', array('wpa_artist','wpa_videos','wpa_music'), array(
        'hierarchical' => true,
        'slug' => 'genres',
        'label' => __('Genres', 'wpartist'),
        'query_var' => true,
        'rewrite' => true
    ));
}

function wpartist_column_head($columns) { 
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'label_id' => __( 'Label' ),
		'short_code' => __( 'Shortcode' ),
		'thumbnail' => __( 'Thumbnail' )
	);
	return $columns;
}
function wpartist_columns_content($column) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'label_id' :

			/* Get the post meta. */
			$label_id = get_post_meta( $post->ID, 'label_id', true );
			$label = get_the_title($label_id);
			/* If no duration is found, output a default message. */
			if ( empty( $label_id ) )
				echo __( 'Unknown' );
			else 
			echo $label;
			
			break;
		case 'short_code' :
			echo "<input type=\"text\" onfocus=\"this.select();\" readonly=\"readonly\" value='[wpa_profile id=\"$post->ID\"]' class=\"\" style=\"width:163px;\">";
			break;
		/* If displaying the 'genre' column. */
		case 'genres' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post->ID, 'genres' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'genres' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'genres', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No Genres' );
			}

			break;
			case 'thumbnail' :
			if(has_post_thumbnail($post->ID))
			{
				echo get_the_post_thumbnail( $post->ID,array(60,60));
				}
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
function wp_artists_type_labels() {
    $labels = array( 
        'name' => _x( 'Labels', 'wpa_labels' ),
        'singular_name' => _x( 'Label', 'wpa_labels' ),
        'add_new' => _x( 'Add New', 'wpa_labels' ),
        'add_new_item' => _x( 'Add New Label', 'wpa_labels' ),
        'edit_item' => _x( 'Edit Label', 'wpa_labels' ),
        'new_item' => _x( 'New Label', 'wpa_labels' ),
        'view_item' => _x( 'View Label', 'wpa_labels' ),
        'search_items' => _x( 'Search Labels', 'wpa_labels' ),
        'not_found' => _x( 'No labels found', 'wpa_labels' ),
        'not_found_in_trash' => _x( 'No labels found in Trash', 'wpa_labels' ),
        'parent_item_colon' => _x( 'Parent Label:', 'wpa_labels' ),
        'menu_name' => _x( 'Labels', 'wpa_labels' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Labels',
        'supports' => array( 'title', 'editor', 'comments', 'thumbnail' ),
        
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'wpartist_admin',
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array(  'with_front' => false, 'slug' => 'label' ),
        'capability_type' => 'post'
    );
	
    register_post_type( 'wpa_labels', $args );
	$set = get_option('post_type_rules_flased_wpa_labels');
	if ($set !== true){
	   flush_rewrite_rules(false);
	   update_option('post_type_rules_flased_wpa_labels',true);
	}
}

function wplabels_column_head($columns) { 
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'short_code' => __( 'Shortcode' ),
		'thumbnail' => __( 'Logo' )
	);
	return $columns;
}
function wplabels_columns_content($column) {
	global $post;

	switch( $column ) {
			case 'short_code' :
			echo "<input type=\"text\" onfocus=\"this.select();\" readonly=\"readonly\" value='[wpa_label id=\"$post->ID\"]' class=\"\" style=\"width:163px;\">";
		break;
			case 'thumbnail' :
			if(has_post_thumbnail($post->ID))
			{
				echo get_the_post_thumbnail( $post->ID,array(60,60));
				}
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

function wp_artists_type_music() {
     $labels = array( 
        'name' => _x( 'Music', 'wpa_music' ),
        'singular_name' => _x( 'Label', 'wpa_music' ),
        'add_new' => _x( 'Add New', 'wpa_music' ),
        'add_new_item' => _x( 'Add New Music', 'wpa_music' ),
        'edit_item' => _x( 'Edit Music', 'wpa_music' ),
        'new_item' => _x( 'New Music', 'wpa_music' ),
        'view_item' => _x( 'View Music', 'wpa_music' ),
        'search_items' => _x( 'Search Music', 'wpa_music' ),
        'not_found' => _x( 'No Music found', 'wpa_music' ),
        'not_found_in_trash' => _x( 'No Music found in Trash', 'wpa_music' ),
        'parent_item_colon' => _x( 'Parent Music:', 'wpa_music' ),
        'menu_name' => _x( 'Music', 'wpa_music' ),
    );

    $args = array( 
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Create a discography for each artists. Embed SoundCloud and Widgets for mp3 player.',
        'supports' => array( 'title', 'editor','comments', 'thumbnail' ),
         'public' => true,
        'show_ui' => true,
        'show_in_menu' => 'wpartist_admin',
        
        
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => array(  'with_front' => false, 'slug' => 'music' ),
        'capability_type' => 'post'
    );
    register_post_type( 'wpa_music', $args );
	$set = get_option('post_type_rules_flased_wpa_music');
	if ($set !== true){
	   flush_rewrite_rules(false);
	   update_option('post_type_rules_flased_wpa_music',true);
	}
}

function wpmusic_column_head($columns) { 
		$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'artist' => __( 'Artist' ),
		'short_code' => __( 'Shortcode' ),
		'release_date' => __( 'Release Date' ),
		'format' => __( 'Format' ),
		'thumbnail' => __( 'Thumbnail' )
	);
	return $columns;
}
function wpmusic_columns_content($column) {
	global $post;

	switch( $column ) {

		case 'artist' :

			/* Get the post meta. */
			$artist_id = get_post_meta( $post->ID, 'artist_id', true );
			$artist = get_the_title($artist_id);
			/* If no duration is found, output a default message. */
			if ( empty( $artist_id ) )
				echo __( 'Unknown' );
			else echo $artist;
			
			break;
			
			case 'short_code' :
			echo "<input type=\"text\" onfocus=\"this.select();\" readonly=\"readonly\" value='[wpa_music_item id=\"$post->ID\"]' class=\"\" style=\"width:163px;\">";
		break;
		
		case 'release_date' :

			/* Get the post meta. */
			$release_date = get_post_meta( $post->ID, 'release_date', true );
			
			/* If no duration is found, output a default message. */
			if ( empty( $release_date ) )
				echo __( 'Unknown' );
			else echo $release_date;
			
			break;
		/* If displaying the 'genre' column. */
		case 'format' :

			/* Get the genres for the post. */
			$terms = get_the_terms( $post->ID, 'format' );

			/* If terms were found. */
			if ( !empty( $terms ) ) {

				$out = array();

				/* Loop through each term, linking to the 'edit posts' page for the specific term. */
				foreach ( $terms as $term ) {
					$out[] = sprintf( '<a href="%s">%s</a>',
						esc_url( add_query_arg( array( 'post_type' => $post->post_type, 'format' => $term->slug ), 'edit.php' ) ),
						esc_html( sanitize_term_field( 'name', $term->name, $term->term_id, 'format', 'display' ) )
					);
				}

				/* Join the terms, separating them with a comma. */
				echo join( ', ', $out );
			}

			/* If no terms were found, output a default message. */
			else {
				_e( 'No Formats Selected' );
			}

			break;
			case 'thumbnail' :
			if(has_post_thumbnail($post->ID))
			{
				echo get_the_post_thumbnail( $post->ID,array(60,60));
				}
			break;
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}
?>