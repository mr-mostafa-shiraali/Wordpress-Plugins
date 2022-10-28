<?php
/**
Plugin Name: Post ID Optimizer
Plugin URI: https://mypgr.ir/postidoptimizer/
Description: Reuse Missing Id in Post Tables
Version: 1.0.1
Author: <a href="https://mypgr.ir/">Mostafa Shiraali</a>
Author URI: https://mypgr.ir/
License: A "Slug" license name e.g. GPL2
Text Domain: postidopti
Domain Path: /languages
 */
 
postidoptimizer::init();
class postidoptimizer
{
	public static function init()
	{

	add_action('init',array(__CLASS__,'lang_init'));
	add_action('admin_init', array(__CLASS__,'lang_init'));

	register_activation_hook( __FILE__, array(__CLASS__,'active'));
	register_deactivation_hook( __FILE__, array(__CLASS__,'deactivate'));



	}
	
 public static function active()
 {
		$wpinc=(defined( 'WPINC' )) ? WPINC:"wp-includes";
		$filedir=ABSPATH . WPINC;
		
		$contents = file_get_contents($filedir."/post.php");
		$contents = str_replace('$import_id             = isset( $postarr[\'import_id\'] ) ? $postarr[\'import_id\'] : 0;',
		'/*Mypgr.ir*/global $wpdb;$row = $wpdb->get_row("SELECT MIN(t1.ID + 1) AS nextID FROM $wpdb->posts t1 LEFT JOIN $wpdb->posts t2 ON t1.ID + 1 = t2.ID WHERE t2.ID IS NULL" );$import_id =$row->nextID;/*Mypgr.ir*/', $contents );
		file_put_contents($filedir."/post.php", $contents );

 }
 public static function deactivate(){
		$wpinc=(defined( 'WPINC' )) ? WPINC:"wp-includes";
		$filedir=ABSPATH . WPINC;
		$contents = file_get_contents($filedir."/post.php");
		$contents = str_replace('/*Mypgr.ir*/global $wpdb;$row = $wpdb->get_row("SELECT MIN(t1.ID + 1) AS nextID FROM $wpdb->posts t1 LEFT JOIN $wpdb->posts t2 ON t1.ID + 1 = t2.ID WHERE t2.ID IS NULL" );$import_id =$row->nextID;/*Mypgr.ir*/','$import_id             = isset( $postarr[\'import_id\'] ) ? $postarr[\'import_id\'] : 0;', $contents );
		file_put_contents($filedir."/post.php", $contents );

	 
	 
 }

 public static function lang_init()
 {
   load_plugin_textdomain( 'postidopti', false,dirname( plugin_basename( __FILE__ ) ) .'/languages/' );
 }
 






}
?>