<?php

global $post;


define("TEMPLATE_URL", get_bloginfo('stylesheet_directory'));




?>
<!DOCTYPE html>
<html dir="ltr" lang="es-ES"  xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>
    ASM Red | Newsletter	</title>
	<style>
	body { margin:20px; background:#d40046; }
	a { color: #d40046; }
	strong { color:#d40046; }
	.wrapper { width: 630px; margin:0 auto; }
	
	.question{color:#d40046; font-size:15px; }
	.answer { color: #666; }
	
	h2 { margin-top:0;  line-height:150%; }
	p {  font-size: 14px; line-height:175%; }
	.issue_name { font-size: 18px; }
	
	.aligncenter {
    	text-align: center;
	}
	.size-full, .size-large {width:100%;height:auto !important;}
	.alignleft { float:left; margin: 0 10px 10px 0; }
	.alignright { float:right; margin: 0 0 10px 10px; }
	
	</style>
	
</head>

<body>
<center>
	<table cellpadding="15" cellspacing="0" border="0" width="630"
		style="background:#FFF;font-family:Arial,sans-serif;font-size:13px;text-align:left;">
		<tr>
			<td width="300" style="border-bottom:1px #DDD solid;">
				<a href="/"><h1 style="margin:0;padding:0;"><img src="<?php echo TEMPLATE_URL ?>/images/newsletter/asm-news.png" alt="ASM News" title="ASM News" border="0" /></h1></a>
			</td>
			<td width="300" valign="top" style="text-align:right;font-size:13px;color:#777;border-bottom:1px #DDD solid;">
				
				<div style="text-align:right;">
					<img src="<?php echo TEMPLATE_URL ?>/images/newsletter/tel.png" border="0" alt="902 11 33 00" title="" />
					<a href="https://www.facebook.com/ASMRED"><img src="<?php echo TEMPLATE_URL ?>/images/newsletter/facebook.png" border="0" alt="Facebook" title="" /></a>
					<a href="http://twitter.com/#!/asmred"><img src="<?php echo TEMPLATE_URL ?>/images/newsletter/twitter.png"  border="0" alt="Twitter" title="" /></a>
					<a href="http://www.youtube.com/user/MarketingASM"><img src="<?php echo TEMPLATE_URL ?>/images/newsletter/youtube.png"  border="0" alt="YouTube" title="" /></a>
				</div>
				<div style="margin: 5px 0px;">
					<a href="mailto:asmnews@asmred.com"><img src="<?php echo TEMPLATE_URL ?>/images/newsletter/email.png" border="0" alt="asmnews@asmred.com" title="asmnews@asmred.com" /></a>
				</div>		
				<?php
				$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				$post_month = get_the_date("m")-1;
				$post_year = get_the_date("Y");
				
				echo "<span class='issue_name'>" . $months[$post_month];
				echo " " . $post_year . "</span>";
				?>
			</td>
		</tr>
		
		
		<?php 
		
		
		if(isset($_GET['print'])){} $articles = explode(",",base64_decode($_GET['print']));
		
		if(isset($articles) && is_array($articles)){
			
		} else {
			$articles = array($post->ID);
		}
		
		
		foreach($articles as $article): 
		
		if($article == 'false') continue;
		
		$post = get_post($article);
		setup_postdata($post);
		
		$current_cats = wp_get_post_categories( $post->ID );
		$newsletter_cat = get_category_by_slug("newsletter");
		$newsletter_cat = $newsletter_cat->term_id;

		foreach($current_cats as $key=>$value):
    
		    if($value != $newsletter_cat){ 
		        $current_cat = $value;   
		    }

		endforeach;

		$category = get_category($current_cat);
		
		?>
		<!-- News -->
		<tr>
			<td colspan="2" style="border-bottom: 2px #d40046 solid;padding:10px 15px;">
				<h2 style="margin:0;padding:0;font-size: 22px;color:#d40046;font-family:Arial,sans-serif;">
					<img src="<?php echo TEMPLATE_URL ?>/images/newsletter/noticias.png" style="vertical-align: middle;" width="30" /> <?php echo $category->cat_name; ?>
				</h2>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="line-height:150%;color:#333">
				
				
				
				<?php if($category->slug == 'la-voz-asm'): ?>
				<img src="<?php echo get_post_picture($post->ID,'large'); ?>" width="600"  border="0" alt="" title=""  alt="" title="" border="0" /> 
				<?php else: ?>
				<h2><?php the_title(); ?></h2>
				
				
				
				<?php the_content(); ?>
				<?php endif; ?>
				
				
			</td>
		</tr>
		<?php endforeach; ?>
		
	</table>
</center>

</body>
</html>