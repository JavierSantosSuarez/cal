<?php


function openRemote($path){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        $retValue = curl_exec($ch);                      
        curl_close($ch);
        return $retValue;
}

function store($data){
	$template = '
	<div class="store">
	
		<img src="http://maps.google.com/maps/api/staticmap?center={DIRECCION}&zoom=15&size=200x130&&markers=color:red|icon:http://www.asmred.com/img/marcaGoogleAsm01.png|size:mid|{DIRECCION}&sensor=true&region=ES" />
		<div class="store-info">
			<h4>{NAME}</h4>
			<p>{DIRECCION}</p>
			<p><b>Tel</b>: {TELEFONO}</p>
			<p><b>Fax</b>:{FAX}</p>
			<p><b>E-mail</b>: {MAIL}</p>
			<p><b>Horario</b>: {HORARIO}</p>
			<p><b>Responsable</b>: {RESPONSABLE}</p>
		</div>
		
		<div class="clear"></div>
	</div>';
	
	$template = str_replace("{NAME}",$data['NAME'],$template);
	$template = str_replace("{COORDENATES}",$data['COORDENATES'],$template);
	$template = str_replace("{DIRECCION}",$data['DIRECCION'],$template);
	$template = str_replace("{TELEFONO}",$data['TELEFONO'],$template);
	$template = str_replace("{FAX}",$data['FAX'],$template);
	$template = str_replace("{MAIL}",$data['MAIL'],$template);
	$template = str_replace("{HORARIO}",$data['HORARIO'],$template);
	$template = str_replace("{RESPONSABLE}",$data['RESPONSABLE'],$template);
	
	$gdireccion = ($data['COORDENATES']) ? $data['COORDENATES'] : $data['DIRECCION'];
	$template = str_replace("{GDIRECCION}",$gdireccion,$template);
	
	return $template;
}

$address = (isset($_REQUEST['address'])) ? $_REQUEST['address'] : false;

if(!$address) $address = $_REQUEST['origin'];

$address = str_replace("(","",$address);
$address = str_replace(")","",$address);
if(is_numeric(substr($address,0,2))) $address = str_replace(", ",",",$address);

$typed_address=$address;
if(!$address) exit();


	$address = (is_numeric(substr($address,0,5))) ? substr($address,0,5) : $address;

	/*
		Google Maps API
		Asks for Province Name
		for given coordenates
	*/
	if(!is_numeric(substr($address,0,1))): //This is not the best way to do this, but it works so fuck you!
		$request = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address."&region=ES&sensor=false";
		
		$json = openRemote($request);
		$json = json_decode($json,true);
		$coordenates = $json['results'][0]['geometry']['location'];
		$address = $coordenates['lat'].",".$coordenates['lng'];
		
	endif;
	
	$request = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address . "&region=ES&sensor=false&language=es";
	
	$json = openRemote($request);
	
	$json = json_decode($json);

	
	$info = $json->results[0]->address_components;
	
	if(is_array($info)):
		foreach($info as $fact):
	
			if(in_array("administrative_area_level_2", $fact->types)){ $province = $fact->long_name; }
			
			if(in_array("postal_code", $fact->types)){ $postal = $fact->long_name; }
			
			if(in_array("locality", $fact->types)){ $town = $fact->short_name; }
			
		endforeach;
	endif;


// Now that we have a Postal Code NO MATTER WHAT, we'll ask the webservice...
// Wait... why if Google Failed??
// But... Google can't fail! can it????
// Duuuuh
	if(!$postal or $postal==','){ $postal = $typed_address; }
	if(!$town)  { $town = $typed_address;   }



if($postal){
	$postalXML = "http://www.asmred.com/WebSrvs/infoasm.asmx/Plazas?direccion=".$postal."&codpais=34";
	$postalXML 		= openRemote($postalXML);
	$postal = simplexml_load_string($postalXML);
} 

//As a fallback, we'll also query for the province...
if($province){
	$provinceXML = "http://www.asmred.com/WebSrvs/infoasm.asmx/Plazas?direccion=".$province."&codpais=34";
	$provinceXML 	= openRemote($provinceXML);
	$province_text = $province;
	$province = simplexml_load_string($provinceXML);
}





?>
<div id="stores-list" class="stores-list">
	<h2 style="margin-bottom:10px;">Agencia(s) ASM cerca de <span style="text-transform:capitalize;background: #fbf8a7;"><?=$town?></span></h2>	
<?php

$postalplazas = $postal->Plaza;
$provinceplazas = $province->Plaza;
$shown_already = array();
$i=1;
if(is_object($postalplazas) && count($postalplazas)>0):
foreach($postalplazas as $plaza): 
		$args = array(
			'NAME' => $plaza->Nombre,
			'COORDENATES' => $plaza->Longitud . "," . $plaza->Latitud,
			'DIRECCION' => $plaza->Direccion,
			'TELEFONO' => $plaza->Telefono,
			'FAX' => $plaza->Fax,
			'MAIL' => $plaza->Email,
			'HORARIO' => $plaza->HorarioOficina,
			'RESPONSABLE' => $plaza->Responsable,
			'GERENTE' => $plaza->Gerente
		);
		
		
		echo store($args);
		
		if($i==2){ echo "<div class='clear'></div>"; $i=0; }
		
		$i++;
		
		$shown_already[] = (int)$plaza->Codigo;
		
 endforeach; 
 else:
 
 	?>
 	
 	<div class="alert alert-error" id="error-place-not-found">
 	  <a class="close" data-dismiss="alert">×</a>
 	 No hemos podido encontrar Agencias ASM cerca de <b><?php echo $town; ?></b>.
 	</div>
 	<?php
 
 endif;
 
 if(is_object($provinceplazas)):
 ?>
	<div class="clear"></div>
	<h3 style="margin-bottom:10px;">Otras Agencias ASM en la provincia de <span style="text-transform:capitalize;background: #fbf8a7;"><?=$province_text?></span></h3>	
<?php 
$i=1;
foreach($provinceplazas as $plaza): 
		
		if(in_array($plaza->Codigo,$shown_already)) continue;
		
		$args = array(
			'NAME' => $plaza->Nombre,
			'COORDENATES' => $plaza->Longitud . "," . $plaza->Latitud,
			'DIRECCION' => $plaza->Direccion,
			'TELEFONO' => $plaza->Telefono,
			'FAX' => $plaza->Fax,
			'MAIL' => $plaza->Email,
			'HORARIO' => $plaza->HorarioOficina,
			'RESPONSABLE' => $plaza->Responsable,
			'GERENTE' => $plaza->Gerente
		);
		
		
		echo store($args);
		
		
		
 endforeach; 
endif;
 ?>
 <div class='clear'></div>
</div> 
