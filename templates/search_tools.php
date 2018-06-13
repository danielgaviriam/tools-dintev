<?php
/**
 * Template Name: Search_Tools
 *
 */

require_once(__DIR__.'/../../plugins/tools-dintev/includes/lib.php');
//wp_enqueue_style( 'style',get_template_directory_uri().'/css/style.css',false,'1.1','all');
if(isset($_GET['search'])){
	get_header();
	$search = $_GET['search'];
	$tools=td_seatch_tools($search);
	?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<?php
	if(!(empty($tools)))
	{
	?>
	<div class="wrap">
		<div class="container">
			<h3>Resultado de Busqueda: <?php echo $search?></h3>
			<?php 
			foreach( $tools as $key => $row) {?>
			<div class="panel panel-default">
				  <div class="panel-heading">
				  	<strong><?php echo $row->Name?></strong>
				  	<a href="./tools/?id=<?php echo $row->id?>" target="blank"><span style="float:right;" class="glyphicon glyphicon-plus"></span></a>				  	
				  </div>
				  <div class="panel-body">
				  	<div class="col-sm-3">
						<img src="<?php echo $row->path_image ?>" class="img-thumbnail" height="200" width="200">
					</div>
				  	<div class="col-sm-9">
				  	<p class="description_tool"><?php echo $row->Description ?></p> 
				  	</div>
				  </div>
			</div>
			<?php
			}
			?>
		</div><!-- .container -->	    
	</div><!-- .wrap -->
	<?php 
	}
	else{
		?>
		<div class="wrap">
			<div class="container">
				<center><h1>Lo sentimos, la consulta no arrojo resultados</h1>
				<a href="./"><button type="button" class="btn btn-danger"><span class="glyphicon glyphicon-chevron-left"></span></button></a></center>
			</div>
		</div>
		<br>
		<?php
	}
	get_footer();
}else{
	$url="/~sivtie/";
	wp_redirect($url);
}