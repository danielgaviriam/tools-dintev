<?php
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

function td_get_categories(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM wp_td_Categories', OBJECT );
	return $results;
}

function td_get_plataforms(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM wp_td_Plataforms', OBJECT );
	return $results;
}
function td_get_licences(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM wp_td_Licenses', OBJECT );
	return $results;
}



function form_tool(){

	$categories=td_get_categories();
	$plataforms=td_get_plataforms();
	$licences=td_get_licences();
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
                <strong>Categoria(s):</strong><br />
                 <select name="categories" multiple>
                 	<?php 
                 	foreach( $categories as $key => $row) {
                 	?>	
                 	<option value="<?php echo $row->ID?>"><?php echo $row->Name?></option>
					<?php 
                 	}
                 	?>	                 	
                </select> 
            </p>
            <p>
                <strong>Descripción:</strong><br />
                <textarea rows="4" cols="50" name="description" form="tools_form">
                </textarea>
            </p>
            <p>
                <strong>Plataforma(s):</strong><br />
                 <select name="plataforms" multiple>
                 	<?php 
                 	foreach( $plataforms as $key => $row) {
                 	?>	
                 	<option value="<?php echo $row->ID?>"><?php echo $row->Name?></option>
					<?php 
                 	}
                 	?>	 
                </select> 
            </p>

			<p>
				<strong>Requiere Conexión a Internet?</strong><br />
				<input type="radio" name="connect" value="true" checked>Sí<br>
				<input type="radio" name="connect" value="false">No<br>
  			</p>
            <p>
                <strong>Licencia(s):</strong><br />
                 <select multiple>
                    <?php 
                 	foreach( $licences as $key => $row) {
                 	?>	
                 	<option value="<?php echo $row->ID?>"><?php echo $row->Name?></option>
					<?php 
                 	}
                 	?>	
                </select> 
            </p>
            <p>
                <strong>Detalles:</strong><br />
                <textarea rows="4" cols="50" name="details" form="tools_form">
                </textarea>
            </p>
            <p><input type="submit" name="submit-tools" value="save" /></p>
            <input type="hidden" name="action"/>
            <input type="hidden" name="page_options"/>
        </form>
    </div>
<?php
    }
?>