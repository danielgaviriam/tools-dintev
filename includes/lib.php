<?php
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

require_once plugin_dir_path(__FILE__) . 'Tools_Table.php';
/*
*Retorna la lista de categorias existentes en la BD
*/
function td_get_categories(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM wp_td_Categories', OBJECT );
	return $results;
}

/*
*Retorna la lista de plataformas existentes en la BD
*/
function td_get_plataforms(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM wp_td_Plataforms', OBJECT );
	return $results;
}

/*
*Retorna la lista de licensias existentes en la BD
*/
function td_get_licences(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM wp_td_Licenses', OBJECT );
	return $results;
}

/*
*Una vez creada una nueva herramienta esta funcion se encarga de añadir la relación 
*con Plataformas,Categorias y Licencias a las que pertenece
*/
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
    else{
        echo "falle en categorias";
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
    else{
        echo "falle en licencias";
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
    else{
        echo "falle en plataformas";
    }
	return true;
}

function td_exists_tool_plataform($id_plataform,$id_tool){
    global $wpdb;

    $result=$wpdb->get_var("SELECT COUNT(*) FROM wp_td_tools_plataform where Plataform=".$id_plataform." AND Tool=".$id_tool);    
    
    return $result;
}

function td_exists_tool_category($id_category,$id_tool){
    global $wpdb;
    
    $result=$wpdb->get_var("SELECT COUNT(*) FROM wp_td_tools_category where Category=".$id_category." AND Tool=".$id_tool);    
    
    return $result;
}

function td_exists_tool_licenses($id_license,$id_tool){
    global $wpdb;

    $result=$wpdb->get_var("SELECT COUNT(*) FROM wp_td_tools_license where License=".$id_license." AND Tool=".$id_tool);    
    
    return $result;
}

/*
*Despliega el formulario para añadir una nueva herramienta.
*/
function td_form_tool(){

    global $wpdb;

    //Editar Tools
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $tool = td_get_info_tool($id);
        
        $categories=td_get_categories();
        $plataforms=td_get_plataforms();
        $licenses=td_get_licences();
        ?>
        <div class="wrap">
            <h2>Editar Herramienta</h2>
            <form id="tools_form" method="post" action="" enctype="multipart/form-data">
                <?php wp_nonce_field('update-options') ?>
                <p>
                    <strong>Nombre:</strong><br />
                    <input value="<?echo $tool['info_tool']->Name?>" type="text" name="name" size="45"/>
                </p>
                <p>
                    <strong>Sitio Web:</strong><br />
                    <input value="<?echo $tool['info_tool']->link?>" type="text" name="www" size="45"/>
                </p>
                <p>
                    <strong>Categoria(s):</strong><br />
                     <select name="categories[]" multiple="multiple">
                        <?php 
                        foreach( $plataforms as $key => $row) {
                            if(td_exists_tool_category($row->id,$id)){
                                ?>  
                                    <option selected="selected" value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                <?php
                            }
                            else{
                                ?>  
                                    <option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                <?php
                            }
                        }
                        ?>                       
                    </select> 
                </p>
                <p>
                    <strong>Descripción:</strong><br />
                    <textarea rows="4" cols="50" name="description" form="tools_form"><?echo $tool['info_tool']->Description?></textarea>
                </p>
                <p>
                    <strong>Plataforma(s):</strong><br />
                     <select name="plataforms[]" multiple>
                        <?php 
                        foreach( $plataforms as $key => $row) {
                            if(td_exists_tool_plataform($row->id,$id)){
                                ?>  
                                    <option selected="selected" value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                <?php
                            }
                            else{
                                ?>  
                                    <option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                <?php
                            }
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
                        foreach( $plataforms as $key => $row) {
                            if(td_exists_tool_licenses($row->id,$id)){
                                ?>  
                                    <option selected="selected" value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                <?php
                            }
                            else{
                                ?>  
                                    <option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                <?php
                            }
                        }
                        ?>   
                    </select> 
                </p>
                <p>
                    <strong>Detalles:</strong><br />
                    <textarea rows="4" cols="50" name="details" form="tools_form"><?echo $tool['info_tool']->Details?></textarea>
                </p>
                <input type="file" name="imgfile">


                <p><input type="submit" name="submit-tools" value="save" /></p>
                <input type="hidden" name="action"/>
                <input type="hidden" name="page_options"/>
            </form>
        </div>
        <?php
    }    
    //Guardar Tools
    elseif(isset($_POST['submit-tools']))
    {
        $file = $_FILES['imgfile'];
        $name_file = $file['name'];
        $path = $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/tools-dintev/img/'.$name_file;
        $wpath = get_site_url().'/wp-content/plugins/tools-dintev/img/'.$name_file;
        
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $data=array(
                'Name' => $_POST['name'],
                'link' => $_POST['www'],
                'Description' => $_POST['description'],
                'Need_connect' => $_POST['connect'],
                'Details' => $_POST['details'],
                'path_image' => $wpath
            );
            $result=$wpdb->insert('wp_td_Tools', $data);
            $tool_id=$wpdb->insert_id;

            $insert_status=td_insert_many_relation($_POST,$tool_id);
        } else {?>
            <div class="error notice">
                <p>There has been an error. Bummer</p>
            </div>
    <?php
        }
    }
    //Nueva Tools
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
                     	<option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
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
                     	<option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
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
                     	<option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
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

/*
*Despliega el formulario para añadir una nueva categoria.
*/
    function td_form_category(){

        global $wpdb;

        if(isset($_POST['submit-category'])){
            $data=array(
                'Name' => $_POST['name']
            );

            $wpdb->insert('wp_td_Categories', $data);
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

/*
*Recupera la información de la BD para mostrar la información de una herramienta.
*/
    function td_get_info_tool($id){
        
        global $wpdb;

        $result['info_tool'] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'td_Tools where id='.$id, OBJECT );
        $relations=Array();
        $plataforms = $wpdb->get_results( 'SELECT Name FROM '.$wpdb->prefix.'td_tools_plataform wtp JOIN '.$wpdb->prefix.'td_Plataforms wp ON wtp.Plataform=wp.id where wtp.Tool='.$id, OBJECT );
        $cateogies = $wpdb->get_results( 'SELECT Name FROM '.$wpdb->prefix.'td_tools_category wtc JOIN '.$wpdb->prefix.'td_Categories wc ON wtc.Category=wc.id where wtc.Tool='.$id, OBJECT );
        $licenses = $wpdb->get_results( 'SELECT Name FROM '.$wpdb->prefix.'td_tools_license wtl JOIN '.$wpdb->prefix.'td_Licenses wl ON wtl.License=wl.id where wtl.Tool='.$id, OBJECT );

        $relations['plataforms']=$plataforms;
        $relations['categories']=$categories;
        $relations['licenses']=$licenses;

        $results=array_merge($result,$relations);
        
        return $results;
    }

    function td_show_tools(){
        global $wpdb;
        $results=$wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'td_Tools',OBJECT);
    
        ?>
        <h3>Listado de Herramientas</h3>
         <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 

        <div class="wrap">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">URL</th>
                  <th scope="col">Descripcion</th>
                  <th scope="col">Requiere Internet</th>
                  <th scope="col">Detalles</th>
                  <th scope="col">Opciones</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                foreach ($results as $tool){
                ?>

                <tr>
                  <th scope="row"><?php echo $tool->id?></th>
                  <td><?php echo $tool->Name?></td>
                  <td><?php echo $tool->link?></td>
                  <td>
                    <?php 
                        $rest = substr($tool->Description,0,100);
                        echo $rest."...";
                    ?>  
                  </td>
                  <td>
                    <?php 
                        if($tool->Need_connect){?>
                            <span class="glyphicon glyphicon-ok"></span>
                            <?php
                        }
                        else{?>
                            <span class="glyphicon glyphicon-remove"></span>
                            <?php
                        }
                    ?>          
                  </td>
                  <td>
                    <?php 
                        $rest = substr($tool->Details,0,100);
                        echo $rest."...";
                    ?>  
                  </td>
                  <td>
                     <a href='/wp-admin/admin.php?page=Tools+Dintev&id=<? echo $tool->id?>'><span class="glyphicon glyphicon-edit"></span></a>
                     <span class="glyphicon glyphicon-trash"></span>
                     <a href='/tools/?id=<? echo $tool->id?>'><span class="glyphicon glyphicon-eye-open"></span></a>
                  </td>
                </tr>

                <?php
            }   
            ?>
                
               
              </tbody>
            </table>
        </div>
        <?php   
    }
?>
