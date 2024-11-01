<?php	 	 
 /*
   Plugin Name: WPArtists
   Plugin URI: http://b4ucode.com
   Description: WP Artists Manager is an all in one WordPress Solution to managing musical artists. Easily build band websites and fill in Artists' Biography, Videos, Gigs + Events, Discography and more. This plugin was brought to you by B4uCode.
   Version: 0.0.2
   Author: B4uCode
   Author URI: http://b4ucode.com
   License: GPL2
   */
 	//Include the database file
	include("libraries/core.php");
	
	add_action( 'init', 'wpa_scripts' );
	add_action( 'init', 'wpa_photos_scripts' );
	add_action( 'init', 'wpa_media_scripts' );
	add_action("wp_ajax_wpa_process_request", "wpa_process_request");
	add_action("wp_ajax_nopriv_wpa_process_request", "wpa_process_request");		

	
	add_theme_support( 'post-thumbnails' ); 
	
	function wpa_add_css()
	{
		if (is_admin()) {
		
		}else{
		wp_register_style( 'wpartist-main-style', plugins_url( '/css/main.css', __FILE__ ), array(), '20120208', 'all' );
		wp_enqueue_style( 'wpartist-main-style' );
		}
	}
	add_action( 'init', 'wpa_add_css' );
	function wpa_photos_scripts()
	{
		if (is_admin()) {
		
		}else{
		 wp_register_script( "jgallery",  plugins_url( '/js/jquery.colorbox.js', __FILE__ ) ); 
		 wp_register_script( "photo-script",  plugins_url( '/js/photo-script.js', __FILE__ ) );
		 wp_register_style( 'slidecss', plugins_url( '/css/slideshow.css', __FILE__ ), array(), '20120208', 'all' );	
		 }
	}
	function remove_wmp_image_sizes( $sizes) {
    
	  
	    unset( $sizes['thumbnail']);
        unset( $sizes['medium']);
        unset( $sizes['large']);
		
        return $sizes;
		
}
	 $edit = $_GET['wpa_edit'];
	 if($edit == 'edit'){
		add_filter('image_size_names_choose', 'remove_wmp_image_sizes');
	 }
	function wpa_media_scripts()
	{
		 global $wp_version;
		if ( $wp_version >= 3.5 ) {
    		wp_register_script('wpa_upload', plugins_url( '/js/uploader.js', __FILE__ ), array('jquery','media-upload','thickbox'));
		wp_enqueue_script('wpa_upload');
		//wp_enqueue_media();
		}
		if(function_exists( 'wp_enqueue_media' )){
		wp_register_script('wpa_upload', plugins_url( '/js/uploader.js', __FILE__ ), array('jquery','media-upload','thickbox'));
		wp_enqueue_script('wpa_upload');
		//wp_enqueue_media();
		}else{
			wp_register_script('upload-34', plugins_url( '/js/uploader34.js', __FILE__ ), array('jquery','media-upload','thickbox'));
			 wp_localize_script( 'upload-34', 'myUpload', array( 'uploader' => admin_url( 'media-upload.php') )); 
			wp_enqueue_style('thickbox');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('thickbox');
			wp_enqueue_script('upload-34');
		}
		 wp_enqueue_style( 'thickbox' ); // Stylesheet used by Thickbox
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'media-upload' );
		 wp_enqueue_script( 'wpa-media', plugins_url( '/js/media.js', __FILE__ ), array( 'thickbox', 'media-upload' ) );
	}
	function wpa_scripts()
	{
    wp_enqueue_script('jquery');
	
	

	wp_register_script( "wpa_votes",  plugins_url( '/js/wpa_votes.js', __FILE__ ) );
	 wp_enqueue_script('wpa_votes');
	wp_register_script( "my_voter_script",  plugins_url( '/js/wpa_admin.js', __FILE__ ) );
   wp_localize_script( 'my_voter_script', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php'),'loader' => plugins_url( '/images/loading.gif', __FILE__ ) )); 
	wp_enqueue_script( 'wpa_admin' );
	wp_enqueue_script( 'my_voter_script' );
	}
	function wpa_souncloud_load()
	{
		$result = array();
		
		$offset 		=  sanitize_title($_REQUEST['offset']);
		$artist_id 		=  sanitize_title($_REQUEST['artist_id']);
		$result_view	=  getMoreSC($artist_id ,$count=4,$offset);
		if($result_view){
		$result['result']=$result_view;
		$result['type']='success';
		}else{
			$result['type']='fail';
		}
		$result['count']=2;
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			  $result = json_encode($result);
			  echo $result;
		   }
		   else {
			  header("Location: ".$_SERVER["HTTP_REFERER"]);
		   }
	
	   die();
	}
	
	
	
	
	function wpa_process_request() {
	
	   if ( !wp_verify_nonce( $_REQUEST['nonce'], "wpa_link_nonce")) {
		  exit("No naughty business please");
	   }   
		$object_id =  sanitize_title($_REQUEST['object']);
		$artist_id =  (int)$_REQUEST['artist_id'];
		$count =  (int)$_REQUEST['count'];
		$offset =  (int)$_REQUEST['offset'];
		if(empty($count))
		{
			$count = 4;
		}else{
		$count = 20;
		}
		
		switch ($object_id)
		{
		case 'music':
		  $result['result'] = getMusic($artist_id,$count,$offset);
		  break;
		case 'biography':
		  $result['result'] = getBiography($artist_id,$count=4);
		  break;
		default:
		  $result['result'] = wpa_profile_func();
		}	
		  $result['type'] = "success";
		  $result['count'] = $count;
		 
		   if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			  $result = json_encode($result);
			  echo $result;
		   }
		   else {
			  header("Location: ".$_SERVER["HTTP_REFERER"]);
		   }
	   die();
	}
   ?>