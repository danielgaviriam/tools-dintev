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


function td_insert_many_relation($POST, $tool_id){

	global $wpdb;

	if(isset($POST['categories'])){
		$categories=$POST['categories'];
		foreach ($categories as $selected){
			$data=array(
				'Tool'=>$tool_id,
				'Category'=>$selected
			);
			$result=$wpdb->insert('wp_td_tools_category', $data);
		}

	}
	if(isset($POST['licenses'])){
		$licenses=$POST['licenses'];
		foreach ($licenses as $selected){
			$data=array(
				'Tool'=>$tool_id,
				'License'=>$selected
			);
			$result=$wpdb->insert('wp_td_tools_license', $data);
		}

	}
	if(isset($POST['plataforms'])){
		$plataforms=$POST['plataforms'];
		foreach ($plataforms as $selected)
		{
			$data=array(
				'Tool'=>$tool_id,
				'Plataform'=>$selected
			);
			$result=$wpdb->insert('wp_td_tools_plataform', $data);
		}
	}
	return true;
}


//Despliega el formulario para añadir una nueva herramienta.

function form_tool(){

    if(isset($_POST['submit-tools']))
    {
        $file = $_FILES['imgfile'];
        $name_file = $file['name'];
        $path = WP_PLUGIN_URL.'/tools-dintev/img/'.$name_file;
        
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
    else{
    	$categories=td_get_categories();
    	$plataforms=td_get_plataforms();
    	$licenses=td_get_licences();
    	?>

     	<div class="wrap">
            <h2>Agregar una nueva herramienta</h2>
            <form id="tools_form" method="post" action="" enctype="multipart/form-data">
                <?php wp_nonce_field('update-options') ?>
                <p>
                    <strong>Nombre:</strong><br />
                    <input type="text" name="name" size="45"/>
                </p>
                <p>
                    <strong>Sitio Web:</strong><br />
                    <input type="text" name="www" size="45"/>
                </p>
                <p>
                    <strong>Categoria(s):</strong><br />
                     <select name="categories[]" multiple="multiple">
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
                    <textarea rows="4" cols="50" name="description" form="tools_form"></textarea>
                </p>
                <p>
                    <strong>Plataforma(s):</strong><br />
                     <select name="plataforms[]" multiple>
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
    				<input type="radio" name="connect" value="1" checked>Sí<br>
    				<input type="radio" name="connect" value="0">No<br>
      			</p>
                <p>
                    <strong>Licencia(s):</strong><br />
                     <select name="licenses[]" multiple="multiple">
                        <?php 
                     	foreach( $licenses as $key => $row) {
                     	?>	
                     	<option value="<?php echo $row->ID?>"><?php echo $row->Name?></option>
    					<?php 
                     	}
                     	?>	
                    </select> 
                </p>
                <p>
                    <strong>Detalles:</strong><br />
                    <textarea rows="4" cols="50" name="details" form="tools_form"></textarea>
                </p>
                <input type="file" name="imgfile">


                <p><input type="submit" name="submit-tools" value="save" /></p>
                <input type="hidden" name="action"/>
                <input type="hidden" name="page_options"/>
            </form>
        </div>
    <?php
        }
    }

    function form_category(){

        if(isset($_POST['submit-category'])){
            echo $_POST['name'];
            $data=array(
                'Name' => $_POST['name']
            );

            $wpdb->insert('wp_td_Categories', $data);
            echo $wpdb->print_error();
        }
        else{
        ?>
        	<div class="wrap">
                <h2>Agregar una nueva Categoria</h2>
                <form id="tools_form" method="post" action="">
                    <?php wp_nonce_field('update-options') ?>
                    <p>
                        <strong>Nombre:</strong><br />
                        <input type="text" name="name" size="45"/>
                    </p>
                    <p><input type="submit" name="submit-category" value="save" /></p>
                    <input type="hidden" name="action"/>
                    <input type="hidden" name="page_options"/>
                </form>
            </div>
        <?php
        }
    }
?>