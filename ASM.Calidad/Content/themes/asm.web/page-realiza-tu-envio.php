<?php

if(have_posts()) while(have_posts()): the_post();
get_header();

$possible_numbers = array();
for($num=0;$num<=20;$num=$num+0.25):
	$possible_numbers[] = str_replace(".",",",$num);
endfor;
$possible_numbers = json_encode($possible_numbers);

$possible_numbers_2 = array();
for($num=0;$num<=20;$num=$num+1):
	$possible_numbers_2[] = str_replace(".",",",$num);
endfor;
$possible_numbers_2 = json_encode($possible_numbers_2);
?>
<style>
	.ui-autocomplete {
		max-height: 200px;
		overflow-y: auto;
		/* prevent horizontal scrollbar */
		overflow-x: hidden;
		/* add padding to account for vertical scrollbar */
		padding-right: 20px;
	}
	/* IE 6 doesn't support max-height
	 * we use height instead, but this forces the menu to always be this tall
	 */
	* html .ui-autocomplete {
		height: 100px;
	}
	</style>
<script>
	$(function() {
		$("#origin, #destination").autocomplete({
		source:function( request, response ) {
						$.ajax({
							//url: "http://ws.geonames.org/searchJSON",
							
							url: "http://api.geonames.org/postalCodeSearchJSON",
							dataType: "jsonp",
							data: {
								username: "clickcom",
								maxRows: 40,
								country: 'ES',
								placename_startsWith: request.term
							},
							success: function( data ) {
								response( $.map( data.postalCodes, function( item ) {
									return {
										label: item.postalCode + " - " + item.placeName,
										value: item.postalCode + " - " + item.placeName
									}
								}));
							}
						});
					}}).focus(function(){            
		            $(this).trigger('keydown.autocomplete');
		        });
	});
	
	
	
	$(function() {
		
		var availableTags = <?php echo $possible_numbers; ?>;
	
		$(".number").autocomplete({
		source:function( request, response ) {
		    var matches = $.map( availableTags, function(tag) {
		      if ( tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
		        return tag;
		      }
		    });
		    response(matches);
		  }
	});
	});
	
	$(function() {
		
		var availableTags = <?php echo $possible_numbers_2; ?>;
	
		$(".bulks").autocomplete({
		source:function( request, response ) {
		    var matches = $.map( availableTags, function(tag) {
		      if ( tag.toUpperCase().indexOf(request.term.toUpperCase()) === 0 ) {
		        return tag;
		      }
		    });
		    response(matches);
		  }
	});
	});
	</script>
<div class="content detach post-page">



<div class="row">		
		<div class="span8 main-content realiza-tu-envio">
		
				
					<div class="inside block detach">
						<h2 class="single-title" style="margin-bottom:10px"><?php the_title(); ?></h2>
						<div class="post-content">
						
			
			
						
			<form id="farecalculator-form" method="post" action="" class="well push form-inline" style="margin-bottom:0;">
				
			
				<div class="row-fluid">
					<div class="span6">
						<h6>CIUDAD ORIGEN</h6>
						
						<input id="origin" name="origin" class="required" type="text" style="width:97%" value="<?php if($_REQUEST['origin']) echo $_REQUEST['origin']; ?>" />
						
						
					</div>
					<div class="span6">
						<h6>CIUDAD DESTINO</h6> 
						<input id="destination" name="destination" class="required" type="text"  style="width:99%" value="<?php if($_REQUEST['destination']) echo $_REQUEST['destination']; ?>" />
						
					</div>
				</div>
				
				<hr style="margin: 7px 0" />
				
				
				<div class="row-fluid">
					<div class="span3 fc-bulks">
						<h6>BULTOS</h6>
						
						<input class="input-mini input-number required bulks" name="bulks" type="text" value="<?php if($_REQUEST['bulks']) echo $_REQUEST['bulks']; ?>" />
						
						
					</div>
                                    
                   <div class="span3 fc-weight">
						<h6>PESO</h6>
						<div class="input-append">
						<input class="input-mini input-number required number" name="weight" type="text" style="" value="<?php if($_REQUEST['weight']) echo $_REQUEST['weight']; ?>" /><span class="add-on">kg</span>
						</div>
						
					</div>
					
					<div class="span2 fc-length">
						<h6>LARGO</h6>
						
						<input class="input-mini input-number required number" type="text" name="length" value="<?php if($_REQUEST['length']) echo $_REQUEST['length']; ?>"  />
						
						
					</div>
					<div class="span2 fc-width">
						<h6>ANCHO</h6>
						
						<input class="input-mini input-number required number" type="text" name="width" value="<?php if($_REQUEST['width']) echo $_REQUEST['width']; ?>"  /> 
						
						
					</div>
					<div class="span2 fc-height">
						<h6>ALTO</h6>
						<div class="input-append">
						<input class="input-mini input-number required number" type="text" name="height" value="<?php if($_REQUEST['height']) echo $_REQUEST['height']; ?>"  /><span class="add-on">cm</span> 
						</div>
						
					</div>
				</div>
						
				
					
				
					<hr style="margin: 7px 0" />
				<div>
						<input  type="submit" class="btn btn-primary" value="Calcular" />
				</div>
				
				
				
				</form>			
				
				
		<hr />
			
		<?php if($_POST) include 'farecalculator/results.php'; ?>		
		
		<?php if($_POST) include 'storelocator/results.php'; ?>	
						
		<script>
		var base = "<?php bloginfo('stylesheet_directory'); ?>";
		
		$("#farecalculator-form").submit(function(){
			hasErrors = false;
			$(".alert-error").hide();
			$('.required').each(function() {
				var thisfield = $(this).val();
				
				if(thisfield==''){
					hasErrors = true;
					$(this).addClass('input-error');
				} else {
					$(this).removeClass('input-error');
				}	
			});
			
			if(!hasErrors){
			
				$(this).submit();
				
			} else {
				$(this).prepend('<div class="alert alert-error">Faltan campos por rellenar</div>');
			}
			
			return false;
		});
		
		
		
		</script>
					
		</div>
	</div>
</div>
		
		
		
		
		
		<div class="span4 sidebar">
			
			<?php get_sidebar(); ?>
		</div>
</div>
</div>
<?php
endwhile;
get_footer();

?>