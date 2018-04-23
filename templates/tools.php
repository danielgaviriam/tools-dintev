<?php
/**
 * Template Name: Test2
 *
 */
require_once($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/tools-dintev/includes/lib.php");
get_header(); 


$id = $_GET['id'];
$results = td_get_info_tool($id);
//print_r($results['plataforms']) ;
?>


<div class="wrap">
    <div id="primary" class="content-area">
		<div class="jumbotron text-center">
		  	<img src="<?php echo $results['info_tool']->path_image ?>" class="img-thumbnail">
		  	<p class="description_tool"><?php echo $results['info_tool']->Description ?></p> 
		</div>
		  
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
				    <h4>Link</h4>
				    <p><?php echo $results['info_tool']->link ?></p>
				    <h4>Requiere Conexión a Internet</h4>
				    <p><?php 
				    	$value=$results['info_tool']->Need_connect;
				    	if($value==True){
				    		?>Requiere<?php
				    	}
				    	else{
				    		?>No Requiere<?php	
				    	}
				    	?>
				    </p>
				</div>
				<div class="col-sm-6">
					<h4>Tipo de Licencias</h4>
					<ul>
					<?php
					foreach ($results['licenses'] as $key) {
						?>
						<li><?php echo $key->Name ?></li>
						<?php
					}
					?>
					</ul>

					<h4>Plataformas Disponibles</h4>
					<ul>
					<?php
					foreach ($results['plataforms'] as $key) {
						?>
						<li><?php echo $key->Name ?></li>
						<?php
					}
					?>
					</ul>
					
				</div>
		    </div>
		</div>
    </div><!-- #primary -->
</div><!-- .wrap -->

<?php get_footer();