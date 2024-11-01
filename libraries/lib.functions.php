<?php	 	 
function wpa_socialBox($url)
{
	$html.='<div class="socialBox"><iframe src="//www.facebook.com/plugins/like.php?href='.$url.'&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font&amp;colorscheme=light&amp;action=like&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" allowTransparency="true"></iframe></div>';
	
	$html.='<div class="socialBox"><a href="https://twitter.com/share" class="twitter-share-button" data-url="'.$url.'" data-via="'.$hashtag.'">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>';
	
}

function getYouTubeId($url)
{
  $url_string = parse_url($url, PHP_URL_QUERY);
  parse_str($url_string, $args);
  if(isset($args['v'])){
  	$args['type']	= 'youtube';
	$args['id']		=  $args['v'];
	
  }
  if (0 === preg_match('/^http:\/\/(www\.)?vimeo\.com\/(clip\:)?(\d+).*$/', $value, $match))
	{
		$error = 'the error';
	}
	else
	{
		$args['type']	= 'vimeo';
		$args['id']		=  $match[3];
	}
	return $args;
}

 function getArtistsSelect($name,$check="",$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		//$check = get_post_meta($this->id, $name, $single=true);
		$args = array( 'post_type' => 'wpa_artist', 'orderby' => 'title', 'order'=>'ASC' );
		$loop = new WP_Query( $args );
		$html ="";
		$html.='<select name="'.$name.'" '.$attributes.'>';
		// Loop
		while ( $loop->have_posts() ) : $loop->the_post();
			 $id =  get_the_ID();
			 $title = get_the_title($id);
			 if($check == $id){$checked= 'selected="selected"';}
			$html .= '<option value="'. $id.'" '.$checked.'>'. $title.'</option>';
		endwhile;
		$html .= "</select>";
		// Reset Post Data
		wp_reset_postdata();
  		return $html;
  }
  function booleanSelect($name,$check,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		if($check == 0){$checked0= 'selected="selected"';}
		if($check == 1){$checked1= 'selected="selected"';}
		
		$html="";
		$html.='<select name="'.$name.'" '.$attributes.'>'; 
			$html .= '<option value="0" '.$checked0.'>No</option>"';
			$html .= '<option value="1" '.$checked1.'>Yes</option>"';
		$html .= "</select>";
  		return $html;
  }
  	function typeSelect($name,$check,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$types = array('wpa_labels'=>'Labels','wpa_artists'=>'Artists','wpa_events'=>'Events','wpa_music'=>'Music','wpa_videos'=>'Videos');
		$html="";
		$html.='<select name="'.$name.'" '.$attributes.'>'; 
			foreach($types as $key=>$value):
			if($check == $id){$checked= 'selected="selected"';}
			$html .= '<option value="'.$key.'">'.$value.'</option>"';
			endforeach;
		$html .= "</select>";
  		return $html;
  }

?>