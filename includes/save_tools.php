<?php
require_once plugin_dir_path(__FILE__) . 'lib.php';
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/
global $wpdb;

if(isset($_POST['submit-tools']))
{
	$file = $_FILES['imgfile'];
	$name_file = $file['name'];
	$path = WP_PLUGIN_DIR.'/tools-dintev/img/'.$name_file;
	
	if (move_uploaded_file($file['tmp_name'], $path)) {
		$data=array(
			'Name' => $_POST['name'],
			'link' => $_POST['www'],
			'Description' => $_POST['description'],
			'Need_connect' => $_POST['connect'],
			'Details' => $_POST['details'],
			'path_image' => $path
		);
		$result=$wpdb->insert('wp_td_Tools', $data);
		$tool_id=$wpdb->insert_id;

		$insert_status=td_insert_many_relation($_POST,$tool_id);
    } else {
    	echo "fail";
    }
}