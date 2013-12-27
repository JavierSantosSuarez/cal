<?php

function construct_xml($args){
	$xml = "
	<Servicios uidcliente=\"E22352CA-512F-4E95-96F3-0CFB417C5E73\" xmlns=\"http://www.asmred.com/\">
	  <Envio>
	    <Servicio></Servicio>
	    <Horario></Horario>
	    <Bultos>".$args['bulks']."</Bultos>
	    <Volumen>".$args['volume']."</Volumen>
	    <Peso>".$args['weight']."</Peso>
	    <Remite>
	      <Pais>".$args['from_country']."</Pais>
	      <CP>".$args['from_cp']."</CP>
	    </Remite>
	    <Destinatario>
	      <Pais>".$args['to_country']."</Pais>
	      <CP>".$args['to_cp']."</CP>
	    </Destinatario>
	  </Envio>
	</Servicios>
	";
	
	return $xml;
	
}


function xml_post($post_xml, $url)
{

$soap = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\" xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">
  <soap:Body>
    <Valora3 xmlns=\"http://www.asmred.com/\">
      <docIn>".$post_xml."</docIn>
    </Valora3>
  </soap:Body>
</soap:Envelope>";


  $soap_do = curl_init(); 
  curl_setopt($soap_do, CURLOPT_URL,            $url );   
  curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 10); 
  curl_setopt($soap_do, CURLOPT_TIMEOUT,        10); 
  curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
  curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);  
  curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false); 
  curl_setopt($soap_do, CURLOPT_POST,           true ); 
  curl_setopt($soap_do, CURLOPT_POSTFIELDS,    $soap); 
  curl_setopt($soap_do, CURLOPT_HTTPHEADER,     array('Content-Type: text/xml; charset=utf-8', 'Content-Length: '.strlen($soap) )); 
  
  $result = curl_exec($soap_do);
  $err = curl_error($soap_do);  
  
  return $result;
    
}

function openCurl($path){
       $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$path);
        curl_setopt($ch, CURLOPT_FAILONERROR,1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $retValue = curl_exec($ch);                      
        curl_close($ch); 
        return $retValue;
}