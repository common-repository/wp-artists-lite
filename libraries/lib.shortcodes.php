<?php	 	
//Display Artists
add_shortcode( 'wpa_artists', 'wpa_artists_func' );
add_shortcode( 'wpa_profile', 'wpa_profile_func' );

//Artist Profile
add_shortcode( 'wpa_labels', 'wpa_labels_func' );
add_shortcode( 'wpa_label', 'wpa_label_func' );

//Display Music
add_shortcode( 'wpa_music', 'wpa_music_func' );
add_shortcode( 'wpa_music_item', 'wpa_profile_music' );

add_filter( 'the_content', 'wpa_the_content_filter', 20 );
function wpa_the_content_filter( $content ) {

	global $post;	
    if ( is_single()){
        if (is_singular( 'wpa_artist' )) {
		 $content = wpa_profile_func();
		}elseif(is_singular( 'wpa_music' )) {
			$content = wpa_profile_music();
		}
	}	
		
    return $content;
}




function getBiography($artist_id=0)
{
	 $page_data = get_page($artist_id);
	
  if ($page_data) {
    return '<div class="links agrid">
    	<h3>Biography</h3><div class="display_row">'.$page_data->post_content.'</div></div>';
  }
  else return false;
}

function getMusic($artist_id=0,$count=5,$offset="0")
{
 $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; 
$nonce = wp_create_nonce("wpa_link_nonce");
$args = array( 'post_type' => 'wpa_music', 'posts_per_page' => $count, 'offset' => $offset,'meta_query' => array(
		array(
			'key' => 'artist_id',
			'value' => $artist_id
		)
	) );
	
	// The Query
		$the_query = new WP_Query( $args );
		if($the_query->have_posts()):
		$html='';
		$html.='<div class="discography agrid">
    	<h3>Discography</h3>';
		$html.='<div class="display_row">';
		// The Loop
		while ( $the_query->have_posts() ) : $the_query->the_post();
            $html.='<div class="music_item">
                ';
				 if(has_post_thumbnail(get_the_ID()))
			{
        		$html.='<a href="'.get_permalink(get_the_ID()).'">'.get_the_post_thumbnail( get_the_ID(),array(110,110),array('style'=>'padding: 4px;
border: 1px #CCC solid;')).'</a>';
        	}else{
				$html.= '<a href="'.get_permalink(get_the_ID()).'"><img height="110"  width="110" class="jartists-120" src="' .plugins_url( 'images/no_prev.jpg' , dirname(__FILE__) ). '" ></a>';
				}
				 $html.='<span class="title" style="display:block; font-weight:bold;"><a href="'.get_permalink(get_the_ID()).'">'.substr(get_the_title(get_the_ID()),0,20).'</a></span>
            </div>';
         endwhile;
        $html.='<div class="clr"></div>';
		$html.='</div></div>';
	  // Reset Post Data
		wp_reset_postdata();
	return $html;
	else:
	return false;
	endif;
}

	
	function wpa_label_func($atts='')
	{
		extract(shortcode_atts(array(
		  'id' => '',
	   ), $atts));
	   
	   	if(empty($id)){
	   	$id = get_the_ID();
		}
		$post = get_post( $id , $output );
		$html='';
		$html.='<div class="item-page"><div class="image_file">';
		$html.='<h3>Artists</h3>';
		$html.= do_shortcode('[wpa_artists label_id="'.$id.'"]');
        if(has_post_thumbnail($id))
			{
        		$html.='<a href="'.get_permalink($id).'" class="jartists-450">'.get_the_post_thumbnail( $id,'large').'</a>';
        	}
		$html.='<h3>Description</h3>';
		$html.=$post->post_content;
		$html.='</div>';
		
		return $html;
	}
	function wpa_profile_music($atts='')
	{
		extract(shortcode_atts(array(
		  'id' => '',
	   ), $atts));
	   
	   	if(empty($id)){
	   	$id = get_the_ID();
		}
		$post = get_post( $id , $output );
		$artist_id = get_post_meta( $id , 'artist_id', true );
		$artist =  get_the_title($artist_id);
		$artist_url = get_permalink( $artist_id );
		
		//Get Meta Data
		$date_release = get_post_meta( $id , 'release_date', true );
		$amazon_url = get_post_meta( $id , 'amazon_url', true );
		$itunes_url = get_post_meta( $id , 'itunes_url', true );
		$custom_txt_1 = get_post_meta( $id , 'custom_txt_1', true );
		$custom_txt_2 = get_post_meta( $id , 'custom_txt_2', true );
		$custom_txt_3 = get_post_meta( $id , 'custom_txt_3', true );
		$custom_txt_4 = get_post_meta( $id , 'custom_txt_4', true );
		$custom_txt_5 = get_post_meta( $id , 'custom_txt_5', true );
		$custom_url_1 = get_post_meta( $id , 'custom_url_1', true );
		$custom_url_2 = get_post_meta( $id , 'custom_url_2', true );
		$custom_url_3 = get_post_meta( $id , 'custom_url_3', true );
		$custom_url_4 = get_post_meta( $id , 'custom_url_4', true );
		$custom_url_5 = get_post_meta( $id , 'custom_url_5', true );
		$custom_links = 
		array(
			array($custom_url_1,$custom_txt_1),
			array($custom_url_2,$custom_txt_2),
			array($custom_url_3,$custom_txt_3),
			array($custom_url_4,$custom_txt_4),
			array($custom_url_5,$custom_txt_5)
		);
		$html='';
		$html.='<div class="item-page">';
		$html.='<div class="d_image">';
				 if(has_post_thumbnail($id ))
			{
        		$html.='<a href="'.get_permalink($id ).'" class="jartists-450">'.get_the_post_thumbnail( $id ,'medium').'</a>';
        	}else{
				$html.= '<a href="'.get_permalink($id ).'" class="jartists-450"><img height="300" class="jartists-120" src="' .plugins_url( 'images/no_prev.jpg' , dirname(__FILE__) ). '" ></a> ';
				}
				$html.='</div>';
				$html.='<dl>';
  if($artist){
  $html.='<dt class="article-info-term">Artist</dt>

        <dd class="createdby"><a href="'.$artist_url.'">'.$artist.'</a></dd>';	
  }
  if($date_release){
  $html.='<dt class="s_releaseDate">Release Date</dt>
  <dd class="s_releaseDate">'.$date_release.'</dd>';
  }
$html.='</dl>';
 if($itunes_url || $amazon_url || !empty($custom_links)){
$html.='<div class="s_links">';
	 if($itunes_url){
	$html.='<a href="'.$itunes_url.'" target="_blank">Itunes</a>';
	}
	 if($amazon_url){
	$html.='<a href="'.$amazon_url.'" target="_blank">Amazon</a>';
	}
	foreach($custom_links as $item)
		{
			$html.='<a href="'.$item[0].'" target="_blank">'.$item[1].'</a>';
		}
$html.='</div>';
}
$html.='<div>';
 $html.='<div class="clr"></div>';
	$html.=$post->post_content;
$html.='</div>';
 $html.='<div class="clr"></div>';
		$html.='</div>';
		return  $html;
	}
	function wpa_profile_page($atts='')
	{
		extract(shortcode_atts(array(
		  'id' => '',
	   ), $atts));
	   
	   	if(empty($id)){
	   	$id = get_the_ID();
		}
		$post = get_post( $id , $output );
		$artist_id = get_post_meta( $id , 'artist_id', true );
		$artist =  get_the_title($artist_id);
		$artist_url = get_permalink( $artist_id );
		
		//Get Meta Data
		$html='';
		$html.='<div class="item-page">';
		$html.='<div class="d_image">';
				 if(has_post_thumbnail($id ))
			{
        		$html.='<a href="'.get_permalink($id ).'" class="jartists-450">'.get_the_post_thumbnail( $id ,'medium').'</a>';
        	}else{
				$html.= '<a href="'.get_permalink($id ).'" class="jartists-450"><img height="300" class="jartists-120" src="' .plugins_url( 'images/no_prev.jpg' , dirname(__FILE__) ). '" ></a> ';
				}
				$html.='</div>';
				$html.='<dl>';

  if($artist){
  $html.='<dt class="article-info-term">Artist</dt>

        <dd class="createdby"><a href="'.$artist_url.'">'.$artist.'</a></dd>';	
  }
$html.='</dl>';
 $html.='<div class="clr"></div>';
 $html.='<div>';
	$html.=do_shortcode($post->post_content);
$html.='</div>';
 $html.='<div class="clr"></div>';
		$html.='</div>';
		return  $html;
	}
	function wpa_profile_func($atts='')
	{
		extract(shortcode_atts(array(
		  'id' => '',
	   ), $atts));
	   
	   	if(empty($id)){
	   	$id = get_the_ID();
		}
	   $post = get_post( $id, $output );
	 $nonce = wp_create_nonce("wpa_link_nonce");
  	  $link = admin_url('admin-ajax.php?action=my_user_vote&post_id='.$post->ID.'&nonce='.$nonce);
	  $hashtag = '';
	   $label_id = get_post_meta( $id, 'label_id', true );
	   $label =  get_the_title($label_id);
	   $label_url = get_permalink( $label_id );
	   $music = getMusic($post->ID);

		$html='';
		$html.='<div class="item-page">';
		$html.='<div class="profile-menu">';
		$html.='<ul class="drop">
			<li><a href="'.$home_url.'">Home</a></li>
			<li><a href="javascript:void(0);" class="wpamenu" data-nonce="'.$nonce.'" data-artist_id="'.$post->ID.'" data-object="biography">Biography</a></li>';
			if($music):
			$html.='<li><a href="javascript:void(0);" class="wpamenu" data-nonce="'.$nonce.'" data-count="4" data-artist_id="'.$post->ID.'" data-object="music">Music</a></li>';
			endif;
	$html.='</ul>
	<div class="clr"></div>
	</div>';
		$html.='<div id="wpartist">';
		if($post->post_content):
        $html.='<div class="wpa_profile_info">
           <div class="biography"><h3>Biography</h3>';
			if(has_post_thumbnail($post->ID) || $post->post_content ):
		$html.='<div class="topArtistBar">';
		if(has_post_thumbnail($post->ID))
			{
        $html.=get_the_post_thumbnail( $post->ID,'thumbnail',array('align'=>'left','style'=>'margin-right:10px'));
        }
		if($post->post_content){
         $html.=substr(strip_tags($post->post_content,'<p><a><br />'),0,600).'[...]';
		 }
		 
		 $html.='</div>';
		 $html.='<div>';
		 	$wpa_show_fb = get_option('wpa_show_fb');
			$wpa_show_tw = get_option('wpa_show_tw');
			if($wpa_show_fb == 0){
		 	$html.='<div class="socialBox"><iframe src="//www.facebook.com/plugins/like.php?href='.get_permalink($post->ID).'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>';
	}
	 
	 if($wpa_show_tw  == 0){
	$html.='<div class="socialBox"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'.get_permalink($post->ID).'" data-via="'.$hashtag.'">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>';
}
		 
		 $html.='</div>';
		 $html.='
		 </div>
        </div><div class="clr"></div>';
		 endif;
		 $html.='<div class="wpa_artist_meta">';
		 	if($label_id){
				$html.=__(' Label : ','wpartists').'<span class=""><a href="'.$label_url.'">'.$label.'</a></span>';
			}
				$html.=get_the_term_list( $post->ID, 'genres', __(' Genre : ','wpartists'), ', ', '' );

				$html.='</div>
				<div class="clr"></div>';
			
         $html.='<div id="widgetBlocks">';
	 endif;
  
	if($music):
    $html.=$music;
	endif;

	
    $html.='<div class="clr"></div>
    </div>';
$html.='</div>';
return  $html;
	}
function wpa_get_the_content_by_id($post_id) {
  $page_data = get_page($post_id);
  if ($page_data) {
  	remove_shortcode('wpa_profile', $page_data->post_content);
    return do_shortcode($page_data->post_content);
  }
  else return false;
}
//Display Labels
add_shortcode( 'wpa_labels', 'wpa_labels_func' );
	function wpa_labels_func($atts)
	{
	$args = array( 'post_type' => 'wpa_labels', 'orderby' => 'title', 'order'=>'ASC' );
	// The Query
	$the_query = new WP_Query( $args );
	?>
	<div class="lblArtist">
	<div class="items">
	
				<div class="items_list">
	<?php	 	
	// The Loop
	while ( $the_query->have_posts() ) : $the_query->the_post();
		 $id = get_the_ID();
		?>
		 <div class="lblBox artists"><a  href="<?php	 	 echo get_permalink($id); ?>"><?php	 	 if(has_post_thumbnail(get_the_ID()))
				{
					echo get_the_post_thumbnail( $id ,array(100,100),array('class' => 'jartists-120'));
					}else{
					echo '<img height="100" class="jartists-120" src="' .plugins_url( 'images/no_prev.jpg' , dirname(__FILE__) ). '" > ';
					}
					?></a>
					<span class="title"><a  href="<?php	 	 echo  get_permalink(  $id ); ?>"><?php	 	 the_title(); ?></a></span>
					</div>
	
		<?php	 	
	endwhile;
	
	?>
	</div>
	
				<div class="clr"></div>
	
		</div>
	<?php	 	
			
	
			$big = 999999999; // need an unlikely integer
			
			echo paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $the_query->max_num_pages
			) );
		  // Reset Post Data
			wp_reset_postdata();
	?>
</div>
<?php	
	}

function wpa_artists_func($atts='')
	{
		extract(shortcode_atts(array(
		  'label_id' => '',
	   ), $atts));
	   
    $args = array( 'post_type' => 'wpa_artist', 'orderby' => 'title', 'order'=>'ASC' );
	if($label_id)
	{
		$label_query = $args['meta_query'] = array(
		array(
			'key' => 'label_id',
			'value' => $label_id
		));
		array_merge($args, $label_query);
	}
	// The Query
$the_query = new WP_Query( $args );
$html='';
$html.='<div class="lblArtist">
<div class="items">

            <div class="items_list">';
 	if($the_query->have_posts()):
// The Loop
while ( $the_query->have_posts() ) : $the_query->the_post();
	 $id = get_the_ID();

     $html.='<div class="lblBox artists"><a  href="'.get_permalink($id).'">';
	 	 if(has_post_thumbnail(get_the_ID()))
			{
				$html.=get_the_post_thumbnail( $id ,array(100,100),array('class' => 'jartists-120'));
				}else{
				$html.='<img height="100" class="jartists-120" src="' .plugins_url( 'images/no_prev.jpg' , dirname(__FILE__) ). '" > ';
				}
				$html.='</a>
                <span class="title"><a  href="'.get_permalink(  $id ).'">'.get_the_title($id).'</a></span>
                </div>';	 	
		endwhile;
		else:
		$html.='<span class="no_result">No Artists Found</span>';
		endif;
$html.='</div>
			<div class="clr"></div>
    </div>';
		$big = 999999999; // need an unlikely integer
		$html.= paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $the_query->max_num_pages
		) );
	  // Reset Post Data
		wp_reset_postdata();
$html.='</div>';
return $html;	 	
}

function wpa_music_func($atts='')
	{
		extract(shortcode_atts(array(
		  'artist_id' => '',
		  'order_by'  => 'release_date'
	   ), $atts));
	   global $wpdb;
   $querystr = "
    SELECT wposts.*
    FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
    WHERE wposts.ID = wpostmeta.post_id
    AND wpostmeta.meta_key = 'release_date'
    AND wposts.post_type = 'wpa_music'
    ORDER BY wpostmeta.meta_value DESC
    ";
	 $pageposts = $wpdb->get_results($querystr, OBJECT);
$html='';
$html.='<div class="lblArtist">
<div class="items">

            <div class="items_list">';
if($pageposts):
foreach ($pageposts as $post){
setup_postdata($post);
	 $id = $post->ID;

     $html.='<div class="lblBox artists"><a  href="'.get_permalink($id).'">';
	 	 if(has_post_thumbnail($post->ID))
			{
				$html.=get_the_post_thumbnail( $id ,array(100,100),array('class' => 'jartists-120'));
				}else{
				$html.='<img height="100" class="jartists-120" src="' .plugins_url( 'images/no_prev.jpg' , dirname(__FILE__) ). '" > ';
				}
				$html.='</a>
                <span class="title"><a  href="'.get_permalink(  $id ).'">'.get_the_title($id).'</a></span>
                </div>';	 	
		}
		else:
		$html.='<span class="no_result">No Artists Found</span>';
		endif;
$html.='</div>
			<div class="clr"></div>
    </div>';
		$big = 999999999; // need an unlikely integer
		$html.= paginate_links( array(
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => max( 1, get_query_var('paged') ),
			'total' => $the_query->max_num_pages
		) );
	  // Reset Post Data
		wp_reset_postdata();
$html.='</div>';
return $html;	 	
}
?>