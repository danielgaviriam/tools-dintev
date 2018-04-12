<?php
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/
require_once plugin_dir_path(__FILE__) . 'includes/save_tools.php';

	add_action('admin_menu', 'test_plugin_setup_menu');

	function test_plugin_setup_menu(){
        //Nombre_pagina,Nombre_Panel
        add_menu_page( 'Agregar Herramienta', 'Tools Dintev', 'manage_options', 'Tools Dintev', 'form_tool' );
        //nombre-nombre-permisos-ruta-funcion
        add_submenu_page( 'Tools Dintev', 'Agregar Herramienta', 'Add Herramienta', 'manage_options', 'Add Tool' ,'form_tool');
        add_submenu_page( 'Tools Dintev', 'Agregar Herramienta', 'Add Categoria', 'manage_options', 'Add Category' ,'form_tool');
        }
    

    function form_tool(){
 ?>
 	<div class="wrap">
        <h2>Agregar una nueva herramienta</h2>
        <form id="tools_form" method="post" action="/includes/save_tools.php">
            <?php wp_nonce_field('update-options') ?>
            <p>
                <strong>Nombre:</strong><br />
                <input type="text" name="name" size="45" value="#" />
            </p>
            <p>
                <strong>Sitio Web:</strong><br />
                <input type="text" name="www" size="45" value="#" />
            </p>
            <p>
                <strong>Categorias:</strong><br />
                 <select multiple>
                    <option value="1">Volvo</option>
                    <option value="2">Saab</option>
                    <option value="3">Opel</option>
                    <option value="4">Audi</option>
                    <option value="5">Mazda</option>
                </select> 
            </p>
            <p>
                <strong>Descripción:</strong><br />
                <textarea rows="4" cols="50" name="description" form="tools_form">
                </textarea>
            </p>
            <p>
                <strong>Plataforma:</strong><br />
                 <select multiple>
                    <option value="1">IOS</option>
                    <option value="2">Android</option>
                    <option value="3">PC (Escritorio)</option>
                    <option value="4">Web</option>
                </select> 
            </p>



            <p><input type="submit" name="Submit" value="Store Options" /></p>
            <input type="hidden" name="action"/>
            <input type="hidden" name="page_options"/>
        </form>
    </div>
<?php
    }
?>