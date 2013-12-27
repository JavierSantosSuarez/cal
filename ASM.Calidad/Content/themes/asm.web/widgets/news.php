<div class="container detach">



	<div class="block home-news">

		

			

					<h2>Noticias <a href="/wp/index.php/noticias">ver más...</a></h2>

					

					<div class="row-fluid">

						

						<?php 



					/* Nuevas agencias */

					$nuevas_agencias_asm_cat = get_category_by_slug("agencias");			

					/*$remove_cats_agencias[] = "-".$nuevas_agencias_asm_cat->term_id;*/







						query_posts( 'posts_per_page=1&cat=22'/* . $remove_cats_agencias */);

							while(have_posts()): the_post();

							?>

			

							<div class="span4" id="bloque-nuevas-agencias">

								<div class="inside story-1" style="padding-right:15px;">

									<div class="post-thumbnail">

										<?php $thumbnail = get_post_picture($post->ID); ?>

										<?php if($thumbnail) echo'<img src="' . $thumbnail . '" alt="" />'; ?>

									</div>

									<div class="post-headline">

									<h3>Nuevas agencias</br><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

									<div class="hidden-phone post-excerpt"><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>" class="read-more">Leer más</a></div>

									</div>

								</div>

							</div>

					<?php endwhile; ?>

					<?php wp_reset_query();	

					



					/* Todas las noticias*/

					$newsletter_cat = get_category_by_slug("newsletter");

					

					$newsletter_cats = get_categories('child_of=' . $newsletter_cat->term_id . '&hide_empty=0');

					

					$remove_cats = array("-".$newsletter_cat->term_id);

					

					foreach($newsletter_cats as $cat):

					

					   $remove_cats[] = "-".$cat->term_id;

					

					endforeach;







					/* filtrar cat nuevas-agencias-asm */

					$agencias_cat = get_category_by_slug("nuevas-agencias-asm");

					

					$agencias_cats = get_categories('child_of=' . $agencias_cat->term_id . '&hide_empty=0');

					

					$remove_cats = array("-".$agencias_cat->term_id);

					

					foreach($newsletter_cats as $cat):

					

					   $remove_cats[] = "-".$cat->term_id;

					

					endforeach;

					

					$remove_cats = implode(",",$remove_cats);

				

						query_posts( 'posts_per_page=2&cat=' . $remove_cats );

			

						while(have_posts()): the_post();

						 ?>

			

						<div class="span4">

							<div class="inside story-<?=$i?>">

								<div class="post-thumbnail">

									<?php $thumbnail = get_post_picture($post->ID); ?>

									<?php if($thumbnail) echo'<img src="' . $thumbnail . '" alt="" />'; ?>

								</div>

								<div class="post-headline">

								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

								<div class="hidden-phone post-excerpt"><?php the_excerpt(); ?> <a href="<?php the_permalink(); ?>" class="read-more">Leer más</a></div>

								</div>

							</div>

						</div>

						

						

						<?php endwhile; ?>

						

					</div>

					

					

			

			

	</div>



</div>