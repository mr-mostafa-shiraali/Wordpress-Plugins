<?php
/**
Plugin Name: Vertical menu
Plugin URI: http://ctboard.com/
Description: This Plugin Show All Categories In Vertical menu Widget.
Version: 1.1.5
Author: <a href="http://ctboard.com/">Mostafa Shiraali</a>
Author URI: http://ctboard.com/
License: A "Slug" license name e.g. GPL2
Text Domain: vmenu
Domain Path: /languages
 */
VerticalMenu::init();
class VerticalMenu
{
	public static function init()
	{
	add_action('admin_init',array(__CLASS__,'registersetting'));
	add_action('init',array(__CLASS__,'lang_init'));
	add_action('admin_init', array(__CLASS__,'lang_init'));
	add_action('admin_menu', array(__CLASS__,'menu'));
	add_action('widgets_init', array(__CLASS__,'widget_vmenu'));
	add_action( 'wp_enqueue_scripts', array(__CLASS__,'script'));
	register_activation_hook( __FILE__, array(__CLASS__,'active'));
	register_deactivation_hook( __FILE__, array(__CLASS__,'deactivate'));
	}
 public static function active()
 {
 add_option('vmw_dir',"rtl","Menu Direction");
 add_option('vmw_theme',"defualt","Menu Theme");
 }
 public static function registersetting()
 {
 register_setting('pctriks_vmw_opt','vmw_dir');
 register_setting('pctriks_vmw_opt','vmw_theme');
 }
  public static function deactivate()
 {
 delete_option('vmw_dir');
 delete_option('vmw_theme');
 }

 public static function lang_init()
 {
   load_plugin_textdomain( 'vmenu', false,dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
 }

 public static function menu() {
	add_options_page(__("Vertical menu","vmenu"), __("Vertical menu","vmenu"), 10, __FILE__,array(__CLASS__,"display_options"));
}
public static function display_options()
{
?>
	<div class="wrap">
	<h2><?php _e("Vertical menu Option","vmenu")?></h2>        
	<form method="post" action="options.php">
	<?php settings_fields('pctriks_vmw_opt'); ?>
	<table class="form-table">
	    <tr valign="top">
        <th scope="row"><label><?php _e("Menu Direction","vmenu");?></label></th>
		<td><span class="description"><?php _e("Select Menu Direction","vmenu")?></span></td>
		<td>
		<select name="vmw_dir">
		<option value="rtl" <?php if ( get_option('vmw_dir') == "rtl" ) echo 'selected="selected"'; ?>><?php _e("Right To Left","vmenu");?></option>
		<option value="ltr" <?php if ( get_option('vmw_dir') == "ltr" ) echo 'selected="selected"'; ?>><?php _e("Left To Right","vmenu");?></option>
		</select>
		</td>
        </tr>	
		<tr valign="top">
        <th scope="row"><label><?php _e("Menu Theme","vmenu");?></label></th>
		<td><span class="description"><?php _e("Select Menu theme","vmenu")?></span></td>
		<td>
		<select name="vmw_theme">
		<option value="defualt" <?php if ( get_option('vmw_theme') == "defualt" ) echo 'selected="selected"'; ?>><?php _e("Defualt","vmenu");?></option>
		<option value="accor" <?php if ( get_option('vmw_theme') == "accor" ) echo 'selected="selected"'; ?>><?php _e("Simple Accordion","vmenu");?></option>
		<option value="blor" <?php if ( get_option('vmw_theme') == "blor" ) echo 'selected="selected"'; ?>><?php _e("Black-Orange","vmenu");?></option>
		<option value="blgr" <?php if ( get_option('vmw_theme') == "blgr" ) echo 'selected="selected"'; ?>><?php _e("Black-Green","vmenu");?></option>
		<option value="blblu" <?php if ( get_option('vmw_theme') == "blblu" ) echo 'selected="selected"'; ?>><?php _e("Black-Blue","vmenu");?></option>
		<option value="blye" <?php if ( get_option('vmw_theme') == "blye" ) echo 'selected="selected"'; ?>><?php _e("Black-Yellow","vmenu");?></option>
		<option value="blpi" <?php if ( get_option('vmw_theme') == "blpi" ) echo 'selected="selected"'; ?>><?php _e("Black-Pink","vmenu");?></option>
		<option value="cgb" <?php if ( get_option('vmw_theme') == "cgb" ) echo 'selected="selected"'; ?>><?php _e("CSS3-Gray-Blue","vmenu");?></option>
		<option value="cggr" <?php if ( get_option('vmw_theme') == "cggr" ) echo 'selected="selected"'; ?>><?php _e("CSS3-Gray-green","vmenu");?></option>
		<option value="cgye" <?php if ( get_option('vmw_theme') == "cgye" ) echo 'selected="selected"'; ?>><?php _e("CSS3-Gray-Yellow","vmenu");?></option>
		<option value="cgr" <?php if ( get_option('vmw_theme') == "cgr" ) echo 'selected="selected"'; ?>><?php _e("CSS3-Gray-red","vmenu");?></option>
		<option value="cbgr" <?php if ( get_option('vmw_theme') == "cbgr" ) echo 'selected="selected"'; ?>><?php _e("CSS3-Black-Green","vmenu");?></option>
		<option value="turq" <?php if ( get_option('vmw_theme') == "turq" ) echo 'selected="selected"'; ?>><?php _e("Turquoise","vmenu");?></option>
		</select>
		</td>
        </tr>	
	</table>
<?php submit_button(); ?>
		</form><br/><br/>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="A6CRNP7LB2FFQ">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
		
	</div>
<?php
}
/************************ SUB MENU *****************************/

public static function sublevel($catid)
{
global $wpdb;
$subs='';
$vmw_theme=get_option('vmw_theme');
$cat_tax = $wpdb->get_results("SELECT $wpdb->term_taxonomy.term_id,$wpdb->terms.name
									FROM $wpdb->term_taxonomy
									INNER JOIN $wpdb->terms
									WHERE $wpdb->term_taxonomy.term_id=$wpdb->terms.term_id AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.parent = $catid
									ORDER BY $wpdb->terms.name ASC");
			if($vmw_theme="accor")
			{
			foreach($cat_tax as $cat)
			{
			$catlink=esc_url(get_category_link($cat->term_id));
			$parent = $wpdb->get_results("SELECT * FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND parent = $cat->term_id");
			if($parent)
			{
			$subs .='<li><a href="'.$catlink.'">'.$cat->name.'</a></li>'.VerticalMenu::sublevel($cat->term_id);
			}
			else
			{
			$subs .='<li><a href="'.$catlink.'">'.$cat->name.'</a></li>';
			}
			}
			}
			else
			{
			foreach($cat_tax as $cat)
			{
			$catlink=esc_url(get_category_link($cat->term_id));
			$parent = $wpdb->get_results("SELECT * FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND parent = $cat->term_id");
			if($parent)
			{
			$subs .='<li>';
			$subs .='<a href="'.$catlink.'">'.$cat->name.'</a><ul class="sub-menu">';
			$subs .=VerticalMenu::sublevel($cat->term_id);
			$subs .='</ul></li>';
			}
			else
			{
			$subs .='<li><a href="'.$catlink.'">'.$cat->name.'</a></li>';
			$level=$level+1;
			}
			}
			}


return $subs;
}

/************************ SUB MENU *****************************/

public static function widget()
{
global $wpdb;
$menu='';
$vmw_theme=get_option('vmw_theme');
			if($vmw_theme="accor")
			{
			$menu .='<div id="navigation">';
			}
			else
			{
			$menu .='<div id="navigation"><ul>';
			}
 $cat_tax = $wpdb->get_results("SELECT $wpdb->term_taxonomy.term_id,$wpdb->terms.name,$wpdb->terms.slug
										FROM $wpdb->term_taxonomy
										INNER JOIN $wpdb->terms
										WHERE $wpdb->term_taxonomy.term_id=$wpdb->terms.term_id AND $wpdb->term_taxonomy.taxonomy = 'category' AND $wpdb->term_taxonomy.parent = '0'
										ORDER BY $wpdb->terms.name ASC");	
			if($vmw_theme="accor")
			{
			foreach ($cat_tax as $cat)
			{
			$catlink=esc_url(get_category_link($cat->term_id));
			$parent = $wpdb->get_results("SELECT * FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND parent = $cat->term_id");
			if($parent)
			{
			$menu .='<ul id="'.$cat->slug.'"><li><a href="#'.$cat->slug.'" id="'.$catlink.'">'.$cat->name.'</a></li><li><a href="'.$catlink.'">'.$cat->name.'</a></li>'.VerticalMenu::sublevel($cat->term_id).'</ul>';
			}
			else
			{
			$menu .='<ul id="'.$cat->slug.'"><li><a href="#'.$cat->slug.'">'.$cat->name.'</a></li><li><a href="'.$catlink.'">'.$cat->name.'</a></li></ul>';
			}
			
			}
			}
			else
			{
			foreach ($cat_tax as $cat)
			{
			$catlink=esc_url(get_category_link($cat->term_id));
			$parent = $wpdb->get_results("SELECT * FROM $wpdb->term_taxonomy WHERE taxonomy = 'category' AND parent = $cat->term_id");
			if($parent)
			{
			$menu .='<li><a href="'.$catlink.'">'.$cat->name.'</a><ul class="sub-menu">'.VerticalMenu::sublevel($cat->term_id).'</ul></li>';
			}
			else
			{
			$menu .='<li><a href="'.$catlink.'">'.$cat->name.'</a></li>';
			}
			
			}
			}



echo '<center>'.$menu.'</center>';
}
public static function widget_vmenu()
{
	function vmenu_widget($args)
	{
		extract($args);
		$options = get_option('vmenu_widget');
		$title = $options['title'];
		echo $before_widget;
		echo $before_title . $title . $after_title;
		VerticalMenu::widget();
		echo $after_widget;
	}
	function vmenu_widget_control()
	{
			$options = get_option('vmenu_widget');
		if ( !is_array($options) )
			$options = array('title'=>'');
		if ( $_POST['vmenu_title_submit'] ) {
			$options['title'] = strip_tags(stripslashes($_POST['pctrick_vmenu_title']));
			update_option('vmenu_widget', $options);
		}
		$title = htmlspecialchars($options['title'], ENT_QUOTES);
		?>
		<p style="text-align:right; direction:rtl">
		<label for="pctrick_vmenu_title"><?php _e("Title :","vmenu");?> <input style="width: 200px;" id="pctrick_vmenu_title" name="pctrick_vmenu_title" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<input type="hidden" id="vmenu_title_submit" name="vmenu_title_submit" value="1" />
		<?php
		}
	wp_register_sidebar_widget(20000,__("Vertical Menu Widget","vmenu"),'vmenu_widget');
	wp_register_widget_control(20000,__("Vertical Menu Widget","vmenu"),'vmenu_widget_control');		
}
public static function script()
{
$vmw_dir=get_option('vmw_dir');
$vmw_theme=get_option('vmw_theme');
	if($vmw_dir=="rtl")
	{
	wp_enqueue_style('vmenu', plugins_url( 'css/'.$vmw_theme.'_rtl.css', __FILE__ ));
	}
	else if($vmw_dir=="ltr")
	{
	wp_enqueue_style('vmenu',plugins_url( 'css/'.$vmw_theme.'.css', __FILE__  ));
	}
}

}
?>