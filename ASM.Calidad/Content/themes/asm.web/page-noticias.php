<?php
$categories = get_categories('hide_empty=0');


if(is_category()){
	$current_cat = get_query_var('cat');
	$category_name = '<span class="slash">/</span> ' . single_cat_title(null,false);
	
}

get_header();


?>
<div class="content detach post-page">


<!--<div  style="border-bottom:1px #DDD solid;">
<div class="row">
	<div class="span3">
		<div class="inside">
			<h1 class="single-title"><?php echo $ancestor_title; ?> <span class="slash">/</span></h1>
		</div>
	</div>
	<div class="span9">
		<div class="inside">
			<h1 class="single-title"><?php the_title(); ?></h1>
		</div>
	</div>
</div>
</div>
-->

<div class="row">
	
	<div class="span8 main-content">
		<div class="inside block">
			<h2 class="single-title" style="margin-bottom:10px">
			Noticias <?php echo $category_name; ?></h2>
			<div class="post-content news">
					<?php 
					global $wp_query, $wp_rewrite;
					$wp_query->query_vars['paged'] > 1 ? $current = $wp_query->query_vars['paged'] : $current = 1;
					
					
					$newsletter_cat = get_category_by_slug("newsletter");
					
					$newsletter_cats = get_categories('child_of=' . $newsletter_cat->term_id . '&hide_empty=0');
					
					$remove_cats = array("-".$newsletter_cat->term_id);
					
					foreach($newsletter_cats as $cat):
					
					   $remove_cats[] = "-".$cat->term_id;
					
					endforeach;
					
					$remove_cats = implode(",",$remove_cats);
					

					if(!is_category()) query_posts( 'paged='.get_query_var('paged').'&cat='.$remove_cats);
					
					
					
					if(have_posts()):
					 while(have_posts()): the_post(); 
					 ?>
			
					<div class="post">
						
						<div class="post-thumbnail">
						<?php $thumbnail = get_post_picture($post->ID); ?>
						<?php if($thumbnail) echo'<img src="' . $thumbnail . '" alt="" />'; ?>
						</div>
						
						<div class="post-headline">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<div class="hidden-phone post-excerpt">
							<?php the_excerpt(); ?>
							</div>
						<a href="<?php the_permalink(); ?>" class="read-more">​Leer más​</a>​
						</div>
					<div class="clear"></div>	
					</div>
					
					<div class="clear"></div>	
					
					<?php 
					endwhile;
					else:
						echo '<h4>Aún no hay noticias en esta categoria</h4>';
					endif;
					?>
					
					
					<?php 
					
					
					$pagination = array(
						'base' => @add_query_arg('paged','%#%'),
						'format' => '',
						'total' => $wp_query->max_num_pages,
						'current' => $current,
						'show_all' => false,
						'end_size' => 2,
						'mid_size' => 3,
						'type' => 'plain',
						'prev_text'    => __('&laquo;'),
						'next_text'    => __('&raquo;')
						);
					
					if( $wp_rewrite->using_permalinks() )
						$pagination['base'] = user_trailingslashit( trailingslashit( remove_query_arg( 's', get_pagenum_link( 1 ) ) ) . 'page/%#%/', 'paged' );
					
					if( !empty($wp_query->query_vars['s']) )
						$pagination['add_args'] = array( 's' => get_query_var( 's' ) );
					echo' <div class="pagination-custom">';
					echo paginate_links( $pagination );
					echo '</div>';
					?>
					
			</div>
		</div>
	</div>
	
	
	
	<div class="span4 sidebar">
			
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

get_footer();

?>