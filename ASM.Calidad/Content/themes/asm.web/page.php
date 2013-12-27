<?php


if(have_posts()) while(have_posts()): the_post();

/* REDIRECT */
$redirect = get_post_meta($post->ID,'redirect',true);
if($redirect) header("location: ".$redirect);

$ancestors = get_post_ancestors( $post );

$first     = get_post($ancestors[0]);
$ancestor_title = $first->post_title;

$args = array('post_parent' => $first->ID,
	          'sort_column'     => 'menu_order',
	          'order'       => 'ASC');

$children  = get_children($args);

/* If this is the parent, go to the first child 
if($ancestors[0]==null){
	$count = 0;
	foreach($children as $child):
	$count++;
	if($count==1):
		$link = get_permalink($child->ID);
		header("location: ".$link);
	endif;
	endforeach;
}
*/
get_header();


?>
<div <?php post_class('content detach post-page');  ?>>

<div class="row">
	<div class="span8 main-content">
		<div class="inside block">
			<h2 class="single-title" style="margin-bottom:10px"><?php echo $ancestor_title; ?> <span class="slash">/</span>
			<?php the_title(); ?></h2>
			<div class="post-content">
			<?php the_content(); ?>
			<?php 
			$html = get_post_meta($post->ID,'html',true);
			if($html) include $html;
			?>
			</div>
		</div>
	</div>
	
	<div class="span4 sidebar">
		<div class="page-tree" style="padding: 8px 0;">
				<ul class="nav nav-list">
			 
	
			  <?php foreach($children as $child): ?>
			  <?php $active = ($child->ID == $post->ID) ? 'class="active"' : false; ?>
			  <li <?=$active?>>
			    <a href="<?=get_permalink($child->ID);?>"><?=$child->post_title;?></a>
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