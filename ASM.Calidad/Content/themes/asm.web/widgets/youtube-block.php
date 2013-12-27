<?php
/************************************************
	Bloque de youtube de la home. ASMRED tv.
************************************************/
?>

<div class="container detach hidden-phone">
	<div class="row">
		<div class="span12 block">
			<div class="row">
				<div class="span12">
				
					
				
					<div class="inside story-1 asmtv" id="youtube-bloque">
						<a href="http://youtube.com/MarketingASM" target="_blank"><h2 style="margin-top:-5px;">ASMRED tv</h2></a>


							<div class="hidden-tablet hidden-phone">
								<?php embed_youtube_feed(); ?> 
							</div>
							<div class="visible-tablet" id="youtube-tablet">
								<?php embed_youtube_feed(); ?> 
							</div>
		
							<div class="visible-phone">
								<?php embed_youtube_feed(); ?> 
							</div>

					</div>





					
				</div>
					
				
			</div>
		</div>
	</div>
</div>