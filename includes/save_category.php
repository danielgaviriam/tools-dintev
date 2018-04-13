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
echo "test";
if(isset($_POST['submit-category']))
{
	$data=array(
		'Name' => $_POST['name']
	);
	$wpdb->insert('wp_td_Categories', $data);
	echo $wpdb->print_error();
}