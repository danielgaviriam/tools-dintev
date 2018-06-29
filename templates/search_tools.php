<?php
/**
 * Template Name: Search_Tools
 *
 */

require_once(__DIR__.'/../../plugins/tools-dintev/includes/lib.php');
wp_enqueue_style( 'style',get_template_directory_uri().'/css/style.css',false,'1.1','all');
if(isset($_GET['search'])){

	$page=1;
	if(isset($_GET['pag'])){
		$page=$_GET['pag'];
	}
	get_header();
	$search = $_GET['search'];
	$result = td_search_tools($search);
	if($page==1){
		$tools = array_slice($result['tools'],0,5);
	}else{
		$tools = array_slice($result['tools'],(($page-1)*5),5);
	}
	
	?>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
	<?php
	if(!(empty($tools)))
	{		
	?>
	<div class="wrap">
		<div class="container">
    		<h2 class="title_uv">Herramientas para la innovación Educativa</h2>
    	</div>
    	<br>
		<div class="container" style="width: 700px;">
			<br>
			<?php td_search_form_2()?>
			<br>
			<center><h2 class="title_tool">Resultado de Busqueda: <?php echo $search?></span></h2>
			<hr class="hr_title_tool">
			<?php 
			foreach( $tools as $key => $row) {?>
			<div class="panel panel-default">
				  <div class="panel-heading">
				  	<table>
						<td>
							<center>
							<a href="../tools/?id=<?php echo $row->id?>"><img class="img_dintev" src="<?php echo $row->path_image ?>"></a>
							</center>
						</td>						
					  	<td>
					  		<p class="description_tool"><?php echo $row->Description ?></p> 
					  		<a href="../tools/?id=<?php echo $row->id?>"><span class="show_more_tool">Ver Mas +</span></a>				  	
					  	</td>
					</table>				  	
				  </div>
			</div>
			<?php
			}
			?>
			<center>
		        <div class="filters pages_isotopes">
		            <div class="button-group">  
		                <?php 
		                for ($i = 1; $i <= $result['total']; $i++) {
		                	if($i==$page){
		                		?><a href="<?php the_permalink(); ?>?search=<?php echo $search; ?>& pag=<?php echo $i;?>" class="bottons_isotope pages search active"><?php echo $i?></a><?php
		                	}else{
		                		?><a href="<?php the_permalink(); ?>?search=<?php echo $search; ?>& pag=<?php echo $i;?>" class="bottons_isotope pages search"><?php echo $i?></a><?php
		                	}
		                }
		                ?>     
		            </div>
		        </div>
	        </center>
		</div><!-- .container -->	    
	</div><!-- .wrap -->
	<?php 
	}
	else{
		$categories=td_get_categories_for_isotopes();
    	$tools=td_get_all_tools();
    	$cant_pages=td_get_pagination_for_isotopes();   
		?>
		<script src="<?php echo get_template_directory_uri().'/js/isotope-docs.min.js' ?>"></script>
		<div class="wrap">
			<div class="container">
				<!--
				<center><h2 class="title_search_uv">Lo sentimos, la consulta no arrojo resultados, intentelo nuevamente</h2>
				<?php td_search_form_2()?><br>
				<a href="./"><button type="button" class="btn btn-danger"><span class="fas fa-home"></span></button></a></center>
				-->
				<br>
				<span class="title_uv">Herramientas para la innovación Educativa</span>
				<br>
				<br>
		        <center><p style="width: 700px !important;" class="description_uv_search" align="jusify">Lo sentimos, la consulta no arrojó resultados.</p></center>
		        <center><p style="width: 700px !important;" class="description_uv_search" align="jusify">Por favor explore las categorías o inténtelo nuevamente.</p></center>

		        <center>
		        <div class="container">
		            <div class="col-md-8 col-md-offset-2">
		                <?php td_search_form()?>    
		            </div>
		        </div>
		        <br>
		        <div class="row">
		        	<div class="col">
		        		<div class="filters">
		                    <div class="button-group categories-isotope" data-filter-group="categories">
		                        <div class="first_buttons_line_isotopes">
		                            <button id="filter_all" class="bottons_isotope is-checked" data-filter="*">Todas</button>
		                            <button class="bottons_isotope" data-filter=".comunicación">Comunicación</button>
		                            <button class="bottons_isotope" data-filter=".multimedia">Creación multimedia</button>
		                            <button class="bottons_isotope" data-filter=".aprendizaje">Evaluación del aprendizaje</button>
		                            <button class="bottons_isotope" data-filter=".gamificación">Gamificación</button>
		                        </div>
		                        <div class="second_buttons_line_isotopes">
		                            <button class="bottons_isotope" style="border-left: 2px solid #D51B23" data-filter=".especializada">Herramienta especializada</button>
		                            <button class="bottons_isotope" data-filter=".academica">Investigación académica</button>
		                            <button class="bottons_isotope" data-filter=".graficos">Organizadores gráficos</button>
		                            <button class="bottons_isotope" data-filter=".colaborativo">Trabajo colaborativo</button>
		                        </div>
		                    </div>
		                </div>
		        	</div>
		        </div>
		    	</center>
		        
		        <div class="grid isotope">
		            <?php
		            $iter=1;
		            foreach( $tools as $key => $row) {?>
		            <a href="../tools/?id=<?php  echo $row['info_tool']->id ?>">
		                <div class="element-item <?php    
		                    $fil=ceil($iter/35);
		                    foreach ($row['categories'] as $key) {                       
		                        echo $key->Name." ";
		                    }
		                    echo $fil?>">
		                    <img src="<?php echo $row['info_tool']->path_image?>"/>
		                </div>
		            </a>
		            <?php
		            $iter=$iter+1;
		            }
		            ?>
		        </div>
		        <center>
		        <div class="filters pages_isotopes">
		            <div class="button-group pages-isotope" data-filter-group="pages">  
		                <?php 
		                ?><button class="bottons_isotope pages is-checked" data-filter=".1">1</button><?php 
		                for ($i = 2; $i <= $cant_pages; $i++) {?>
		                    <button class="bottons_isotope pages" data-filter=".<?php echo $i?>"><?php echo $i?></button>
		                    <?php
		                }
		                ?>     
		            </div>
		        </div>
		        </center>
		        
		        
		        <script src="<?php echo get_template_directory_uri().'/js/isotopes.js' ?>"></script>
		        <script type="text/javascript">
		        $("document").ready(function() {
		            setTimeout(function() {
		                $grid.isotope({ filter: "*.1" });
		            },0);
		        });
		        </script>
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