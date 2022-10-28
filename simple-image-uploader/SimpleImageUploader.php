<?php
/*
Plugin Name: Simple Image Uploader
Plugin URI: https://mypgr.ir/
Description: Automatically upload external images To media Library and replaces  in post.
Version: 1.0.0
Author: <a href="https://mypgr.ir/">Mostafa Shiraali</a>
Author URI: https://mypgr.ir/
License: GPL.
Text Domain: SimpleImageUploader
 */
 
SimpleImageUploader::init();
class SimpleImageUploader
{
	public static function init()
	{
			add_filter('wp_insert_post_data', array(__CLASS__, 'Save'), 10, 2);


	}



 public static function Save($data, $postarr)
 {
		$postid=$postarr['ID'];
           if (wp_is_post_revision($postid) ||
            wp_is_post_autosave($postid) ||
            (defined('DOING_AJAX') && DOING_AJAX) ||
            (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)) {
            return $data;
        }
		

		$post_content=$data['post_content'];

		$getsiteurl=get_site_url();
		$parse = parse_url($getsiteurl);
		$host=$parse['host'];
		$post_title=get_the_title($postid);
		$domainp=trim(str_replace(".","\.",$host));
		
			////////////// UIOML Vars
			$uploaddir = wp_upload_dir();
			$uppath=$uploaddir['path'];
			$upurl=$uploaddir['baseurl'];
			////////////// UIOML Vars
			global $wpdb;
		$pattern ='/(<a(.*?)href=\\\"(.*?)(?!'.$domainp.')(.*?)\\\"(.*?)>(.*?))?((<img)(.*?)src=\\\"(.*?)(?!'.$domainp.')(.*?)\\\"(.*?)*(\/*>))((.*?)?(<\/a>))?/';
		$post_content = preg_replace_callback($pattern,
        function ($matches) use($uppath,$post_title,$postid,$upurl,$wpdb) {
		$imageurl=$matches[11];		
		////////////////////////////////////////////////////////////////UIOML
			$filename=basename($imageurl);
			$filename=str_replace("%20","",$filename);
			$filename=str_replace(" ","",$filename);
			$uploadfile = $uppath. '/' . $filename;
			//Check image exist
			$query = "SELECT COUNT(ID) FROM {$wpdb->posts} WHERE post_title='$filename'";
			$count = intval($wpdb->get_var($query));
			//Check image exist
			if($count==0)
			{
			$response = wp_remote_get($imageurl ,array('timeout' => 120));
			$response_code = wp_remote_retrieve_response_code( $response );
			$response_message = wp_remote_retrieve_response_message( $response );
			if($response_code === 200 && $response_message === 'OK')
			{
			$imagedata =wp_remote_retrieve_body($response);
			$savefile = fopen($uploadfile, 'w');
			fwrite($savefile, $imagedata);
			fclose($savefile);
			
			$wp_filetype = wp_check_filetype(basename($filename), null );

			$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => $filename,
				'post_content' => '',
				'post_status' => 'inherit'
			);
		$attach_id = wp_insert_attachment( $attachment, $uploadfile ,$postid );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $uploadfile );
		wp_update_attachment_metadata($attach_id,$attach_data);
		////////////////////////////////////////////////////////////////UIOML
		
			//$upurl."/".$attach_data["file"]		
		$imagesrc = wp_get_attachment_image_src($attach_id,'medium');
		$newimage=$matches[8]." src=\"".$imagesrc[0]."\" alt=\"".$post_title."\" title=\"".$post_title."\" ".$matches[13];	
		return $newimage;
			}
			}
			else
			{
			return $matches[0];
	
			}

        },$post_content,-1,$counter);
	
		$data['post_content']=$post_content;
        return $data;
   
 }





}

?>