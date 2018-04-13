<?php
require_once plugin_dir_path(__FILE__) . 'lib.php';
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/


if($_POST['submit-tools'] == "save") 
{
	$data=array(
		'Name' => $_POST['name'],
		'link' => $_POST['www'],
		'Description' => $_POST['description']
	);
}