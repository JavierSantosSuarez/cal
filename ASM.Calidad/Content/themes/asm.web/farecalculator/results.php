<?php 

include 'functions.php';

setlocale(LC_MONETARY, 'es_ES');

$site_url = get_bloginfo('stylesheet_directory');
$services = array(
	'ASM 8:30' => array(
		'image' => $site_url.'/images/icons/iconos-servicios-1.jpg',
		'title'=>'Entrega a primera hora de la mañana',
		'description'=>'Servicio con entrega antes de las 8:30 horas del día siguiente de la recogida.'),
	'ASM10' => array(
		'image' => $site_url.'/images/icons/iconos-servicios-2.jpg',
		'title'=>'Entrega antes de las 10:00 horas',
		'description'=>'Servicio puerta a puerta con entrega en cualquier población y destino antes de las 10:00 horas del día laborable siguiente a su recogido.'),
	'ASM14' => array(
		'image' => $site_url.'/images/icons/iconos-servicios-3.jpg',
		'title'=>'Entrega antes de las 14:00 horas',
		'description'=>'Servicio puerta a puerta con entrega en cualquier población y destino antes de las 14:00 horas del día laborable siguiente a su recogido, sin recargo para cualquier población.'),
	'ASM24' => array(
		'image' => $site_url.'/images/icons/iconos-servicios-4.jpg',
		'title'=>'Entrega antes de las 20:00 horas',
		'description'=>'Servicio puerta a puerta con entrega en cualquier población y destino antes de las 20:00 horas del día laborable siguiente a su recogido, sin recargo para cualquier población.'),
	'SÁBADOS' => array(
		'image' => $site_url.'/images/icons/iconos-servicios-16.jpg',
		'title'=>'Entrega especial en sábado',
		'description'=>'Servicio especial de entrega en Sábado efectuando la entrega antes de las 14:00 horas'),
	'ECONOMY' => array(
		'image' => $site_url.'/images/icons/iconos-servicios-5.jpg',
		'title'=>'Servicio Economy',
		'description'=>'Servicio para envíos menos urgentes a un precio muy económico con un tiempo de tránsito de 24 a 72 horas'),
);


function clean($string){ return $string; }

//$bulks = (isset($_REQUEST['bulks'])) ? clean($_REQUEST['bulks']) : 1;
$bulks = 1;
$weight = (isset($_REQUEST['weight'])) ? clean($_REQUEST['weight']) : false;
$width = (isset($_REQUEST['width'])) ? clean($_REQUEST['width']) : false;
$height = (isset($_REQUEST['height'])) ? clean($_REQUEST['height']) : false;
$length = (isset($_REQUEST['length'])) ? clean($_REQUEST['length']) : false;
$origin = (isset($_REQUEST['origin'])) ? clean($_REQUEST['origin']) : false;
$destination = (isset($_REQUEST['destination'])) ? clean($_REQUEST['destination']) : false;

$from_country = 34;
$to_country = 34;


$origin_txt = (!is_numeric(substr($origin,8))) ? substr($origin,8) : $_REQUEST['origin'];
$destination_txt = (!is_numeric(substr($destination,8))) ? substr($destination,8) : $_REQUEST['destination'];

$origin = (is_numeric(substr($origin,0,5))) ? substr($origin,0,5) : false;
$destination = (is_numeric(substr($destination,0,5))) ? substr($destination,0,5) : false;


if(!$origin && isset($_REQUEST['origin'])){
	$request = "http://maps.googleapis.com/maps/api/geocode/json?address=".$_REQUEST['origin']."&region=ES&sensor=false";
		
		$json = openCurl($request);
		$json = json_decode($json,true);
		$coordenates = $json['results'][0]['geometry']['location'];
		$address = $coordenates['lat'].",".$coordenates['lng'];
	
	$request = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address . "&region=ES&sensor=false&language=es";
	
	$json = openCurl($request);
	
	$json = json_decode($json);

	
	$info = $json->results[0]->address_components;
	
	if(is_array($info)):
		foreach($info as $fact):
			
			if(in_array("postal_code", $fact->types)){ $postal = $fact->long_name; }
			
		endforeach;
	endif;

	$origin = ($postal) ? $postal : false;
	$origin_txt = $postal;

}

if(!$destination && isset($_REQUEST['destination'])){
	
	$request = "http://maps.googleapis.com/maps/api/geocode/json?address=".$_REQUEST['destination']."&region=ES&sensor=false";
		
		$json = openCurl($request);
		$json = json_decode($json,true);
		$coordenates = $json['results'][0]['geometry']['location'];
		$address = $coordenates['lat'].",".$coordenates['lng'];
	
	$request = "http://maps.googleapis.com/maps/api/geocode/json?address=".$address . "&region=ES&sensor=false&language=es";
	
	$json = openCurl($request);
	
	$json = json_decode($json);
	
	
	$info = $json->results[0]->address_components;
	
	if(is_array($info)):
		foreach($info as $fact):
			
			if(in_array("postal_code", $fact->types)){ $postal = $fact->long_name; }
			
		endforeach;
	endif;

	$destination = ($postal) ? $postal : false;
	
	$destination_txt = $postal;

}



$weight = str_replace(",",".",$weight);
$height = str_replace(",",".",$height);
$length = str_replace(",",".",$length);
$width = str_replace(",",".",$width);

if(!is_numeric($weight)) $weight=false;
if(!is_numeric($height)) $height=false;
if(!is_numeric($length)) $length=false;
if(!is_numeric($width))  $width=false;
?>


<?php

if(!$weight or !$height or !$length or !$origin or !$destination):


if(isset($_GET['blank'])):  ?>
<div class="alert fare-results-alert">
 Cargando...
</div>
<?php 
else:
?>
	<div class="alert alert-error fare-results-alert">
	  Faltan campos por rellenar 
	</div>
<?php
endif;
else :

$weight_processed = str_replace(",",".",$weight);
$bulks_processed = str_replace(",","",$bulks);
$bulks_processed = round($bulks_processed);
if($bulks == 1){ $append = " bulto"; } else { $append = " bultos"; }
$bulks_processed = $bulks_processed . $append ;

$volume = ($length/100) * ($height/100) * ($width/100);
$volume = round($volume,10);

/* Construct XML for posting to web service */
$args = array(
	'bulks' => $bulks,
	'volume' => $volume,
	'weight' => $weight_processed,
	'from_country' => $from_country,
	'to_country' => $to_country,
	'from_cp' => $origin,
	'to_cp' => $destination);
	


$xml = construct_xml($args);

//IP = 172.20.20.15;
$url = "http://172.20.20.15/WebSrvs/tarificador.asmx?op=Valora3";

$xml = xml_post($xml,$url);


$fares = simplexml_load_string($xml);


    if(!is_object($fares)){ exit("<b>Lo sentimos, este servicio no funciona temporalmente. Vuelva a intentarlo más tarde</b>"); }
    
    $fares->registerXPathNamespace('ns', 'http://www.asmred.com/');
    
    foreach ($fares->xpath('//ns:Valora3Result') as $item)
    {
    	 $array = (array)$item;
    	$results = $array['Servicios']->Resultado;
        
    }

if($origin_txt == $destination_txt){
	$route = "dentro de <b>$origin_txt</b>";
} else {
	$route = "de <b>$origin_txt</b> a <b>$destination_txt</b>";
}


?>


<div id="results">	
	<h3>Resultados</h3>
<p class="fineprint" style="font-size: 13px;">Este presupuesto es orientativo. Si usted es un cliente habitual contacte con su Agencia ASM más cercana para conocer su tarifa.</p>
		<div class="alert alert-info fare-results-alert">
		  Tarifas para enviar <b><?php echo $bulks_processed; ?></b> de <b><?php echo $weight?> kg.</b>  <span style="white-space:nowrap">(<b><?php echo $length?> cm</b> x <b><?php echo $width?> cm</b> x <b><?php echo $height?> cm</b>)</span> <?php echo $route?>
		</div>	
			
<table class="results" cellpadding="0" cellspacing="0" border="0">
<?php 

$i=0; $results=$results->Servicio; foreach($results as $result):  $i++;
/*
$price = $result->Importe;
$price = str_replace(",",".",$price); 


$vat = (get_option("fares_vat")) ? get_option("fares_vat") : 21;
$discount = (get_option("fares_discount")) ? get_option("fares_discount") : 10;

 Substract VAT 
$price = $price / (($vat/100) + 1) ;

Apply discount 
// $price = $price / (($discount/100) + 1);
// Modificado por Mayte y David
$price = $price - ($price * $discount/100);


$price = round($price, 2);
$price_processed = str_replace(".",",",$price); 
*/

//Nombre
$service = $result->Nombre;
$service = str_replace("SABADOS","SÁBADOS",$service);	
$service = str_replace("ASM0830","ASM 8:30", $service);
unset($result->Nombre);


?>	
	<tr  class="<?php echo ($i % 2) ? 'even' : 'odd'; ?>">
		<td width="80" valign="top" style="padding-left:0;"><img src="<?php echo $services[$service]['image']; ?>" width="80" style="margin-right:10px;" /></td>
		<td valign="top">
		<h2><?php echo $service; ?></h2>
		<p class="fare-service-title"><?php echo $services[$service]['title']; ?></p>
		<p class="fare-service-desc"><?php echo $services[$service]['description']; ?></p></td>
		<td width="120" valign="top" style="padding-right:0;" class="price">
		<?php 
		
		foreach($result as $c): 		
		
			if($c->Nombre == 'PORTES'){
			
			$price = $c->ImporteBase;
			$price = str_replace(",",".",$price);
			$discount = (get_option("fares_discount")) ? get_option("fares_discount") : 10;
			$price = $price - ($price * $discount/100);
			$price = round($price, 2);
			$vat = $c->ImporteIva;
			$vat = str_replace(",",".",$vat);
			$vat = $vat - ($vat * $discount/100);
			$price = number_format($price, 2, ',', ' ');
			$vat = number_format($vat, 2, ',', ' ');
			
			
				?><div style="margin-bottom:4px;"><?php echo $price; ?> €</div><?php
			} else {
			
			$name = $c->Nombre;
			if($name == 'TASA FUEL') $name = 'Fuel';
				?><div style="font-weight:normal;font-size: 13px;border-top: 1px #CCC dashed;padding-top: 3px;margin-top: 3px;"> + <?php echo $name . ":<b>" . $c->ImporteFinal . " €</b>"; ?></div><?php
			}
		
		endforeach; 
		
		?>
				<div style="font-weight:normal;font-size: 13px;border-top: 1px #CCC dashed;padding-top: 3px;margin-top: 3px;"> + IVA: <b><?php echo $vat; ?> €</b></div>
		</td>
	</tr>
<?php endforeach; ?> 
</table>

</div>	

<?php 
$slug = "presupuesto";
$page = get_page_by_path($slug);
$link = get_permalink($page->ID);

$args = implode("|",$_REQUEST);
$args =  base64_encode($args);

 ?>
<div class="alert alert-info">
<a href="<?php echo $link . "?b=".$args; ?>" target="_blank" class="btn btn-large" style="float:right;margin-top:7px;"><span class="icon-print"></span> Imprimir</a>
Desde ASM ponemos a su disposición un simulador de tarifas  <br /> con diferentes servicios para que pueda elegir el servicio <br />  más adecuado a su necesidad según los datos facilitados.</a>



</div>

<p class="fineprint" style="font-size: 13px;">(*) Promoción Especial Web ASM del <span class="highlight"><?php echo (get_option('fares_discount')) ? get_option('fares_discount') : 10; ?>% de descuento</span>  sobre la Tarifa PVP (Precios Sin IVA).</p>
	<p class="fineprint">Para su aplicación será imprescindible presentar este presupuesto impreso. Si desea más información contacte con su Agencia ASM más cercana, o bien, llámenos al 902 11 33 00.</p>




<?php endif; ?>
