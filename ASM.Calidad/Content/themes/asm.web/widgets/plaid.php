<?php



?>
<script>
$('#asm-hero').cycle({
    fx: 'fade', 
    timeout: 5000,
    next:   '#next', 
    prev:   '#prev' 
 });


</script>

<div class="carousel slide hidden-phone">
      <div id="asm-hero">      
              
              <?php query_posts( 'post_type=banner&ubicaciones=pagina-principal' );  ?>
              <?php if(have_posts()): while(have_posts()): the_post(); ?>
              <?php $the_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'banner' ); 
              	    
              ?>
              <div class="asm-hero-item">
                <a href="<?php echo get_post_meta($post->ID,'banner_link',true);?>" style="background-image: url('<?=$the_thumbnail[0]?>');">
   	             
                </a>         
              </div>
            <?php endwhile; ?> 
            
            <?php else: ?>  
            
            
              <?php query_posts( 'post_type=banner' );  ?>
              <?php while(have_posts()): the_post(); ?>
              <?php $the_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'banner' ); 
              	    
              ?>
              <div class="asm-hero-item">
                <a href="<?php echo get_post_meta($post->ID,'banner_link',true);?>" style="background-image: url('<?=$the_thumbnail[0]?>');">
   	             
                </a>         
              </div>
            <?php endwhile; ?> 
            
            
            <?php endif; ?>
            
            
            
            
            
        
	</div> <!-- /#asm-hero-->
         <div class="controls">
         	<a class="carousel-control left" href="#" id="prev">&lsaquo;</a>
         	 <a class="carousel-control right" href="#" id="next">&rsaquo;</a>
         </div>  
</div>