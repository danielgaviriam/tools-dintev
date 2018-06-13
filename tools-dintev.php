<?php
/**
* Plugin Name: tools-dintev
* Description: Plugin Desarrollado para el Área de Nuevas Técnologias (DINTEV), Universidad del Valle
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/
global $wp;   
    
require_once plugin_dir_path(__FILE__) . 'includes/lib.php';
        define('MY_PLUGIN_DIR', plugin_dir_path( __FILE__ )); 
        define('MY_URL_DIR', home_url( $wp->request ));
        
	add_action('admin_menu', 'td_start_plugin');

	function td_start_plugin(){
        add_menu_page( 'Gestionar Herramienta', 'Tools Dintev', 'manage_options', 'Tools Dintev', 'td_form_tool');
        add_submenu_page( 'Tools Dintev', 'Listar Herramientas', 'Herramientas', 'manage_options', 'Show_Tools' ,'td_show_tools');
        add_submenu_page( 'Tools Dintev', 'Agregar Categoria', '+ Categoria', 'manage_options', 'Add_Category' ,'td_form_category');
        add_submenu_page( 'Tools Dintev', 'Listar Categorias', 'Categorias', 'manage_options', 'Show_Categories' ,'td_show_categories');
        //Utilizada para eliminar categorias y herramientas utilizando ajax:
        add_submenu_page( null, 'Eliminar Herramientas', 'Eliminar Herramientas', 'manage_options', 'Deletes' ,'td_deletes_tools_categories');
        //Utilizada para guardar las herramientas utilizando ajax:
        add_submenu_page( null, 'Agregar Comentario', 'Agregar Comentario', 'manage_options', 'Comments' ,'td_save_comments');
        }

?>