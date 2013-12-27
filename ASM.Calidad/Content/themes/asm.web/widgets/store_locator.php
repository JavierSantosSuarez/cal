<?php 

$address = (isset($_GET['address'])) ? $_GET['address'] : false;
$autoaddress=$address;
if($address == 'geolocate'){ $address=false; }


$height = (defined("HEIGHT")) ? HEIGHT : 200;
$sidebar_height = $height-30;

 ?>
 <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&language=es&region=ES"></script>
 <script type="text/javascript">
   var geocoder;
   var map;
   
   function initialize() {
     
     var myLatlng = new google.maps.LatLng(40.415391,-3.694324);
     var myOptions = {
       zoom: 6,
       center: myLatlng,
       mapTypeId: google.maps.MapTypeId.ROADMAP,
       panControl: false,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: true,
        overviewMapControl: false
     }
     
     var KMLOptions = {
      	preserveViewport: true
     }
     
     map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
 var georssLayer = new google.maps.KmlLayer('http://www.asmred.com/WebSrvs/infoasm.asmx/KMLPlazas',KMLOptions);
 georssLayer.setMap(map);

 
 
 	var autoaddress = $("#autoaddress").val();
 	
 	if(autoaddress){
 		if(autoaddress=='geolocate'){
 			geolocate();
 		} else {
 			codeAddress(autoaddress);
 		}
 		
 	}
 

   }
   
   
    function codeAddress(address) {
    		    if(!address)
    		    	var address = document.getElementById("address").value;
    		    
    		  geocoder = new google.maps.Geocoder();
    		   geocoder.geocode( { 'address': address }, function(results, status) {
    		   		      if (status == google.maps.GeocoderStatus.OK) {
    		   		        map.setCenter(results[0].geometry.location);
    		   		        map.setZoom(13);
    		   		        UpdateStoreList(address);
    		   		     //	$("#query").val(address);
    		   		      } else {
    		   		        $("#error-place-not-found").slideDown(400);
    		   		      }
    		   });
    	 }
    
   
</script>

 <script type="text/javascript" src="https://code.google.com/apis/gears/gears_init.js"></script>
 <script type="text/javascript">
 
 var initialLocation;
 var siberia = new google.maps.LatLng(60, 105);
 var madrid = new google.maps.LatLng(40.415391,-3.694324);
 var browserSupportFlag =  new Boolean();
 var map;
 var infowindow = new google.maps.InfoWindow();

  
 function geolocate() {
  
 map.setZoom(13);
  
   
   // Try W3C Geolocation method (Preferred)
   if(navigator.geolocation) {
     browserSupportFlag = true;
     navigator.geolocation.getCurrentPosition(function(position) {
       initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
       contentString = "";
       map.setCenter(initialLocation);
       UpdateStoreList(initialLocation);
       infowindow.setContent(contentString);
       infowindow.setPosition(initialLocation);
       infowindow.open(map);
     }, function() {
       handleNoGeolocation(browserSupportFlag);
     });
   } else if (google.gears) {
     // Try Google Gears Geolocation
     browserSupportFlag = true;
     var geo = google.gears.factory.create('beta.geolocation');
     geo.getCurrentPosition(function(position) {
       initialLocation = new google.maps.LatLng(position.latitude,position.longitude);
       contentString = "";
       UpdateStoreList(initialLocation);
       map.setCenter(initialLocation);
       infowindow.setContent(contentString);
       infowindow.setPosition(initialLocation);
       infowindow.open(map);
     }, function() {
       handleNoGeolocation(browserSupportFlag);
     });
   } else {
     // Browser doesn't support Geolocation
     browserSupportFlag = false;
     handleNoGeolocation(browserSupportFlag);
   }
 }
 
 function handleNoGeolocation(errorFlag) {
   if (errorFlag == true) {
     initialLocation = madrid;
     contentString = "Error: El servicio de geolocalización ha fallado.";
     $("#error-place-not-found").slideDown(400);
   } else {
     initialLocation = siberia;
     contentString = "Error: Tu navegador no tiene geolocalización. Vives en Siberia?";
     $("#error-place-not-found").slideDown(400);
   }
   map.setCenter(initialLocation);
   infowindow.setContent(contentString);
   infowindow.setPosition(initialLocation);
   infowindow.open(map);
 }
 
 function UpdateStoreList(postal){
 	if(!postal) postal = $("#address").val();
 	
 	$('#store_list').html('<b>Cargando Agencias ASM cercanas a '+postal+'...</b>');
 	

 	
 	return 1;	
 
 }
 
</script>

<script>

 google.maps.event.addDomListener(window, 'load', initialize);
 
 </script>
 

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

<!-- Store locator + ?? -->
<div class="container detach">

<div class="alert alert-error" id="error-place-not-found" style="display:none;">
  <a class="close" data-dismiss="alert">×</a>
  <strong>Error</strong> No hemos podido encontrar esta población. Te recomendamos utilizar el mapa para encontrarla.
</div>

<div class="row">
	<div class="span12">
		<div class="row store-locator">
			
			
			
			<div class="span8 block main-content">
				<div class="inside">
					
					
					<div class="inside highlight store-locator-box store-locator-page" style="margin-bottom:15px">
						<h2>Busca tu Agencia ASM más cercana</h2>
						
						<form id="geocode-form" method="get" class="form-inline push" />
						
						<div class="store-locator-inputs controls">
						
							<input type="text" value="<?php if($address){ echo $address; } else { echo'Código postal o ciudad'; } ?>" onfocus="if(this.value==this.defaultValue) this.value='';" onblur="if(this.value=='') this.value=this.defaultValue;" placeholder="Código postal o ciudad" class="input-medium typeahead store-locator-city enlarge" name="address" id="address">
							
							
							<input type="submit" value="Buscar" id="find" class="btn" />
							
							<input type="hidden" id="autoaddress" value="<?=$autoaddress?>" />
							
						</div>
						</form>
						<hr style="margin: 10px 0" />
						<p>
							<a href="?address=geolocate" class="icon-search btn geocode enlarge"> Localiza mi posición actual</a>
						</p>
					</div>
					<div class="clear"></div>
					
					
					
					
					<div id="map_canvas" class="hidden-phone" style="width:100%;height: <?=$height?>px;"></div>
					
					
					
					
					<hr />
					
					<?php if($address) include TEMPLATEPATH . '/storelocator/results.php'; ?>
					
					
					
				</div>
			</div>
			
			<div class="span4 sidebar" >
				
				
				
				
				
					<div class="page-tree" style="padding: 8px 0;">
									<ul class="nav nav-list">
								 
						<li class="active">
						  <a href="/wp/index.php/centros/centro-asm-mas-cercano/">Agencia ASM más cercana</a>
						</li>
								  			  			  <li>
								    <a href="/wp/index.php/centros/quiero-ser-centro-asm/">Quiero ser agencia ASM</a>
								  </li>
								  			  	
								  			  
									</ul>
								</div>
					
					<?php get_sidebar(); ?>
				
			</div>
			
		</div>
	
	</div>        
</div>
</div>


