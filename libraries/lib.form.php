<?php	 	
/**
* WPArtist Form Class
* By: B4uCode | www.b4ucode.com
*/
class WPArtistForm {
	
  public $id;
  
  public function __construct($id){
  		$this->id = $id;
  }
  
  public function FormValue($key)
  {
  		$value = get_post_meta($this->id, $key, $single=true);
		if(empty($value))
		{ $value = "";}
		return $value;
  }
  
  public function text($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
  		return '<input name="'.$name.'" value="'.$this->FormValue($name).'" '.$attributes.' />';
  }
  
  public function getLabels($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$check = get_post_meta($this->id, $name, $single=true);
		$args = array( 'post_type' => 'wpa_labels', 'orderby' => 'title', 'order'=>'ASC', 'posts_per_page' => -1 );
		$loop = new WP_Query( $args );
		$html ="";
		$html.='<select name="'.$name.'" '.$attributes.'>';
		// Loop
		while ( $loop->have_posts() ) : $loop->the_post();
			 $id =  get_the_ID();
			 $title = get_the_title($id);
			 if($check == $id){$checked= 'selected="selected"';}else{$checked= '';}
			$html .= '<option value="'. $id.'" '.$checked.'>'. $title.'</option>';
		endwhile;
		$html .= "</select>";
		// Reset Post Data
		wp_reset_postdata();
  		return $html;
  }
  
  public function getArtists($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$check = get_post_meta($this->id, $name, $single=true);
		$args = array( 'post_type' => 'wpa_artist', 'orderby' => 'title', 'order'=>'ASC', 'posts_per_page' => -1 );
		$loop = new WP_Query( $args );
		$html ="";
		$html.='<select name="'.$name.'" '.$attributes.'>';
		if($check == $id){$checked= 'selected="selected"';}else{$checked= '';}
		$html .= '<option value="0" '.$checked.'>-Select Artist-</option>';
		// Loop
		while ( $loop->have_posts() ) : $loop->the_post();
			 $id =  get_the_ID();
			 $title = get_the_title($id);
			 if($check == $id){$checked= 'selected="selected"';}else{$checked= '';}
			$html .= '<option value="'. $id.'" '.$checked.'>'. $title.'</option>';
		endwhile;
		$html .= "</select>";
		// Reset Post Data
		wp_reset_postdata();
  		return $html;
  }
  
  public function getArtistsByUser($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		global $current_user;
		$check = get_post_meta($this->id, $name, $single=true);
		$args = array( 
		'post_type' => 'wpa_artist', 
		'orderby' => 'title', 
		'order'=>'ASC',
		'meta_query' => array(
				array(
					'key' => 'link_user',
					'value' => $current_user->ID,
					'compare' => 'IN'
				)
   			 )
		);
		$loop = new WP_Query( $args );
		$html ="";
		$html.='<select name="'.$name.'" '.$attributes.'>';
		if($check == $id){$checked= 'selected="selected"';}else{$checked= '';}
		$html .= '<option value="0" '.$checked.'>-Select Artist-</option>';
		// Loop
		while ( $loop->have_posts() ) : $loop->the_post();
			 $id =  get_the_ID();
			 $title = get_the_title($id);
			 if($check == $id){$checked= 'selected="selected"';}else{$checked= '';}
			$html .= '<option value="'. $id.'" '.$checked.'>'. $title.'</option>';
		endwhile;
		$html .= "</select>";
		// Reset Post Data
		wp_reset_postdata();
  		return $html;
  }
  
 
  public function getMusic($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$check = get_post_meta($this->id, $name, $single=true);
		$args = array( 'post_type' => 'wpa_music', 'orderby' => 'title', 'order'=>'ASC', 'posts_per_page' => -1 );
		$loop = new WP_Query( $args );
		$html ="";
		$html.='<select name="'.$name.'" '.$attributes.'>';
		// Loop
		while ( $loop->have_posts() ) : $loop->the_post();
			 $id =  get_the_ID();
			 $title = get_the_title($id);
			 if($check == $id){$checked= 'selected="selected"';}else{$checked= '';}
			$html .= '<option value="'. $id.'" '.$checked.'>'. $title.'</option>';
		endwhile;
		$html .= "</select>";
		// Reset Post Data
		wp_reset_postdata();
  		return $html;
  }
  
  
  public function textarea($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox" rows="5" cols="60"';
		}
  		return '<textarea name="'.$name.'" '.$attributes.'>'.$this->FormValue($name).'</textarea>';
  }
  
  public function day($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$check = get_post_meta($this->id, $name, $single=true);	
		$html="";
		$html.='<select name="'.$name.'" '.$attributes.'>'; 
			for($i=1;$i<=31;$i++){
			if($check == $i){$selected= 'selected="selected"';}
			$html .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>"';
			$selected = '';
			}
		$html .= "</select>";
  		return $html;
  }
  
  public function month($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$months_ar= array('Jan'=>'January','Feb'=>'February','Mar'=>'March','Apr'=>'April','May'=>'May','Jun'=>'June','Jul'=>'July','Aug'=>'Aug','Sep'=>'September','Oct'=>'October','Nov'=>'November','Dec'=>'December');
		$check = get_post_meta($this->id, $name, $single=true);	
		$html="";
		$html.='<select name="'.$name.'" '.$attributes.'>'; 
			foreach($months_ar as $key => $value){
			if($check == $key){$selected= 'selected="selected"';}
			$html .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>"';
			$selected= '';
			}
		$html .= "</select>";
  		return $html;
  }
   public function media($name,$attributes=""){
   		$html="";
		$html.="<span class='upload'>
        <input type='text' id='wptuts_logo' class='regular-text text-upload' name='".$name."' value='".$this->FormValue($name)."'/>
        <input type='button' class='button button-upload' value='Upload an image'/></br>
        <img style='max-width: 300px; display: block;' src='".$this->FormValue($name)."' class='preview-upload'/>
    </span>";
		return $html;
   }
   
   public function boolean($name,$attributes="")
  {
  		if(empty($attributes))
		{
			$attributes 	=	'class="inputbox"';
		}
		$check = get_post_meta($this->id, $name, $single=true);
		if($check == 0){$checked0= 'selected="selected"';}
		if($check == 1){$checked1= 'selected="selected"';}
		
		$html="";
		$html.='<select name="'.$name.'" '.$attributes.'>'; 
			$html .= '<option value="0" '.$checked0.'>No</option>"';
			$html .= '<option value="1" '.$checked1.'>Yes</option>"';
		$html .= "</select>";
  		return $html;
  }
}
?>