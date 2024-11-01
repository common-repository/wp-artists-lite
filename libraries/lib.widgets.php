<?php

class WpaAllinone_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
		'wpaallinone_widget', // Base ID
		'Wp Artists', // Name
		array(
			'description' => __( 'Display List of Artists', 'text_domain' )
		)
	);
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Artists', 'text_domain' );
		}
		if ( isset( $instance[ 'artist_id' ] ) ) {
			$artist_id = $instance[ 'artist_id' ];
		}
		if ( isset( $instance[ 'featured' ] ) ) {
			$featured = $instance[ 'featured' ];
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}
		?>
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <br />
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'type_id' ); ?>"><?php _e( 'Type:' ); ?></label> 
		<?php echo typeSelect($this->get_field_name( 'featured' ),$type_id); ?>
        </p>
        <p>
		<label for="<?php echo $this->get_field_id( 'artist_id' ); ?>"><?php _e( 'Artist:' ); ?></label> 
		<?php echo getArtistsSelect($this->get_field_name( 'artist_id' ),$artist_id); ?>
        </p>
        <p>
       <label for="<?php echo $this->get_field_id( 'featured' ); ?>"><?php _e( 'Featured:' ); ?></label> 
		<?php echo booleanSelect($this->get_field_name( 'featured' ),$featured); ?>
       </p>
         <p>
        <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:' ); ?></label> 
        <input  size="5" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = (int)$new_instance['count'];
		$instance['featured'] = (int)$new_instance['featured'];
		$instance['artist_id'] = (int)$new_instance['artist_id'];
		$instance['type_id'] = sanitize_text_field($new_instance['type_id']);
		return $instance;
	}
	public function widget( $args, $instance ) {
	$title = apply_filters('widget_title', $instance['title'] );
	if ( isset( $instance[ 'artist_id' ] ) ) {
			$artist_id = $instance[ 'artist_id' ];
		}
		if ( isset( $instance[ 'featured' ] ) ) {
			$featured = $instance[ 'featured' ];
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}
	echo $before_widget;
	// Display the widget title
	if ( $title )
		echo $before_title . $title . $after_title;
	
	
	$args2 = array( 'post_type' => 'wpa_artist', 'orderby' => 'title', 'order'=>'ASC','posts_per_page' => $count );
	if($label_id)
	{
		$label_query = $args['meta_query'] = array(
		array(
			'key' => 'label_id',
			'value' => $label_id
		));
		array_merge($args2, $label_query);
	}
	// The Query
	$the_query = new WP_Query( $args2 );
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
    </div></div>';
		echo $html;
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget( "wpaallinone_widget" );' ) );

//WPA MUSIC WIDGET
class Wpamusic_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
		'wpamusic_widget', // Base ID
		'WP Artist Discography', // Name
		array(
			'description' => __( 'Display List of Artists', 'text_domain' )
		)
	);
	}
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'Artists', 'text_domain' );
		}
		if ( isset( $instance[ 'artist_id' ] ) ) {
			$artist_id = $instance[ 'artist_id' ];
		}
		if ( isset( $instance[ 'featured' ] ) ) {
			$featured = $instance[ 'featured' ];
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}
		?>
        <p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> <br />
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
        <p>
		<label for="<?php echo $this->get_field_id( 'artist_id' ); ?>"><?php _e( 'Artist:' ); ?></label> 
		<?php echo getArtistsSelect($this->get_field_name( 'artist_id' ),$artist_id); ?>
        </p>
        <p>
       <label for="<?php echo $this->get_field_id( 'featured' ); ?>"><?php _e( 'Featured:' ); ?></label> 
		<?php echo booleanSelect($this->get_field_name( 'featured' ),$featured); ?>
       </p>
         <p>
        <label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Count:' ); ?></label> 
        <input  size="5" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>" />
		</p>
        <?php
	}
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;  
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = (int)$new_instance['count'];
		$instance['featured'] = (int)$new_instance['featured'];
		$instance['artist_id'] = (int)$new_instance['artist_id'];
		$instance['type_id'] = sanitize_text_field($new_instance['type_id']);
		return $instance;
	}
	public function widget( $args, $instance ) {
	$title = apply_filters('widget_title', $instance['title'] );
	if ( isset( $instance[ 'artist_id' ] ) ) {
			$artist_id = $instance[ 'artist_id' ];
		}
		if ( isset( $instance[ 'featured' ] ) ) {
			$featured = $instance[ 'featured' ];
		}
		if ( isset( $instance[ 'count' ] ) ) {
			$count = $instance[ 'count' ];
		}else{
			$count = 4;
		}
	echo $before_widget;
	// Display the widget title
	if ( $title )
		echo $before_title . $title . $after_title;
	
	
	$args2 = array( 'post_type' => 'wpa_music', 'orderby' => 'title', 'order'=>'ASC','posts_per_page' => $count );
	if($artist_id)
	{
		$label_query = $args2['meta_query'] = array(
		array(
			'key' => 'artist_id',
			'value' => $artist_id
		));
		array_merge($args2, $label_query);
	}
				// The Query
			$the_query = new WP_Query( $args2 );
			$id = get_the_ID();
			$artist_id = get_post_meta( $id, 'artist_id', true );
			$artist =  get_the_title($artist_id);
			$artist_url = get_permalink( $artist_id );
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
				<span class="artist_title"><a href="'.$artist_url.'">'.$artist.'</a></span>
                </div>';	 	
		endwhile;
		$html.='<div class="clr"></div>';
		else:
		$html.='<span class="no_result">No Items Found</span>';
		endif;
   		$html.='</div></div></div>';
		echo $html;
		echo $after_widget;
	}
}
add_action( 'widgets_init', create_function( '', 'register_widget( "wpamusic_widget" );' ) );