<?php
/**
 * Template Name: Tools_by_id
 *
 */

require_once(__DIR__.'/../../plugins/tools-dintev/includes/lib.php');
wp_enqueue_style( 'style',get_template_directory_uri().'/css/style.css',false,'1.1','all');

if(isset($_POST['save-comment'])){

	global $wpdb;

	$data=array(    
            'Name' => $_POST['name_dintev'],
            'Email' => $_POST['email_dintev'],
            'Comment' => $_POST['comment_dintev'],
            'Tool' => $_POST['ref_tool']
        );
        $wpdb->insert($wpdb->prefix.'td_comments', $data);


    $_GET['id']=$_POST['ref_tool'];
    
}

if(isset($_GET['id'])){
	get_header();
	$id = $_GET['id'];
	$results = td_get_info_tool($id);
	$categories_for_tool=td_get_categories_for_tool($id);
	//print_r($categories_for_tool);
	?>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> 
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
	<script src="https://apis.google.com/js/platform.js" async defer></script>

	<div class="wrap">

	    <div id="primary" class="content-area">	    	
	    	<br>
	    	<div class="container">
	    		<span class="title_uv">Herramientas para la innovación Educativa</span>
	    	</div>
	    		
	    	<div class="container" style="width: 700px">
	    		<br>
	    		<div class="row justify-content-center">
		            <?php td_search_form()?>    
		        </div>
	    		
	    		<center><h2 class="title_tool"><?php echo $results['info_tool']->Name ?></h2></center>
	    		<hr class="hr_title_tool">
	    		<table>
					<td>
						<center>
						<img src="<?php echo $results['info_tool']->path_image ?>" class="img-thumbnail"><br>
						<a class="link_tool" href="<?php echo $results['info_tool']->link ?>" target="blank"><?php echo $results['info_tool']->link ?></a></center>
						</center>
					</td>						
				  	<td>
				  		<p class="description_tool"><?php echo $results['info_tool']->Description ?></p>
				  			<p class="categories_subtitle_tool">Categorías:</p>
				  			<p class="categories_tool">
				  				<?php
				  				$i=0;
				  				foreach ($categories_for_tool as $key) {
				  					if($i != (count($categories_for_tool)-1)){
				  						echo $key->Long_Name." / ";	
				  					}
				  					else{
				  						echo $key->Long_Name;		
				  					}
				  					
				  					$i++;

				  			}?>
				  			</p>
				  	</td>
				</table>
				<hr class="hr_section_tool">
			</div>
			<div class="container" style="width: 700px">
				<div class="row">
					<div class="col-sm-4">
				      <p class="license_subtitle_tool">Tipo de licencia:</p>
				      <?php
				      	$i=0;
						foreach ($results['licenses'] as $key) {
							if($i==0){
								if ($key->Name == "Gratuita"){
								?><div class="first-items-tool">
									<span><i class="fab fa-creative-commons-nc fa-2x"></i> Gratis</span>
								  </div><?php
								}
								if ($key->Name == "Pago"){
									?><div class="first-items-tool">
										<span><i class="fas fa-credit-card fa-2x"></i> Premium</span>
									</div><?php
								}
								if ($key->Name == "Freemium"){
									?><div class="first-items-tool">
										<span><i class="fas fa-gift fa-2x"></i> Freemium</span>
									</div><?php
								}
							}
							else{
								if ($key->Name == "Gratuita"){
								?><div class="items-tool">
									<span><i class="fab fa-creative-commons-nc fa-2x"></i> Gratis</span>
								  </div><?php
								}
								if ($key->Name == "Pago"){
									?><div class="items-tool">
										<span><i class="fas fa-credit-card fa-2x"></i> Premium</span>
									</div><?php
								}
								if ($key->Name == "Freemium"){
									?><div class="items-tool">
										<span><i class="fas fa-gift fa-2x"></i> Freemium</span>
									</div><?php
								}
							}							
							$i++;
						}
						?>
				    </div>
				    <div class="col-sm-4">
				      <p class="license_subtitle_tool">Disponible para plataformas:</p>
				      <?php
				      	$i=0;
						foreach ($results['plataforms'] as $key) {
							if($i==0){
								if ($key->Name == "iOS"){
								?><div class="first-items-tool">
									<span><i class="fab fa-apple fa-2x"></i> iOS</span>
								  </div><?php
								}
								if ($key->Name == "Android"){
									?><div class="first-items-tool">
										<span><i class="fab fa-android fa-2x"></i> Android</span>
									  </div><?php
								}
								if ($key->Name == "PC(Escritorio)"){
									?><div class="first-items-tool">
										<span><i class="fas fa-laptop fa-2x"></i> PC-Escritorio</span>
									</div><?php
								}
								if ($key->Name == "Web"){
									?><div class="first-items-tool">
										<span><i class="fas fa-globe fa-2x"></i> Web</span>
									</div><?php
								}
							}
							else{
								if ($key->Name == "iOS"){
								?><div class="items-tool">
									<span><i class="fab fa-apple fa-2x"></i> iOS</span>
								  </div><?php
								}
								if ($key->Name == "Android"){
									?><div class="items-tool">
										<span><i class="fab fa-android fa-2x"></i> Android</span>
									  </div><?php
								}
								if ($key->Name == "PC(Escritorio)"){
									?><div class="items-tool">
										<span><i class="fas fa-laptop fa-2x"></i> PC-Escritorio</span>
									</div><?php
								}
								if ($key->Name == "Web"){
									?><div class="items-tool">
										<span><i class="fas fa-globe fa-2x"></i> Web</span>
									</div><?php
								}

							}
							$i++;
						}
						?>

				    </div>
				    <div class="col-sm-4">
				      <p class="license_subtitle_tool">Requiere conexión a internet:</p>
				      <p><?php 
					    	$value=$results['info_tool']->Need_connect;
					    	if($value==True){
					    		?><span class="license_subtitle_tool"><i class="fas fa-check fa-2x"></i> Si</span>
					    	<?php
					    	}
					    	else{
					    		?><span class="license_subtitle_tool"><i class="fas fa-times fa-2x"></i> No</span>
					    	<?php	
					    	}
					    	if($results['info_tool']->Description_Connect != ""){
					    		?>
					    		<br><br><i class="fas fa-exclamation"></i>
					    		<span class="description_connect_tool">
					    		<?php
					    		echo $results['info_tool']->Description_Connect;
					    		?></span><?php
					    	}
					    	?>
					    </p>
				    </div>
				</div>

	    		<?php if($results['info_tool']->link_video!=""){
	    			?>
	    			<hr class="hr_section_tool">
	    			<div class="row">
		    			<div class="col-sm-12 ">
		    				<center><iframe src="<?php echo td_link_embebed($results['info_tool']->link_video)?>" width="560" height="315"></iframe></center>
	    				</div>
	    			</div>	    		
	    			<?php
	    		}
	    		?>
	    		<hr class="hr_section_tool">
	    		<center>
		    		<p class="categories_subtitle_tool">Posibilidades de Uso</p>
		    		<nav>
			    		<div class="row">
			    			<?php
			    			$ite=0;
			    			if($results['info_tool']->bool_research){
			    				?><a id="search_a" data-toggle="tab" href="#nav-research"><img id="search_img" src="<?php echo get_template_directory_uri().'/images/iconos_investigar.png' ?>"></a><?php
			    			}
			    			?>
			    			<?php
			    			if($results['info_tool']->bool_comunicate){
			    				?><a id="comunicate_a" data-toggle="tab" href="#nav-comunicate"><img id="comunicate_img" src="<?php echo get_template_directory_uri().'/images/iconos_comunicar.png' ?>"></a><?php
			    			}
			    			?>
			    			<?php
			    			if($results['info_tool']->bool_evaluate){
			    				?><a id="evaluate_a" data-toggle="tab" href="#nav-evaluate"><img id="evaluate_img" src="<?php echo get_template_directory_uri().'/images/iconos_evaluar.png' ?>"></a><?php
			    			}
			    			?>
			    			<?php
			    			if($results['info_tool']->bool_colaborate){
			    				?><a id="colaborate_a" data-toggle="tab" href="#nav-colaborate"><img id="colaborate_img" src="<?php echo get_template_directory_uri().'/images/iconos_colaborar.png' ?>"></a><?php
			    			}
			    			?>
			    			<?php
			    			if($results['info_tool']->bool_design){
			    				?><a id="design_a" data-toggle="tab" href="#nav-design"><img id="design_img" src="<?php echo get_template_directory_uri().'/images/iconos_diseñar.png' ?>"></a><?php
			    			}
			    			?>
			    		</div>
			    	</nav>	
		    		<div style=" text-align: justify;text-justify: inter-word;" class="tab-content description_tool" id="nav-tabContent">
		    			<?php
		    			if($results['info_tool']->research != ""){
		    				?>
		    				<div class="tab-pane fade" id="nav-research" role="tabpanel"><p><?php echo nl2br($results['info_tool']->research) ?></p></div>
		    				<?php
		    			}
		    			if($results['info_tool']->research == "" and $results['info_tool']->bool_research){
		    				?>
		    				<div class="tab-pane fade" id="nav-research" role="tabpanel"></div>
		    				<?php
		    			}
		    			if($results['info_tool']->comunicate != ""){
		    				?>
		    				<div class="tab-pane fade" id="nav-comunicate" role="tabpanel"><p><?php echo nl2br($results['info_tool']->comunicate) ?></p></div>
		    				<?php
		    			}
		    			if($results['info_tool']->comunicate == "" and $results['info_tool']->bool_comunicate){
		    				?>
		    				<div class="tab-pane fade" id="nav-comunicate" role="tabpanel"></div>
		    				<?php
		    			}
		    			if($results['info_tool']->evaluate != ""){
		    				?>
		    				<div class="tab-pane fade" id="nav-evaluate" role="tabpanel"><p><?php echo nl2br($results['info_tool']->evaluate) ?></p></div>
		    				<?php
		    			}
		    			if($results['info_tool']->evaluate == "" and $results['info_tool']->bool_evaluate){
		    				?>
		    				<div class="tab-pane fade" id="nav-evaluate" role="tabpanel"></div>
		    				<?php
		    			}				
		    			if($results['info_tool']->colaborate != ""){
		    				?>
		    				<div class="tab-pane fade" id="nav-colaborate" role="tabpanel"><p><?php echo nl2br($results['info_tool']->colaborate) ?></p></div>
		    				<?php
		    			}
		    			if($results['info_tool']->colaborate == "" and $results['info_tool']->bool_colaborate){
		    				?>
		    				<div class="tab-pane fade" id="nav-colaborate" role="tabpanel"></div>
		    				<?php
		    			}
		    			if($results['info_tool']->design != ""){
		    				?>
		    				<div class="tab-pane fade" id="nav-design" role="tabpanel"><p><?php echo nl2br($results['info_tool']->design) ?></p></div>
		    				<?php
		    			}
		    			if($results['info_tool']->design == "" and $results['info_tool']->bool_design){
		    				?>
		    				<div class="tab-pane fade" id="nav-design" role="tabpanel"></div>
		    				<?php
		    			}
		    			?>
					</div>
		    	</center>
	    		<hr class="hr_section_tool">
		    	<center>
		    		<p class="categories_subtitle_tool">Detalles</p>
		    		<p class="description_tool" style="text-align: left;"> 
		    			<?php 
		    			$first = td_text_initial_for_details(nl2br($results['info_tool']->Details));
		    			$last = substr(nl2br($results['info_tool']->Details), strlen($first));
		    			?>
		    			<span><?php echo $first; ?><span class="collapse" id="collapseExample"><?php echo $last; ?></span>
		    			<a class="show_more_tool" id="show_more" onclick="changeText();" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">Ver Mas</a></span>
		    		</p>
		    	</center>
		    	<hr class="hr_section_tool">
		    	<!-- FACEBOOK-->
				  <script>
				  	(function(d, s, id) {
				    var js, fjs = d.getElementsByTagName(s)[0];
				    if (d.getElementById(id)) return;
				    js = d.createElement(s); js.id = id;
				    js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";
				    fjs.parentNode.insertBefore(js, fjs);
				  }(document, 'script', 'facebook-jssdk'));
				</script>
				<!-- FIN FACEBOOK-->
				<center>
				  <div class="row">	
				  	  	<span class="license_subtitle_tool">Comparte esta herramienta: </span>
				  	  	<div class="fb-share-button" 
					    	data-href="<?php echo the_permalink(); ?>" 
					    	data-layout="button_count">
					  	</div>
					  	<a data-size="large" class="twitter popup" href="http://twitter.com/share"><img class="twpopup" src="<?php echo get_template_directory_uri().'/images/tweet.png' ?>"></a>	
				  </div>
				</center>
				  <hr>
			<?php 
	    		td_show_comments($id);
	    		echo td_form_comments($id)
	    	?>
			</div>
	    </div><!-- #primary -->
	</div><!-- .wrap -->
	<script>
		$('#show_more').click(function() {			
		  var test = $(this).text();
		  if(test == "Ver Mas"){
		  	$(this).text('Ver Menos');	
		  }
		  else{
		  	$(this).text('Ver Mas');		
		  }
		});

		$('#search_img').hover(function() {			
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_investigar_rolloveractivo.png'  ?>");
		}, function() {
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_investigar.png'  ?>");		  
		});

		$('#search_img').click(function() {			
		  $(this).addClass("intro");
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_investigar_rolloveractivo.png'  ?>");
		});

		$('#comunicate_img').hover(function() {			
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_comunicar_rolloveractivo.png'  ?>");
		}, function() {
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_comunicar.png'  ?>");
		  
		});

		$('#evaluate_img').hover(function() {			
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_evaluar_rolloveractivo.png'  ?>");
		}, function() {
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_evaluar.png'  ?>");
		  
		});

		$('#colaborate_img').hover(function() {			
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_colaborar_rolloveractivo.png'  ?>");
		}, function() {
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_colaborar.png'  ?>");
		  
		});

		$('#design_img').hover(function() {			
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_diseñar_rolloveractivo.png'  ?>");
		}, function() {
		  $(this).attr('src', "<?php echo get_template_directory_uri().'/images/iconos_diseñar.png'  ?>");
		  
		});
		$('.popup').click(function(event) {
		    var width  = 575,
		        height = 400,
		        left   = ($(window).width()  - width)  / 2,
		        top    = ($(window).height() - height) / 2,
		        url    = this.href,
		        opts   = 'status=1' +
		                 ',width='  + width  +
		                 ',height=' + height +
		                 ',top='    + top    +
		                 ',left='   + left;
		    
		    window.open(url, 'twitter', opts);
		    return false;
		});
	</script>
	<?php 
	get_footer();
}else{
	$url="/~sivtie/";
	wp_redirect($url);
}?>