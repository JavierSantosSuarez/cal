<div class="block detach hidden-phone" style="overflow:hidden;position: relative;">
	<div class="inside">
		<div class="sidebar-banners widget">
		
			<?php
			
			$loc = get_term_by('slug','barra-lateral','ubicaciones');
			
			$args = array(
			 'numberposts' => -1,
			 'post_type' => 'banner',
			 'tax_query' => array(
			              array(
			              'taxonomy' => 'ubicaciones',
			              'field' => 'slug',
			              'terms' => 'barra-lateral'
			                 )
			                 ));
			
			$banners = get_posts($args);
			
			if(count($banners)>0):
			
			foreach($banners as $banner): 
			
			$banner_url = get_post_picture($banner->ID);
			
			?>
			
			     <div><a href="<?php echo get_post_meta($banner->ID,"banner_link",true); ?>" class="banner" style="background:url(<?php echo $banner_url; ?>); ?>"><?php echo $banner->post_title; ?></a></div>
			     
			<?php endforeach; ?>
			<?php else : ?><div><a href="<?php echo get_pagelink('farecalculator'); ?>" class="banner banner-fare-calculator">Calcula tu envío</a></div>
		
			<div><a href="/" class="banner banner-tracking">Seguimiento de envíos</a></div>
			
			<div><a href="<?php echo get_pagelink('storelocator'); ?>" class="banner banner-agencias-asm">Busca tu Agencia ASM más cercana</a></div>
			<?php endif; ?>
		</div>
		
		
		
		  <script>
		$('.sidebar-banners').after('<div id="nav" class="hidden-IE">').cycle({
		    fx: 'fade', 
		    timeout: 5000,
		    pager:  '#nav' 
		 });
		
		
		</script>
		<style>
		#nav {
			 position: absolute;
			 z-index: 1000;
			 bottom: 5px;
			 left: 0;
			 width: 100%;
			 text-align: center;
		}
		
		#nav a {
			background: #FFF;
			color: #FFF;
			margin: 0px 7px;
			-webkit-border-radius: 20px;
			padding: 0px 3px;
			font-size: 8px;
			opacity: 0.8;
		}
		#nav a.activeSlide {
			opacity: 1;
		}
		#nav a:hover {
			opacity: 1;
		}
		</style>
		
		
	</div>	
</div>
<div class="hidden-phone">
<?php 
	dynamic_sidebar('sidebar');
?>	
<!--<div class="block detach">
	<div class="inside">
		<h2 class="">
		
		Subscríbete a <br />nuestra Newsletter</h2> 
		
		
		Begin MailChimp Signup Form 
		<div id="mc_embed_signup">
		<form action="http://clickcomunicacio.us4.list-manage.com/subscribe/post?u=b12d68408c10c52a18278d4c4&amp;id=a8fc1405b7" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate well" target="_blank" style="margin:0">
			
		<div class="mc-field-group">
			<label for="mce-EMAIL"><h6>E-mail  </h6>
		</label>
			<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL">
		</div>
			<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
			</div>	<div class="clear"><input type="submit" value="Subscribirse" name="subscribe" id="mc-embedded-subscribe" class="button btn"></div>
		</form>
		</div>
		
			
		
		</div>
	</div>
-->

	
	</div>
	
	

	

	
