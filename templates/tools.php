<?php
/**
 * Template Name: Tools_by_id
 *
 */

require_once(__DIR__.'/../../plugins/tools-dintev/includes/lib.php');
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
			    	
	    		<?php if($results['info_tool']->link_video!=""){
	    			?>
	    			<hr>
	    			<div class="row">
		    			<div class="col-sm-12 ">
		    				<center><iframe src="<?php echo td_link_embebed($results['info_tool']->link_video)?>" width="560" height="315"></iframe></center>
	    				</div>
	    			</div>	    		
	    			<?php
	    		}
	    		?>
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
	$url="/~sivtie/";
	wp_redirect($url);
}?>