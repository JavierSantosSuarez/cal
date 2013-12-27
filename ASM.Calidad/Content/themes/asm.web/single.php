<?php

$categories = get_categories('hide_empty=0');

if(have_posts()) while(have_posts()): the_post();

$current_cats = wp_get_post_categories( $post->ID );

$newsletter_cat = get_category_by_slug("newsletter");

$is_newsletter = (in_array($newsletter_cat->term_id,$current_cats)) ? true : false;

if($is_newsletter){ include 'template-newsletter.php'; exit; }

/* REDIRECT */
$redirect = get_post_meta($post->ID,'redirect',true);
if($redirect) header("location: ".$redirect);

get_header();


?>
<div class="content detach post-page">

<div class="row">
	<div class="span8 main-content single detach">
		<div class="inside block">
			<h2 class="single-title" style="margin-bottom:10px">Noticias</h2>
			<h3><?php the_title(); ?></h3>
			<div class="single-social">
				<span class="post-date"><?php the_date(); ?></span>
				
				<div style="float:right">
				<div class="fb-like" style="position:relative;top: -3px;" data-href="<?php the_permalink(); ?>" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div>
				
				<a href="https://twitter.com/share" class="twitter-share-button" data-via="asmred">Tweet</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				
				<!-- Place this tag where you want the +1 button to render -->
				<g:plusone size="medium"></g:plusone>
				
				<!-- Place this render call where appropriate -->
				<script type="text/javascript">
				  window.___gcfg = {lang: 'es'};
				
				  (function() {
				    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
				    po.src = 'https://apis.google.com/js/plusone.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
				  })();
				</script>
				
				
				<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
				<script type="IN/Share" data-url="<?php the_permalink(); ?>" data-counter="right"></script>
				
				</div>
				<div class="clear"></div>
				
			</div>
			<div class="post-content">
								
				<?php the_content(); ?>
				
				<?php 
				  if( function_exists( 'attachments_get_attachments' ) )
				  {
				    $attachments = attachments_get_attachments();
				    $total_attachments = count( $attachments );
				   ?>
				   <div class="attachments" style="margin-top:20px;">
				 
				      <ul style="list-style:none;margin: 0;padding: 0;">
				      <?php for( $i=0; $i<$total_attachments; $i++ ) : ?>
				      <?php 
				      
				      $type=(substr($attachments[$i]['mime'],0,5)=='image') ? 'image' : 'file';
				      
				      
				        if($type!='image'){ ?>
				     
				        <li><a href="<?php echo $attachments[$i]['location']; ?>"> <?php echo $attachments[$i]['title']; ?></a></li>
				         
				         <?php } ?>
				      <?php endfor; ?>
				      </ul> </div>
				  
				<?php } ?>
				
			</div>
		</div>
	</div>
	
	<div class="span4 sidebar single-sidebar">
			<div class="block detach post-thumbnail hidden-phone">
			<?php $thumbnail = get_post_picture($post->ID,'large'); ?>
			<?php if($thumbnail) echo'<img src="' . $thumbnail . '" alt="" />'; ?>
			</div>
			<div class="page-tree" style="padding: 8px 0;">
						<ul class="nav nav-list">
					 
						<li <?php if(!is_category()): echo 'class="active"'; endif; ?>><a href="<?php echo get_permalink(141); ?>">Todas las noticias</a></li>
					  <?php foreach($categories as $category): ?>
					  <?php $active = ($current_cat == $category->term_id) ? 'class="active"' : false; ?>
					  <?php $cat_newsletter = get_category_by_slug("newsletter"); if($category->term_id == $cat_newsletter->term_id or $category->category_parent == $cat_newsletter->term_id) continue; ?>
					  <li <?=$active?>>
					    <a href="<?php echo get_category_link($category->term_id);?>"><?=$category->name;?></a>
					  </li>
					  <?php endforeach; ?>
					  
						</ul>
			</div>
			
			<?php get_sidebar(); ?>
				
				
		
			
		</div>
	
</div>
</div>
<?php
endwhile;
get_footer();

?>