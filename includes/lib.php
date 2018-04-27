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

    #Eliminando Anteriores (proceso, update)
    if(isset($POST['update-tools'])){
        $wpdb->delete('wp_td_tools_license', array('Tool'=>$tool_id));
        $wpdb->delete('wp_td_tools_plataform', array('Tool'=>$tool_id));
        $wpdb->delete('wp_td_tools_category', array('Tool'=>$tool_id));
    }

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
*Funcion que procesa toda la información correspondiente a la gestión de herramientas (CRUD)
*/
function td_form_tool(){

    ?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <?php
    global $wpdb;
    
    //Update Tool
    if(isset($_POST['update-tools'])){

        $file = $_FILES['imgfile'];
        //Si se va a reemplazar la imagen
        if($file['error']==0){
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
                $result=$wpdb->update('wp_td_Tools', $data,array('id'=>$_POST['ref_tool']));
                $insert_status=td_insert_many_relation($_POST,$_POST['ref_tool']);
            }
        }
        //Sino se va a reemplazar la imagen
        else{
            $data=array(
                'Name' => $_POST['name'],
                'link' => $_POST['www'],
                'Description' => $_POST['description'],
                'Need_connect' => $_POST['connect'],
                'Details' => $_POST['details'],
            );
            $result=$wpdb->update('wp_td_Tools', $data,array('id'=>$_POST['ref_tool']));
            $insert_status=td_insert_many_relation($_POST,$_POST['ref_tool']);
        }
    }   
    //Guardar nueva Tool
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
            //wp_redirect( $url );
        } else {?>
            <div class="error notice">
                <p>There has been an error. Bummer</p>
            </div>
    <?php
        }
    }

    //Editar Tools
    elseif(isset($_GET['id'])){
        $id=$_GET['id'];
        $tool = td_get_info_tool($id);
        
        $categories=td_get_categories();
        $plataforms=td_get_plataforms();
        $licenses=td_get_licences();
        ?>
        <div class="wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h2>Editar Herramienta</h2>
                        <form id="updates_form" method="post" action="" enctype="multipart/form-data" >
                             <div class="form-group">
                                <label for="NameTool">Nombre</label>    
                                <input id="NameTool" type="text" class="form-control" name="name"  value="<?echo $tool['info_tool']->Name?>" />
                            </div>

                            <div class="form-group">
                                <label for="SitioWeb">URL</label>    
                                <input id="SitioWeb" value="<?echo $tool['info_tool']->link?>" class="form-control" name="www"/>
                            </div>

                            <div class="form-group">
                                <label for="Categories">Categorias</label>
                                <select id="Categories" class="form-control" name="categories[]" multiple="multiple">
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
                                <label for="Description">Descripcion</label>
                                <textarea id="Description" name="description" class="form-control" form="updates_form"><?echo $tool['info_tool']->Description?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Plataforms">Plataformas</label>
                                <select id="Plataforms" class="form-control" name="plataforms[]" multiple="multiple">
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
                                <label>Requiere Conexión</label>
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
                                <label for="Licenses">Licencias</label>
                                <select id="Licenses" class="form-control" name="licenses[]" multiple="multiple">
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
                            </div>
                            <div class="form-group">
                                <label for="Details">Detalles</label>
                                <textarea id="Details" name="details" class="form-control" form="updates_form"><?echo $tool['info_tool']->Details?></textarea>
                            </div>
                            <div class="form-group">
                                <img src="<?php echo $tool['info_tool']->path_image?>" height="100" width="150"/><br>    
                                <label class="custom-file-label" for="imgfile">*Si desea actualizar la imagen, por favor carge una nueva</label>
                                <input type="file" class="custom-file-input" name="imgfile" id="imgfile" accept=".jpg, .jpeg, .png">
                            </div>
                            <input type="submit" class="btn btn-primary" name="update-tools" value="Actualizar" />
                            <input type="hidden" name="action"/>
                            <input type="hidden" name="ref_tool" value="<?echo $tool['info_tool']->id?>"/>
                            <input type="hidden" name="last_img" value="<?echo $tool['info_tool']->path_image?>"/>
                            <input type="hidden" name="page_options"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }    
    //Nueva Tools
    else{
    	$categories=td_get_categories();
    	$plataforms=td_get_plataforms();
    	$licenses=td_get_licences();
    	?>

     	<div class="wrap">
            <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <h2>Agregar una nueva herramienta</h2>
                        <form id="tools_form" method="post" action="" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="NameTool">Nombre</label>    
                                <input id="NameTool" type="text" class="form-control" name="name" size="45" placeholder="Nombre" />
                            </div>
                            <div class="form-group">
                                <label for="SitioWeb">URL</label>    
                                <input id="SitioWeb" class="form-control" name="www" placeholder="URL" />
                            </div>
                            <div class="form-group">
                                <label for="Categories">Categorias</label>
                                <select id="Categories" class="form-control" name="categories[]" multiple="multiple">
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
                                <label for="Description">Descripcion</label>
                                <textarea id="Description" name="description" class="form-control" form="tools_form"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="Plataforms">Plataformas</label>
                                <select id="Plataforms" class="form-control" name="plataforms[]" multiple="multiple">
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
                                <label>Requiere Conexión</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="connect" value="1" checked>Sí<br>
                                    <input class="form-check-input" type="radio" name="connect" value="0">No<br>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Licenses">Licencias</label>
                                <select id="Licenses" class="form-control" name="licenses[]" multiple="multiple">
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
                                <label for="Details">Detalles</label>
                                <textarea id="Details" name="details" class="form-control" form="tools_form"></textarea>
                            </div>

                            <div class="form-group">
                                <label class="custom-file-label" for="imgfile">Subir Archivo...</label>
                                <input id="imgfile" class="custom-file-input" type="file" name="imgfile" accept=".jpg, .jpeg, .png" required>
                            </div>

                            <input type="submit" class="btn btn-primary" name="submit-tools" value="Guardar" />
                            <input type="hidden" name="action"/>
                            <input type="hidden" name="page_options"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    //$url=get_site_url().'/wp-admin/admin.php?page=Show+Tools';
    //wp_redirect($url,302);
}

/*
*Despliega el formulario para añadir una nueva categoria.
*/
    function td_form_category(){

        ?>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
        <?php

        global $wpdb;

        //Guardar actualización de Categoria
        if(isset($_POST['update-category'])){
            $data=array(
                'Name' => $_POST['name']
            );

            $result=$wpdb->update('wp_td_Categories', $data,array('id'=>$_POST['ref_category']));

        }
        //Guardar Nueva Categoria
        elseif(isset($_POST['submit-category'])){

            $data=array(
                'Name' => $_POST['name']
            );

            $wpdb->insert('wp_td_Categories', $data);
        }
        elseif(isset($_GET['id'])){
            $id=$_GET['id'];
            $category=td_get_info_category($id);
            
            ?>

            <div class="wrap">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h2>Editar Categoria</h2>
                            <form id="category_form" method="post" action="">
                                <div class="form-group">
                                    <label for="NameCategory">Nombre</label>    
                                    <input id="NameCategory" type="text" value="<?echo $category->Name?>"  class="form-control" name="name" size="45" placeholder="Nombre" />
                                </div>
                                <input class="btn btn-primary" type="submit" name="update-category" value="Actualizar" />
                                <input type="hidden" name="action"/>
                                <input type="hidden" name="page_options"/>
                                <input type="hidden" name="ref_category" value="<?echo $category->id?>"/>
                            </form>
                        </div>
                    </div>
                </div>    
            </div> 

            <?
        }

        else{
        ?>

            <div class="wrap">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <h2>Agregar una nueva Categoria</h2>
                            <form id="category_form" method="post" action="">
                                <div class="form-group">
                                    <label for="NameCategory">Nombre</label>    
                                    <input id="NameCategory" type="text" class="form-control" name="name" size="45" placeholder="Nombre" />
                                </div>
                                <input class="btn btn-primary" type="submit" name="submit-category" value="Guardar" />
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
                     <a href='#'><span class="glyphicon glyphicon-trash"></span></a>
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

    /*
    *Retorna la lista de herramientas existentes en la BD
    */
    function td_get_all_tools(){

        global $wpdb;

        $ids = $wpdb->get_results( 'SELECT id FROM wp_td_Tools', OBJECT );

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
                     <a href='/wp-admin/admin.php?page=Add_Category&id=<? echo $category->id?>'><span class="glyphicon glyphicon-edit"></span></a>
                     <a href='#'><span class="glyphicon glyphicon-trash"></span></a>
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
    /*
    *Retorna la lista de categorias que tienen al menos una herramienta asignada para mostrar en isotopes filter
    */
    function td_get_categories_for_isotopes(){

        global $wpdb;

        $result=$wpdb->get_results('SELECT DISTINCT Category FROM wp_td_tools_category');
        $categories=array();
        foreach ($result as $id){
                $row=$wpdb->get_row('SELECT * FROM wp_td_Categories where id ='.$id->Category,OBJECT);
                array_push($categories,$row);
            }   
        
        return $categories;

        
    }
?>
