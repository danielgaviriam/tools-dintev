<?php
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

require_once plugin_dir_path(__FILE__) . 'includes/lib.php';

	add_action('admin_menu', 'td_start_plugin');

	function td_start_plugin(){
        add_menu_page( 'Gestionar Herramienta', 'Tools Dintev', 'manage_options', 'Tools Dintev', 'td_form_tool' );
        add_submenu_page( 'Tools Dintev', 'Listar Herramientas', 'Lista Herramientas', 'manage_options', 'Show_Tools' ,'td_show_tools');
        add_submenu_page( 'Tools Dintev', 'Agregar Categoria', 'Add Categoria', 'manage_options', 'Add_Category' ,'td_form_category');
        add_submenu_page( 'Tools Dintev', 'Listar Categorias', 'Lista Categorias', 'manage_options', 'Show_Categories' ,'td_show_categories');
        }