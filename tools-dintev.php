<?php
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/
	add_action('admin_menu', 'test_plugin_setup_menu');

	function test_plugin_setup_menu(){
        add_menu_page( 'Test Plugin Page', 'Test Plugin', 'manage_options', 'test-plugin', 'test_init' );
    }
    function test_init(){
 ?>
 	<div class="wrap">
        <h2>Agregar una nueva herramienta</h2>
        <form method="post" action="<?php echo plugin_dir_path( __FILE__ )?>options.php">
            <?php wp_nonce_field('update-options') ?>
            <p><strong>Nombre:</strong><br />
                <input type="text" name="name" size="45" value="#" />
            </p>
            <p><input type="submit" name="Submit" value="Store Options" /></p>
            <input type="hidden" name="action" value="update" />
            <input type="hidden" name="page_options" value="name" />
        </form>
    </div>
<?php
    }
?>