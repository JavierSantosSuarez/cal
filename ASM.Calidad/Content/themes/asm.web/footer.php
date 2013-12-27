</div> <!-- /.wrapper -->
  
<div class="footer-wrapper hidden-phone">

	<div class="container footer-logos">
		<ul class="footer-logos-upper-deck">
			<li><a href="http://www.puntoenvio.com" target="_blank" class="puntoenvio">Puntoenvío</a></li>
			<li><a href="http://www.asmred.com/wp/index.php/archivos/204" target="_blank" class="awards">ASM gana el premio eAwards de Logística</a></li>
			<li><a href="http://www.asmred.com/wp/index.php/archivos/770" target="_blank" class="icil">ASM recibe el premio a la Excelencia Logística de la Fundación ICIL</a></li>
			<div class="clear"></div>
		</ul>
		<ul class="footer-logos-lower-deck">
			<li><a href="http://www.clubasm.es" target="_blank" class="asm-club"> ASM Club</a></li>
			<li class="asm-logos"></li>
		</ul>
	</div>

	<div class="container block dark footer-links clear">
		 <div class="row">
		 	<div class="span12">
		 			<div class="row">
		 				
<?php $post = get_option('asm_loc_empresa'); $pageinfo = get_post($post); ?>		 				
		 				<div class="span2">
		 					<div class="inside">
		 					
		 					<ul>
		 						<li class="heading"><?=$pageinfo->post_title?></li>
		 						
		 			<?php 
		 			$args = array('post_parent' => $pageinfo->ID,
		 				          'sort_column'     => 'menu_order',
		 				          'order'       => 'ASC');
		 			
		 			$children  = get_children($args);
		 			foreach($children as $child):
		 			?>
		 						<li><a href="<?=get_permalink($child->ID);?>"><?=$child->post_title?></a></li>
		 			<?php endforeach; ?>			
		 					</ul>
		 					
		 					</div>
		 				</div>

<?php $post = get_option('asm_loc_servicios'); $pageinfo = get_post($post); ?>		 				
		 				<div class="span3">
		 					<div class="inside">
		 					
		 					<ul>
		 						<li class="heading"><?=$pageinfo->post_title?></li>
		 						
		 			<?php 
		 			$args = array('post_parent' => $pageinfo->ID,
		 				          'sort_column'     => 'menu_order',
		 				          'order'       => 'ASC');
		 			
		 			$children  = get_children($args);
		 			foreach($children as $child):
		 			?>
		 						<li><a href="<?=get_permalink($child->ID);?>"><?=$child->post_title?></a></li>
		 			<?php endforeach; ?>			
		 					</ul>
		 					
		 					</div>
		 				</div>
	 				
		 				<div class="span2">
		 					<div class="inside">
		 					
		 					<ul>
		 						<li class="heading">Noticias</li>
		 			<?php 
		 			
		 			
		 				
					$newsletter_cat = get_category_by_slug("newsletter");
					
					$newsletter_cats = get_categories('child_of=' . $newsletter_cat->term_id . '&hide_empty=0');
					
					$remove_cats = array($newsletter_cat->term_id);
					
					foreach($newsletter_cats as $cat):
					
					   $remove_cats[] = $cat->term_id;
					
					endforeach;
					
					$remove_cats = implode(",",$remove_cats);
		 			
		 			$categories  = get_categories('hide_empty=0&exclude='.$remove_cats);
		 			foreach($categories as $cat):
		 			?>
		 						<li><a href="<?=get_category_link($cat->term_id);?>"><?=$cat->name?></a></li>
		 			<?php endforeach; ?>				
		 					
		 					</ul>
		 					
		 					</div>
		 				</div>



<?php $post = get_option('asm_loc_storelocator'); $pageinfo = get_post($post); ?>		 				
		 				<div class="span2">
		 					<div class="inside">
		 					
		 					<ul>
		 						<li class="heading"><?=$pageinfo->post_title?></li>
		 						
		 			<?php 
		 			$args = array('post_parent' => $pageinfo->ID,
		 				          'sort_column'     => 'menu_order',
		 				          'order'       => 'ASC');
		 			
		 			$children  = get_children($args);
		 			foreach($children as $child):
		 			?>
		 						<li><a href="<?=get_permalink($child->ID);?>"><?=$child->post_title?></a></li>
		 			<?php endforeach; ?>			
		 					</ul>
		 					
		 					</div>
		 				</div>





		 				
		 				<div class="span3">
		 					<div class="inside">
		 					
		 					<ul>
		 						<li class="heading">Contacto</li>
		 						<li class="contactinfo">
		 						<p>SEDE CENTRAL</p>
		 						<p>Avda. Fuentemar, 18</p>
		 						<p>28823 Coslada - Madrid</p>
		 						<p>Tel: 902 11 33 00</p></li>
		 					</ul>
		 					
		 					</div>
		 				</div>
		 				
		 			</div>
		 	</div>
		 </div>

	</div>
	
	<div class="container">
		<div class="inside footer">
			
			<ul>
				<li>&copy; ASM <?=date("Y",time())?></li> 
				<?php 
				
				
				$args = array('post_parent' => 337,
					          'sort_column'     => 'menu_order',
					          'order'       => 'ASC');
				
				$children  = get_children($args);
				
				
				
				foreach($children as $child):
				
				 ?>
				<li><a href="<?php echo get_permalink($child->ID); ?>"><?php echo $child->post_title; ?></a></li>
				<?php endforeach; ?> 
			
			</ul>
		</div>
		
	</div>


</div> <!-- /.footer-wrapper -->

<div class="container footer visible-phone">
	<div class="inside footer">
		
		<ul>
			<li>&copy; ASM <?=date("Y",time())?></li> 
			<?php 
			
			
			$args = array('post_parent' => 337,
				          'sort_column'     => 'menu_order',
				          'order'       => 'ASC');
			
			$children  = get_children($args);
			
			
			
			foreach($children as $child):
			
			 ?>
			<li><a href="<?php echo get_permalink($child->ID); ?>"><?php echo $child->post_title; ?></a></li>
			<?php endforeach; ?> 
		</ul>
	</div>
	
</div>

<!-- Le modal windows -->
<div class="modal hide fade" id="privatezone" style="display:none;">
<form name="miform" id="miform" method="post" action="http://www.asmred.com/entrada.asp" style="margin:0">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <h3> <span class="icon-lock icon-large"></span> Zona Privada</h3>
  </div>
  <div class="modal-body">
    
    
  <div class="well">
    <p><label for="login">Usuario</label></p>
    <p><input type="text" id="login" name="login"></p>
    
    <p><label for="pass">Contraseña</label></p>
    <input type="password" id="pass" name="pass">
    <label class="radio">
      <input type="radio" name="tipoCliente" id="tipoCliente" value="0" class="radio" checked="true" />
      	Cliente
    </label>
    
    <label class="radio">
      <input type="radio" name="tipoCliente" id="tipoCliente" value="1" class="radio" />
      	Colaborador
    </label>

</div>  
    
    
    
  </div>
  <div class="modal-footer">
    <a href="#" class="btn" data-dismiss="modal">Cancelar</a>
    <input type="submit" value="Entrar" class="btn btn-primary" />
   
    
  </div>
  </form>
</div>





<!-- Le JavaScript at the end so the page loads faster -->
<!--<script src="http://twitter.github.com/bootstrap/assets/js/jquery.js"></script>-->
<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/bootstrap/js/bootstrap-carousel.js"></script>
<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/bootstrap/js/bootstrap-typeahead.js"></script>


<?php wp_footer(); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-35562663-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>