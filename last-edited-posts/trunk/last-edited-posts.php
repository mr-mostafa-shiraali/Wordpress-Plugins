<?php
/*
Plugin Name: Last Edited Posts
Plugin URI: https://link4share.ir/%d8%af%d8%a7%d9%86%d9%84%d9%88%d8%af-%d8%a7%d9%81%d8%b2%d9%88%d9%86%d9%87-%d9%88%d8%b1%d8%af%d9%be%d8%b1%d8%b3-%d8%a7%d8%a8%d8%b2%d8%a7%d8%b1%da%a9-%d9%86%d9%85%d8%a7%db%8c%d8%b4-%d8%a2%d8%ae%d8%b1/
Description: Add Widget For Show Last updated Posts.
Version: 1.0
Author: <a href="http://mypgr.ir">Mostafa Shiraali</a>
Author URI: http://mypgr.ir
License: GNU
Text Domain: lasteditedposts
Domain Path: /languages
*/
lasteditedposts::init();
class lasteditedposts
{
	public static function init()
	{
		add_action('admin_init', array(__CLASS__,'lasteditedposts_init') );
		add_action('init', array(__CLASS__,'lasteditedposts_lang_init'));
		add_action('widgets_init', array(__CLASS__,'widget_lasteditedposts_init'));
		add_action('admin_init', array(__CLASS__,'lasteditedposts_lang_init'));
		register_activation_hook( __FILE__, array(__CLASS__,'lasteditedposts_active') );
		register_deactivation_hook( __FILE__, array(__CLASS__,'lasteditedposts_deactivate') );

	}
	 public function lasteditedposts_active() { }
     public function lasteditedposts_init(){}
     public function lasteditedposts_deactivate(){}
	 public function lasteditedposts_lang_init()
	 {
	 load_plugin_textdomain( 'lasteditedposts', false,dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
     }



	public function widget_lasteditedposts_init()
	{
		register_widget( 'lep_Widget' );
	}

}

//Widget Class
class lep_Widget extends WP_Widget {
	
	// Set up the widget name and description.
	  public function __construct()
	  {
    $widget_options = array( 'classname' => 'lep_widget', 'description' => 'Show Last Updated Posts' );
    parent::__construct( 'lep_widget', 'Show Last Updated Posts', $widget_options );
	  }
	  
	  // Create the widget output.
  	public function widget($args, $instance)
	{
		global $wpdb;
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );
		$category = apply_filters( 'widget_category', $instance[ 'category' ] );
		$number = apply_filters( 'widget_number', $instance[ 'number' ] );
		$lasteditedposts='';
		$myrows = $wpdb->get_results( "SELECT a.ID, a.post_title FROM {$wpdb->posts} AS a
		INNER JOIN {$wpdb->term_relationships} AS b
		ON a.ID = b.object_id
		WHERE a.post_status = 'publish' AND b.term_taxonomy_id=$category ORDER BY a.post_modified_gmt DESC LIMIT 0,$number" );
		$lasteditedposts .='<ul id="lasteditedposts">';
		foreach ( $myrows as $row ) 
		{
					$lasteditedposts .='<li><a href="'.get_permalink($row->ID).'" target ="_blank">'.$row->post_title.'</a></li>';
		}
		$lasteditedposts .='</ul>';
		echo $args['before_widget'] . $args['before_title'] . $title . $args['after_title']; 
		echo $lasteditedposts;
		echo $args['after_widget'];		
	}
	
	 public function form( $instance ) {
	?>
    <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e("Title :","lasteditedposts");?></label>
      <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
    </p>
			<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category' ); ?>:</label>				
			
			<?php

			wp_dropdown_categories( array(
				'orderby'    => 'title',
				'hide_empty' => false,
				'name'       => $this->get_field_name( 'category' ),
				'id'         => $this->get_field_id( 'category' ),
				'class'      => 'widefat',
				'selected'   => $instance['category']

			) );

			?>

		</p>
				<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show' ); ?>: </label>
			<input type="text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" value="<?php echo $instance['number'] ; ?>" size="3" />
		</p>
	<?php
  }
  
    // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'category' ] = strip_tags( $new_instance[ 'category' ] );
    $instance[ 'number' ] = strip_tags( $new_instance[ 'number' ] );
    return $instance;
  }


	
}


?>