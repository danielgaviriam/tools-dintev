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
        //Nombre_pagina,Nombre_Panel
        add_menu_page( 'Agregar Herramienta', 'Tools Dintev', 'manage_options', 'Tools Dintev', 'form_tool' );
        //nombre-nombre-permisos-ruta-funcion
        add_submenu_page( 'Tools Dintev', 'Agregar Herramienta', 'Add Herramienta', 'manage_options', 'Add Tool' ,'form_tool');
        add_submenu_page( 'Tools Dintev', 'Agregar Categoria', 'Add Categoria', 'manage_options', 'Add Category' ,'form_category');
        }