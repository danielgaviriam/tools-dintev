<?php
/**
* Plugin Name: tools-dintev
* Description: 
* Version: 1.0.0
* Author: Daniel Gaviria
* License: GPL2
*/

/*
*Retorna la lista de categorias existentes en la BD
*/
function td_get_categories(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'td_Categories', OBJECT );
	return $results;
}

/*
*Retorna la lista de plataformas existentes en la BD
*/
function td_get_plataforms(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'td_Plataforms', OBJECT );
	return $results;
}

/*
*Retorna la lista de licensias existentes en la BD
*/
function td_get_licences(){

	global $wpdb;

	$results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'td_Licenses', OBJECT );
	return $results;
}

/*
*Una vez creada una nueva herramienta esta funcion se encarga de añadir la relación 
*con Plataformas,Categorias y Licencias a las que pertenece
*/
function td_insert_many_relation($POST, $tool_id){

    global $wpdb;

    #Eliminando Anteriores (proceso, update)
    if(isset($POST['update-tools'])){
        $wpdb->delete($wpdb->prefix.'td_tools_license', array('Tool'=>$tool_id));
        $wpdb->delete($wpdb->prefix.'td_tools_plataform', array('Tool'=>$tool_id));
        $wpdb->delete($wpdb->prefix.'td_tools_category', array('Tool'=>$tool_id));
    }

	if(isset($POST['categories'])){
		$categories=$POST['categories'];
		foreach ($categories as $selected){
			$data=array(
				'Tool'=>$tool_id,
				'Category'=>$selected
			);
			$result=$wpdb->insert($wpdb->prefix.'td_tools_category', $data);
            
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
			$result=$wpdb->insert($wpdb->prefix.'td_tools_license', $data);
            
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
			$result=$wpdb->insert($wpdb->prefix.'td_tools_plataform', $data);

		}
	}
    else{
        echo "falle en plataformas";
    }
	return true;
}

function td_exists_tool_plataform($id_plataform,$id_tool){
    global $wpdb;

    $result=$wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'td_tools_plataform where Plataform='.$id_plataform.' AND Tool='.$id_tool);    
    
    return $result;
}

function td_exists_tool_category($id_category,$id_tool){
    global $wpdb;
    
    $result=$wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'td_tools_category where Category='.$id_category.' AND Tool='.$id_tool);    
    
    return $result;
}

function td_exists_tool_licenses($id_license,$id_tool){
    global $wpdb;

    $result=$wpdb->get_var('SELECT COUNT(*) FROM '.$wpdb->prefix.'td_tools_license where License='.$id_license.' AND Tool='.$id_tool);    
    
    return $result;
}



/*
*Funcion que procesa toda la información correspondiente a la gestión de herramientas (CRUD)
*/
function td_form_tool(){

	
	
    ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <?php
    //Multiselect Form
	wp_enqueue_style( 'bootstrap-multiselect', '/wp-content/plugins/tools-dintev/css/bootstrap-select.min.css' ,false,'1.1','all');
	wp_enqueue_script( 'bootstrap-multiselect', '/wp-content/plugins/tools-dintev/js/bootstrap-select.min.js', array ( 'jquery' ), 1.1, true);

    global $wpdb;
    
    //Update Tool
    if(isset($_POST['update-tools'])){

        $file = $_FILES['imgfile'];
        //Si se va a reemplazar la imagen
        if($file['error']==0){
            $name_file = $file['name'];
            $path = MY_PLUGIN_DIR.'img/'.$name_file;
            $wpath = get_site_url().'/wp-content/plugins/tools-dintev/img/'.$name_file;

            if (move_uploaded_file($file['tmp_name'], $path)) {
                $data=array(
                    'Name' => $_POST['name'],
                    'link' => $_POST['www'],
                    'link_video' => $_POST['link_video'],
                    'Description' => $_POST['description'],
                    'Need_connect' => $_POST['connect'],
                    'research' => $_POST['research'],
                    'evaluate' => $_POST['evaluate'],
                    'comunicate' => $_POST['comunicate'],
                    'colaborate' => $_POST['colaborate'],
                    'design' => $_POST['design'],
                    'Details' => $_POST['details'],
                    'path_image' => $wpath
                );
                $result=$wpdb->update($wpdb->prefix.'td_Tools', $data,array('id'=>$_POST['ref_tool']));
                $insert_status=td_insert_many_relation($_POST,$_POST['ref_tool']);
            }
        }
        //Sino se va a reemplazar la imagen
        else{
            $data=array(
                'Name' => $_POST['name'],
                'link' => $_POST['www'],
                'link_video' => $_POST['link_video'],
                'Description' => $_POST['description'],
                'Need_connect' => $_POST['connect'],
                'research' => $_POST['research'],
                'evaluate' => $_POST['evaluate'],
                'comunicate' => $_POST['comunicate'],
                'colaborate' => $_POST['colaborate'],
                'design' => $_POST['design'],
                'Details' => $_POST['details'],
            );
            $result=$wpdb->update($wpdb->prefix.'td_Tools', $data,array('id'=>$_POST['ref_tool']));
            $insert_status=td_insert_many_relation($_POST,$_POST['ref_tool']);
        }
        ?>
            <script type="text/javascript">
                function codeAddress() {
                    window.location ="/~sivtie/wp-admin/admin.php?page=Show_Tools&code=2";
                }
                    window.onload = codeAddress;
                </script>
        <?php
    }   
    //Guardar nueva Tool
    if(isset($_POST['submit-tools']))
    {   
        $file = $_FILES['imgfile'];
        $name_file = $file['name'];
        $path = MY_PLUGIN_DIR.'img/'.$name_file;
        $wpath = get_site_url().'/wp-content/plugins/tools-dintev/img/'.$name_file;
        
        if (move_uploaded_file($file['tmp_name'], $path)) {
            $data=array(
                'Name' => $_POST['name'],
                'link' => $_POST['www'],
                'link_video' => $_POST['link_video'],
                'Description' => $_POST['description'],
                'Need_connect' => $_POST['connect'],
                'research' => $_POST['research'],
                'evaluate' => $_POST['evaluate'],
                'comunicate' => $_POST['comunicate'],
                'colaborate' => $_POST['colaborate'],
                'design' => $_POST['design'],
                'Details' => $_POST['details'],
                'path_image' => $wpath
            );
            $result=$wpdb->insert($wpdb->prefix.'td_Tools', $data);
            
            $tool_id=$wpdb->insert_id;

            $insert_status=td_insert_many_relation($_POST,$tool_id);

        } else {?>
            <div class="error notice">
                <p>There has been an error. Bummer</p>
            </div>
    <?php
        }
        ?>
            <script type="text/javascript">
                function codeAddress() {
                    window.location ="/~sivtie/wp-admin/admin.php?page=Show_Tools&code=1";
                }
                    window.onload = codeAddress;
                </script>
        <?php
    }
    //Editar Tools
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $tool = td_get_info_tool($id);
        
        $categories=td_get_categories();
        $plataforms=td_get_plataforms();
        $licenses=td_get_licences();
        ?>
        <div class="wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Editar Herramienta</h2>
                        <form id="updates_form" method="post" action="" enctype="multipart/form-data" >
                             <div class="form-group">
                                <label for="NameTool">Nombre*</label>    
                                <input id="NameTool" type="text" class="form-control" name="name"  value="<?php echo $tool['info_tool']->Name?>" required/>
                            </div>

                            <div class="form-group">
                                <label for="SitioWeb">URL*</label>    
                                <input id="SitioWeb" value="<?php echo $tool['info_tool']->link?>" class="form-control" name="www" required/>
                            </div>

                            <div class="form-group">
                                <label for="link_video">Video (Youtube)</label>    
                                <input id="link_video" value="<?php echo $tool['info_tool']->link_video?>" class="form-control" name="link_video"/>
                            </div>

                            <div class="form-group">
                                <label for="Categories">Categorias*</label>
                                <select id="Categories" class="form-control selectpicker" multiple data-actions-box="true" name="categories[]" multiple="multiple" required>
                                <?php 
                                foreach( $categories as $key => $row) {
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
                            </div>
                            <div class="form-group">
                                <label for="Description">Descripcion*</label>
                                <textarea id="Description" name="description" class="form-control" form="updates_form"><?php echo $tool['info_tool']->Description?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Plataforms">Plataformas*</label>
                                <select id="Plataforms" class="form-control selectpicker" multiple data-actions-box="true" name="plataforms[]" multiple="multiple" required>
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
                            </div>
                            <div class="form-group">
                                <label>Requiere Conexión*</label>
                                <div class="form-check">
                                    <?php
                                    if($tool['info_tool']->Need_connect==1){
                                        ?>
                                        <input class="form-check-input" type="radio" name="connect" value="1" checked>Sí<br>
                                        <input class="form-check-input" type="radio" name="connect" value="0">No<br>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <input class="form-check-input" type="radio" name="connect" value="1">Sí<br>
                                        <input class="form-check-input" type="radio" name="connect" value="0" checked>No<br>
                                        <?php
                                    }
                                    ?>  
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Licenses">Licencias*</label>
                                <select id="Licenses" class="form-control selectpicker" multiple data-actions-box="true" name="licenses[]" multiple="multiple" required>
                                <?php 
                                foreach( $licenses as $key => $row) {
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
                            </div>
                            <div class="form-group">
                                <label for="Details">Detalles*</label>
                                <textarea id="Details" name="details" class="form-control" form="updates_form" required><?php echo $tool['info_tool']->Details?></textarea>
                            </div>
                            <div class="form-group">
                                <img src="<?php echo $tool['info_tool']->path_image?>" height="100" width="150"/><br>    
                                <label class="custom-file-label" for="imgfile">*Si desea actualizar la imagen, por favor carge una nueva</label>
                                <input type="file" class="custom-file-input" name="imgfile" id="imgfile" accept=".jpg, .jpeg, .png">
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="Research">Investigar</label>
                                <textarea id="Research" name="research" class="form-control" form="updates_form" ><?php echo $tool['info_tool']->research?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Comunicate">Comunicar</label>
                                <textarea id="Comunicate" name="comunicate" class="form-control" form="updates_form" ><?php echo $tool['info_tool']->comunicate?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Evaluate">Evaluar</label>
                                <textarea id="Evaluate" name="evaluate" class="form-control" form="updates_form" ><?php echo $tool['info_tool']->evaluate?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Colaborate">Colaborar</label>
                                <textarea id="Colaborate" name="colaborate" class="form-control" form="updates_form" ><?php echo $tool['info_tool']->colaborate?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Design">Diseñar</label>
                                <textarea id="Design" name="design" class="form-control" form="updates_form" ><?php echo $tool['info_tool']->design?></textarea>
                            </div>
                            <hr>
                            <input type="submit" class="btn btn-primary" name="update-tools" value="Actualizar" />
                            <a href="/~sivtie/wp-admin/admin.php?page=Show_Tools" class="btn btn-danger">Cancelar</a>
                            <input type="hidden" name="action"/>
                            <input type="hidden" name="ref_tool" value="<?php echo $tool['info_tool']->id?>"/>
                            <input type="hidden" name="last_img" value="<?php echo $tool['info_tool']->path_image?>"/>
                            <input type="hidden" name="page_options"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Initialize the plugin: -->
		<script type="text/javascript">
    		$(document).ready(function() {
        		$('.selectpicker').selectpicker({
        		});
    		});
		</script>
        <?php
    }    
    //Nueva Tools
    elseif(1==1){
    	$categories=td_get_categories();
    	$plataforms=td_get_plataforms();
    	$licenses=td_get_licences();
    	?>

     	<div class="wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Agregar una nueva herramienta</h2>
                        <form id="tools_form" method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="NameTool">Nombre*</label>    
                                <input id="NameTool" type="text" class="form-control" name="name" size="45" placeholder="Nombre" required/>
                            </div>
                            <div class="form-group">
                                <label for="SitioWeb">URL*</label>    
                                <input id="SitioWeb" class="form-control" name="www" placeholder="URL" required/>
                            </div>

                            <div class="form-group">
                                <label for="link_video">Video (Youtube)</label>    
                                <input id="link_video" class="form-control" name="link_video" placeholder="Video de Youtube"/>
                            </div>

                            <div class="form-group">
                                <label for="Categories">Categorias*</label>
                                <select id="Categories" class="form-control selectpicker" multiple data-actions-box="true" name="categories[]" multiple="multiple" required>
                                    <?php 
                                    foreach( $categories as $key => $row) {
                                    ?>
                                    <option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                    <?php 
                                    }
                                    ?>
                                </select> 
                            </div>
                            <div class="form-group">
                                <label for="Description">Descripcion*</label>
                                <textarea id="Description" name="description" class="form-control" form="tools_form" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Plataforms">Plataformas*</label>
                                <select id="Plataforms" class="form-control selectpicker" multiple data-actions-box="true" name="plataforms[]" multiple="multiple" required>
                                    <?php 
                                    foreach( $plataforms as $key => $row) {
                                    ?>
                                    <option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                    <?php 
                                    }
                                    ?>
                                </select> 
                            </div>

                            <div class="form-group">
                                <label>Requiere Conexión*</label>
                                <div class="form-check" required>
                                    <input class="form-check-input" type="radio" name="connect" value="1" checked>Sí<br>
                                    <input class="form-check-input" type="radio" name="connect" value="0">No<br>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Licenses">Licencias*</label>
                                <select id="Licenses" class="form-control selectpicker" multiple data-actions-box="true" name="licenses[]" multiple="multiple" required>
                                    <?php 
                                    foreach( $licenses as $key => $row) {
                                    ?>
                                    <option value="<?php echo $row->id?>"><?php echo $row->Name?></option>
                                    <?php 
                                    }
                                    ?>
                                </select> 
                            </div>
                            
                            <div class="form-group">
                                <label for="Details">Detalles*</label>
                                <textarea id="Details" name="details" class="form-control" form="tools_form" required></textarea>
                            </div>

                            <div class="form-group">
                                <label class="custom-file-label" for="imgfile">Subir Archivo*</label>
                                <input id="imgfile" class="custom-file-input" type="file" name="imgfile" accept=".jpg, .jpeg, .png" required>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label for="Research">Investigar</label>
                                <textarea id="Research" name="research" class="form-control" form="tools_form"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Comunicate">Comunicar</label>
                                <textarea id="Comunicate" name="comunicate" class="form-control" form="tools_form"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Evaluate">Evaluar</label>
                                <textarea id="Evaluate" name="evaluate" class="form-control" form="tools_form"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Colaborate">Colaborar</label>
                                <textarea id="Colaborate" name="colaborate" class="form-control" form="tools_form"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Design">Diseñar</label>
                                <textarea id="Design" name="design" class="form-control" form="tools_form"></textarea>
                            </div>
                            <hr>

                            <input type="submit" class="btn btn-primary" name="submit-tools" value="Guardar" />
                            <a href="/~sivtie/wp-admin/admin.php?page=Show_Tools" class="btn btn-danger">Cancelar</a>
                            <input type="hidden" name="action"/>
                            <input type="hidden" name="page_options"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Initialize the plugin: -->
		<script type="text/javascript">
    		$(document).ready(function() {
        		$('.selectpicker').selectpicker({
        		});
    		});
		</script>

    <?php
    }
}
//add_action( 'admin_init', 'td_form_tool',10,2 );

/*
*Despliega el formulario para añadir una nueva categoria.
*/

function td_form_category(){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    ?>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <?php

    global $wpdb;

    //Guardar actualización de Categoria
    if(isset($_POST['update-category'])){
        $data=array(
            'Name' => $_POST['name'],
            'Long_Name' => $_POST['long_name']
        );

        $result=$wpdb->update($wpdb->prefix.'td_Categories', $data,array('id'=>$_POST['ref_category']));
        
        ?>
        <script type="text/javascript">
            function codeAddress() {
                window.location ="/~sivtie/wp-admin/admin.php?page=Show_Categories";
            }
                window.onload = codeAddress;
            </script>
        <?php 
        
    }
    //Guardar Nueva Categoria
    if(isset($_POST['submit-category'])){
        $data=array(
            'Name' => $_POST['name'],
            'Long_Name' => $_POST['long_name']
        );

        $wpdb->insert($wpdb->prefix.'td_Categories', $data);
        ?>
        <script type="text/javascript">
            function codeAddress() {
                window.location ="/~sivtie/wp-admin/admin.php?page=Show_Categories";
            }
                window.onload = codeAddress;
            </script>
        <?php 
        
    }
    if(isset($_GET['id'])){
        $id=$_GET['id'];
        $category=td_get_info_category($id);
        
        ?>

        <div class="wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Editar Categoria</h2>
                        <form id="category_form" method="post" action="">
                            <div class="form-group">
                                <label for="NameCategory">Nombre Corto</label>    
                                <input id="NameCategory" type="text" value="<?php echo $category->Name?>"  class="form-control" name="name" size="45" placeholder="Nombre" required/>
                                <p id="NameCategoryHelpBlock" class="form-text text-muted">
                                    Debe ser de una sola palabra
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="LongNameCategory">Nombre Largo</label>    
                                <input id="LongNameCategory" type="text" value="<?php echo $category->Long_Name?>"  class="form-control" name="long_name" size="45" placeholder="Nombre Largo" required/>
                                <p id="LongNameCategoryHelpBlock" class="form-text text-muted">
                                    Nombre que desea que aparezca en el filtro por categorias
                                </p>
                            </div>
                            <input class="btn btn-primary" type="submit" name="update-category" value="Actualizar" />
                            <a href="/~sivtie/wp-admin/admin.php?page=Show_Categories" class="btn btn-danger">Cancelar</a>
                            <input type="hidden" name="action"/>
                            <input type="hidden" name="page_options"/>
                            <input type="hidden" name="ref_category" value="<?php echo $category->id?>"/>
                        </form>
                    </div>
                </div>
            </div>    
        </div> 

        <?php 
    }
    else{
    ?>

        <div class="wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h2>Agregar una nueva Categoria</h2>
                        <form id="category_form" method="post" action="">
                            <div class="form-group">
                                <label for="NameCategory">Nombre Corto</label>    
                                <input id="NameCategory" type="text" class="form-control" name="name" size="45" placeholder="Nombre" required/>
                                <p id="NameCategoryHelpBlock" class="form-text text-muted">
                                    Debe ser de una sola palabra
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="LongNameCategory">Nombre Largo</label>    
                                <input id="LongNameCategory" type="text" class="form-control" name="long_name" size="45" placeholder="Nombre Largo" required/>
                                <p id="LongNameCategoryHelpBlock" class="form-text text-muted">
                                    Nombre que desea que aparezca en el filtro por categorias
                                </p>
                            </div>
                            <input class="btn btn-primary" type="submit" name="submit-category" value="Guardar"/>
                            <a href="/~sivtie/wp-admin/admin.php?page=Show_Categories" class="btn btn-danger">Cancelar</a>
                            <input type="hidden" name="action"/>
                            <input type="hidden" name="page_options"/>
                        </form>
                    </div>
                </div>
            </div>    
        </div>        
    <?php
    }
}

//add_action( 'init', 'td_form_category' ); // Hook into 'init'
/*
*Recupera la información de la BD para mostrar la información de una herramienta.
*/
function td_get_info_tool($id){
    
    global $wpdb;

    $result['info_tool'] = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'td_Tools where id='.$id, OBJECT );
    $relations=Array();
    $plataforms = $wpdb->get_results( 'SELECT Name FROM '.$wpdb->prefix.'td_tools_plataform wtp JOIN '.$wpdb->prefix.'td_Plataforms wp ON wtp.Plataform=wp.id where wtp.Tool='.$id, OBJECT );
    $categories = $wpdb->get_results( 'SELECT Name FROM '.$wpdb->prefix.'td_tools_category wtc JOIN '.$wpdb->prefix.'td_Categories wc ON wtc.Category=wc.id where wtc.Tool='.$id, OBJECT );
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
    <h5>A continuación se muestra el listado de herramientas creadas:</h5>
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="<?php echo get_template_directory_uri().'/js/jquery.min.js' ?>"></script>

    <div class="wrap">
        <?php
        if(isset($_GET['code'])){
            $code=$_GET['code'];
            ?><div class="alert alert-success" role="alert">
                <?php
                if($code==2){
                    echo "La herramienta fue actualizada de forma exitosa";
                }
                elseif($code==1){
                    echo "La herramienta fue almacenada de forma exitosa";
                }
                
            ?></div><?php
        }   
        ?>     
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
                 <a href='<?php echo MY_URL_DIR; ?>/wp-admin/admin.php?page=Tools+Dintev&id=<?php  echo $tool->id?>'><span class="glyphicon glyphicon-edit"></span></a>
                 <a href="#" onclick="return delete_tool(<?php echo $tool->id?>,'tool');"><span class="glyphicon glyphicon-trash"></span></a>
                 <a href="<?php echo MY_URL_DIR; ?>/tools/?id=<?php echo $tool->id?>"><span class="glyphicon glyphicon-eye-open"></span></a>
              </td>
            </tr>

            <?php
        }   
        ?>                              
          </tbody>
        </table>
    </div>
    <script type="text/javascript">
        function delete_tool(id,type) {

            $.ajax({
                type: 'POST',
                url: '<?php echo MY_URL_DIR; ?>/wp-admin/admin.php?page=Deletes',
                data: { 
                    'id': id, 
                    'type': type
                },
                success: function(data) {
                    location.reload();
                }
            })
        }   
    </script>
    <?php   
}

/*
*Retorna la lista de herramientas existentes en la BD
*/
function td_get_all_tools(){

    global $wpdb;

    $ids = $wpdb->get_results( 'SELECT id FROM '.$wpdb->prefix.'td_Tools', OBJECT );

    $array_tools=array();

    foreach( $ids as $key => $row) {

        $tool=td_get_info_tool($row->id);
        array_push($array_tools,$tool);
    }


    return $array_tools;

}

/*
*Recupera la información de la BD para mostrar la información de una categoria.
*/
function td_get_info_category($id){
    
    global $wpdb;

    $result = $wpdb->get_row( 'SELECT * FROM '.$wpdb->prefix.'td_Categories where id='.$id, OBJECT );

    return $result;
}

    function td_show_categories(){
    global $wpdb;
    $results=$wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'td_Categories',OBJECT);

    ?>
    <h3>Listado de Categorias</h3>
    <h5>A continuación se muestra el listado de categorias creadas:</h5>
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <script src="<?php echo get_template_directory_uri().'/js/jquery.min.js' ?>"></script>

    <div class="wrap">
        <table class="table table-striped table-bordered">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            foreach ($results as $category){
            ?>

            <tr>
              <th scope="row"><?php echo $category->id?></th>
              <td><?php echo $category->Name?></td>
              <td>
                 <a href='<?php echo MY_URL_DIR; ?>/wp-admin/admin.php?page=Add_Category&id=<?php  echo $category->id?>'><span class="glyphicon glyphicon-edit"></span></a>
                 <a href='#' onclick="return delete_tool(<?php echo $category->id?>,'category');"><span class="glyphicon glyphicon-trash"></span></a>
              </td>
            </tr>
            <?php
        }   
        ?>
            
           
          </tbody>
        </table>
    </div>
    <script type="text/javascript">
         function delete_tool(id,type) {

            $.ajax({
                type: 'POST',
                url: '<?php echo MY_URL_DIR; ?>/wp-admin/admin.php?page=Deletes',
                data: { 
                    'id': id, 
                    'type': type
                },
                success: function(data) {
                    location.reload();
                }
            })
        }   
    </script>
    <?php   
}

/*
*Retorna la lista de categorias que tienen al menos una herramienta asignada para mostrar en isotopes filter
*/
function td_get_categories_for_isotopes(){

    global $wpdb;

    $result=$wpdb->get_results('SELECT DISTINCT Category FROM '.$wpdb->prefix.'td_tools_category');
    $categories=array();
    foreach ($result as $id){
            $row=$wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'td_Categories where id ='.$id->Category,OBJECT);
            array_push($categories,$row);
        }   
    
    return $categories;

    
}

/*
*Convierte el link de youtube, en string para ser embebido en html
*/
function td_link_embebed($link){

    $for_code=strpos($link,"=");
    $code_link=substr($link, $for_code+1);
    return "https://www.youtube.com/embed/".$code_link;
}


/*
*Procesa la información enviada usando ajax, eliminar categorios o herramientas
*/
function td_deletes_tools_categories(){

    global $wpdb;
    
    if(isset($_POST)){
        if($_POST['type']=='tool'){
            
            $wpdb->delete( $wpdb->prefix.'td_tools_category', array( 'Tool' => $_POST['id']));
            $wpdb->delete( $wpdb->prefix.'td_tools_license', array( 'Tool' => $_POST['id']));
            $wpdb->delete( $wpdb->prefix.'td_tools_plataform', array( 'Tool' => $_POST['id']));
            $wpdb->delete( $wpdb->prefix.'td_Tools', array( 'id' => $_POST['id']));
        }
        if($_POST['type']=='category'){
            $wpdb->delete( $wpdb->prefix.'td_tools_category', array( 'Category' => $_POST['id']));
            $wpdb->delete( $wpdb->prefix.'td_Categories', array( 'id' => $_POST['id']));   
        }
        if($_POST['type']=='comment'){
            $wpdb->delete( $wpdb->prefix.'td_comments', array( 'id' => $_POST['id']));
        }
    }
}

function td_show_comments($id_tool){

    $results=td_get_comments_from_tool($id_tool);
    $user = wp_get_current_user();
    ?>

    <?php 
    
    foreach($results as $key => $row) {
        ?>
        <div class="row">
            <div class="col-sm-1">
                <div class="thumbnail">
                    <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                </div><!-- /thumbnail -->
            </div><!-- /col-sm-1 -->

            <div class="col-sm-11">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong><?php  echo $row->Name?></strong> 
                        <span class="text-muted"><?php  echo $row->Email ?></span>
                            <?php 
                            if(!empty($user->roles)){
                                ?>
                                <a onclick="return delete_comment(<?php  echo $row->id?>,'comment');"><span style="float:right;" class="glyphicon glyphicon-remove"></span></a>
                                <?php 
                            }
                            ?>
                    </div>
                    <div class="panel-body">
                        <?php  echo $row->Comment ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Comentario</h5>
              </div>
                <div id="text_modal"class="modal-body">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <span id="button_to_delete"></span>
                <!--<button id=delete_button type="button" class="btn btn-primary">Eliminar</button>-->
              </div>
            </div>
          </div>
        </div>
        <script type="text/javascript">
        function update_modal(id,name) {

            $('#exampleModalCenter').modal('show');
        }
        function delete_comment(id,type) {

            $.ajax({
                type: 'POST',
                url: '/~sivtie/wp-admin/admin.php?page=Deletes',
                data: { 
                    'id': id, 
                    'type': type
                },
                success: function(data) {
                    location.reload();
                }
            })
        }   
    </script>
        <?php 
    }
}

function td_form_comments($id_tool){
    ?>
    <script src="<?php echo get_template_directory_uri().'/js/jquery.min.js' ?>"></script>
    <hr>
    <div class="col-sm-6">
        <form id="comment_form" method="post" action="javascript:void(0);">
            <div class="form-group">
                <label for="Name">Nombre</label>    
                <input id="Name" type="text" class="form-control" name="name" size="45" placeholder="Nombre" required/>
            </div>
            <div class="form-group">
                <label for="Email">Email</label>    
                <input id="Email" type="email" class="form-control" name="email" placeholder="email" required/>
            </div>
                    
            <div class="form-group">
                <label for="Comment">Comentario</label>
                <textarea id="Comment" name="comment" class="form-control" form="comment_form" required></textarea>
            </div>
            <input type="hidden" name="ref_tool" id="ref_tool" value="<?php echo $id_tool?>"/>
            <input type="submit"  onclick="save_comments();" class="btn btn-primary" name="save-comment" value="Guardar" />
        </form>
        <br>
    </div>
    <script type="text/javascript">
        function save_comments(){
            var name=document.getElementById("Name").value;
            var email=document.getElementById("Email").value;
            var comment=document.getElementById("Comment").value;
            var id=document.getElementById("ref_tool").value;
                            
            if(name.length !=0 && email.length != 0  && comment.length !=0 && id.length != 0 && email.search("@") != -1){
                $.ajax({
                    type: 'POST',
                    url: '/~sivtie/wp-admin/admin.php?page=Comments',
                    data: { 
                        'id': id, 
                        'name': name,
                        'email': email,
                        'comment': comment,
                    },
                    success: function(data) {
                        console.log(data);
                        location.reload();
                    }
                })
            }
        }
    </script>
    <?php 
}

function td_save_comments(){

    global $wpdb;
    
    if(isset($_POST)){
        $data=array(    
            'Name' => $_POST['name'],
            'Email' => $_POST['email'],
            'Comment' => $_POST['comment'],
            'Tool' => $_POST['id']
        );
        $wpdb->insert($wpdb->prefix.'td_comments', $data);
    }
    else{
        echo "hola2";
        $data=array(
            'Name' => "hola",
            'Email' => "2",
            'Comment' => "1",
            'Tool' => "2"
        );
        $wpdb->insert($wpdb->prefix.'td_comments', $data);
    }
}

function td_get_comments_from_tool($id_tool){
    global $wpdb;
    
    $results = $wpdb->get_results( 'SELECT * FROM '.$wpdb->prefix.'td_comments where Tool='.$id_tool, OBJECT );

    return $results;
    

}

function td_get_pagination_for_isotopes(){

    global $wpdb;
    
    $cont = $wpdb->get_var( 'SELECT COUNT(*) FROM '.$wpdb->prefix.'td_Tools');

    return ceil($cont/25);
    
}

function td_get_isotopes_filter(){

    //Incluyendo el estilo del isotopes filter
    get_header(); 
    wp_enqueue_style( 'style',get_template_directory_uri().'/css/style.css',false,'1.1','all');
    $categories=td_get_categories_for_isotopes();
    $tools=td_get_all_tools();
    $cant_pages=td_get_pagination_for_isotopes();   
            
    ?>
    <script src="<?php echo get_template_directory_uri().'/js/isotope-docs.min.js' ?>"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>               
      
        <br>
        <div class="row">
        <?php td_search_form()?>
        <hr>
        <div class="filters main-filter" >
            <div class="button-group js-radio-button-group" data-filter-group="categories">
                <button id="filter_all" class="button is-checked" data-filter="*">show all</button>
                <?php 
                foreach( $categories as $key => $row) {?>
                    <button class="button" data-filter=".<?php echo $row->Name?>"><?php echo $row->Long_Name?></button>
                    <?php
                }
                ?>     
            </div>
        </div>
        <div class="grid isotope">
            <?php
            $iter=1;
            foreach( $tools as $key => $row) {?>
            <div class="imagebox"">
                <a href="/~sivtie/tools/?id=<?php  echo $row['info_tool']->id ?>" target="blank">
                    <div class="element-item <?php    
                        $fil=ceil($iter/25);
                        foreach ($row['categories'] as $key) {                       
                            echo $key->Name." ";
                        }
                        echo $fil?>">
                        <img src="<?php echo $row['info_tool']->path_image?>" style="width:70%;height:70%;padding-top:10%"/>
                        <span class="imagebox-desc"><?php  echo $row['info_tool']->Name ?></span>
                        <h3 hidden class="name"><?php echo $row['info_tool']->Name?></h3>
                    </div>
                </a>
            </div>
            <?php
            $iter=$iter+1;
            }
            ?>
        </div>
      
        <div class="filters">
            <div class="button-group js-radio-button-group" data-filter-group="pages">  
                <?php 
                ?><button class="button is-checked" data-filter=".1">1</button><?php 
                for ($i = 2; $i <= $cant_pages; $i++) {?>
                    <button class="button" data-filter=".<?php echo $i?>"><?php echo $i?></button>
                    <?php
                }
                ?>     
            </div>
        </div>
        </div>
        <script src="<?php echo get_template_directory_uri().'/js/isotopes.js' ?>"></script>
        <script type="text/javascript">
        $("document").ready(function() {
            setTimeout(function() {
                $grid.isotope({ filter: "*.1" });
            },0);
        });
        </script>
    <?php
}
add_shortcode( 'tools-dintev', 'td_get_isotopes_filter' );

function td_search_form(){
    ?>
    <form id="search_form" method="get" action="/~sivtie/search">
        <div id="custom-search-input">
            <div class="input-group col-md-12">
                <input id="search" type="text" class="form-control" name="search" placeholder="Palabra Clave" required/>
                <span class="input-group-btn">
                    <button class="btn btn-info btn-lg" type="submit">
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </span>
            </div>
        </div>
    </form>
    <br>
    <?php 
}

function td_seatch_tools($term){
    global $wpdb;   
            
    $tools = $wpdb->get_results( 'SELECT DISTINCT * FROM '.$wpdb->prefix.'td_Tools WHERE Name LIKE "%'.$term.'%" or Description LIKE "%'.$term.'%" or Details LIKE "%'.$term.'%" or research LIKE "%'.$term.'%" or comunicate LIKE "%'.$term.'%" or evaluate LIKE "%'.$term.'%" or colaborate LIKE "%'.$term.'%" or design LIKE "%'.$term.'%" or id in (SELECT Tool from '.$wpdb->prefix.'td_tools_category where Category in (SELECT id from '.$wpdb->prefix.'td_Categories WHERE Name LIKE "%'.$term.'%" or Long_Name LIKE "%'.$term.'%")) or id in (SELECT Tool from '.$wpdb->prefix.'td_tools_license where License in (SELECT id from '.$wpdb->prefix.'td_Licenses WHERE Name LIKE "%'.$term.'%")) or id in (SELECT Tool from '.$wpdb->prefix.'td_tools_plataform where Plataform in (SELECT id from '.$wpdb->prefix.'td_Plataforms WHERE Name LIKE "%'.$term.'%"))', OBJECT );

    return $tools;
}



function td_tool_structure_template(){
    wp_enqueue_style( 'style',get_template_directory_uri().'/css/style.css',false,'1.1','all');
    if(isset($_GET['id'])){
        get_header();
        $id = $_GET['id'];
        $results = td_get_info_tool($id);
        //print_r($results['plataforms']) ;
        ?>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <div class="wrap">
            <div id="primary" class="content-area">
                <center><h2><?php echo $results['info_tool']->Name ?></h2></center>
                <div class="container">
                    <div class="jumbotron text-center row">

                        <div class="col-sm-4">
                            <img src="<?php echo $results['info_tool']->path_image ?>" class="img-thumbnail" height="400" width="400">
                        </div>
                        <div class="col-sm-8">
                        <p class="description_tool"><?php echo $results['info_tool']->Description ?></p> 
                        </div>
                    </div>
                </div>
                  
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 ">
                            <!--<iframe src="<?php echo td_link_embebed($results['info_tool']->link_video)?>" width="560" height="315"></iframe>-->
                            <h4 class="subtitle_uv">Link</h4>
                            <a href="<?php echo $results['info_tool']->link ?>" target="blank"><?php echo $results['info_tool']->link ?></a>
                            <h4 class="title_uv">Requiere Conexión a Internet</h4>
                            <p><?php 
                                $value=$results['info_tool']->Need_connect;
                                if($value==True){
                                    ?><span class="glyphicon glyphicon-ok"></span>
                                <?php
                                }
                                else{
                                    ?><span class="glyphicon glyphicon-remove"></span>
                                <?php   
                                }
                                ?>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            
                            <h4 class="title_uv">Tipo de Licencias</h4>
                            <ul>
                            <?php
                            foreach ($results['licenses'] as $key) {
                                ?>
                                <li><?php echo $key->Name ?></li>
                                <?php
                            }
                            ?>
                            </ul>

                            <h4 class="title_uv">Plataformas Disponibles</h4>
                            <p>
                            <?php
                            foreach ($results['plataforms'] as $key) {
                                if ($key->Name == "iOS"){
                                    ?><i class="fab fa-apple fa-3x"></i><?php
                                }
                                if ($key->Name == "Android"){
                                    ?><i class="fab fa-android fa-3x"></i><?php
                                }
                                if ($key->Name == "PC(Escritorio)"){
                                    ?><i class="fas fa-laptop fa-2x"></i><?php
                                }
                            }
                            ?>
                            </p>
                            
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <center><iframe src="<?php echo td_link_embebed($results['info_tool']->link_video)?>" width="560" height="315"></iframe></center>
                        </div>
                    </div>
                <?php 
                    td_show_comments($id);
                    echo td_form_comments($id)
                ?>
                </div>
            </div><!-- #primary -->
        </div><!-- .wrap -->
        <?php 
        get_footer();
    }else{
        $url="/";
        wp_redirect($url);
    }
}
add_shortcode( 'tool-dintev-template', 'td_tool_structure_template' );