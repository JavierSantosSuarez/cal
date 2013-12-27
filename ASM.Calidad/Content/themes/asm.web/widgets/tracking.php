<div class="container detach ">
<div class="row">
	<div class="span4 block fare-calculator middle-box">
				
					<a href="<?php echo get_pagelink('farecalculator'); ?>" style="color:#333"><h2>Calcula tu envío</h2></a>
					
				
			</div>
			
			
			
			
			<div class="span4 block parcel-tracking middle-box">
				<div class="inside highlight rounded">
					<h2 style="margin-bottom: 29px;">Seguimiento<br /> de envíos</h2>
					
					<form action="http://www.asmred.com/extranet/public/ExpedicionASM.aspx" class="push form-inline" style="margin-bottom:0;" method="get" target="_blank">
					
						<hr style="margin: 7px 0" class="hr-on-dark" />
						
						<h6>Código de envío / Albarán</h6>
						
						<input type="text" name="codigo">
						
						<h6 style="margin-top:6px;">Código postal de envío</h6>
						
						<input type="text"  name="cpDst" >
						
						<hr style="margin: 7px 0" class="hr-on-dark" />
						
						<div> 
							<input type="submit" class="btn btn-primary" value="Encontrar" />	
						</div>
						
					</form>
					
					
				</div>
			</div>
			<script>
 	$(function() {
 		$("#address").autocomplete({
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
 										value: item.postalCode
 									}
 								}));
 							}
 						});
 					}}).focus(function(){            
 		            $(this).trigger('keydown.autocomplete');
 		        });
 	});
 	
 </script>

			
			
			
			
			<div class="span4 block store-locator-home  middle-box"  >
				<div class="inside highlight store-locator-box store-locator-home">
					<h2>Busca tu <br />Agencia ASM<br /> más cercana</h2>
					
					<form class="form-inline" method="get" action="<?php echo get_pagelink('storelocator'); ?>" style="margin:0;" />
					<div class="store-locator-inputs controls">
					
						<input type="text" value="Código postal o ciudad" onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;" placeholder="Código postal o ciudad" class="input-medium typeahead store-locator-city enlarge" name="address" id="address">
						
						
						<input type="submit" value="Buscar" class="btn" />
					
					</div>
					</form>
					<hr style="margin: 10px 0" />
					<p style="margin-bottom:40px">
						<a href="<?php echo get_pagelink('storelocator'); ?>?address=geolocate" class="icon-search btn geocode enlarge"> Localiza mi posición actual</a>
					</p>
				</div>
			</div>
			
			
			
			
			
		</div>
	
	</div>        
