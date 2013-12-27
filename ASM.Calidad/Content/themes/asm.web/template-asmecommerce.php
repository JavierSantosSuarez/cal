<?php
/*
	Template Name: ASM E-commerce
*/

define("EMAIL","jbatlle@corp.asmred.es");

get_header();


if(isset($_POST) && !empty($_POST)){
	
	$errors = array();
	
	$fields = array(
		'empresa' => $_POST['empresa'],
		'persona' => $_POST['contacto'],
		'tel'     => $_POST['tel'],
		'email'   => $_POST['email'],
		'cp'      => $_POST['cp']
	);
	
	foreach($fields as $field => $value){
		if((empty($value)) || ($field == 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL))){
			$errors[] = $field;
		}
	}
	
	
	$message="
-
-EMPRESA:
-".$fields['empresa']."
-
-PERSONA DE CONTÁCTO:
-".$fields['persona']."
-
-TELÉFONO:
-".$fields['tel']."
-
-CP:
-".$fields['cp']."
-
-EMAIL:
-".$fields['email']."
-
		";
		
	$to = EMAIL;
	$subject = "[CAMPAÑA ASM E-COMMERCE] " . $fields['empresa'];
	$from = $fields['email'];
		
	 $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\nFrom: $from\r\n";
    
    if(empty($errors)){
    	mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
    }
	
}

?>
<style>
body {
	background: #FFF !important;
}
.wrapper {
	border-top: 4px solid #558801;
}
.logo h1 {
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/asmecommerce/asmecommerce.png);
	margin-top: -12px;
	height: 134px;
	margin-bottom: 10px;
}
.topbar li a {
	color: #FFF;
	background: #558801;
}
.topbar li a:hover {
	background: #003B61;
}
.topbar li a.lang-es, .topbar li a.lang-en { display: none; }

.footer-wrapper { padding-top: 40px; margin-top:20px; border-top: 1px #CCC solid; }
.navbar-inner {
	background: white !important;
	box-shadow: none !important;
	border-radius: 0 !important;
	filter: none !important;
	border-top: 1px #999 solid;
	border-bottom: 1px #999 solid;
}
.navbar .nav > li > a {
	color: #999;
	text-shadow: none;
}
.navbar .nav > li > a:hover {
	color: #444;
}
.navbar .divider-vertical {
	background-color: white;
	border-right: 1px solid #DDD;
}
.main-pic {
	height: 575px;
	background: #DDD;
	-webkit-border-radius: 4px 4px 0 0;
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/asmecommerce/hero.png);
}
.asmecommerce-block {
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/asmecommerce/pattern1.jpg);
	height: 215px;
	color: #FFF;
	text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}
.asmecommerce-block.alt {
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/asmecommerce/pattern2.jpg);
}
.asmecommerce-block h3 {
	font-weight: normal;
	font-size: 32px;
	margin-bottom: 4px;
	line-height: 120%;
}
.asmecommerce-block p.slogan {
	opacity: 1;
	margin-top:0;
	font-size: 19px;

}
.asmecommerce-block p, .asmecommerce-block li {
	opacity: 0.7;
	margin-top: 10px;
	font-size: 17px;
	font-family: ASM, Arial, sans-serif;
	line-height: 160%;
	
}
.asmecommerce-block li  {
	line-height: 120%;
}
.asmecommerce .main-content h2 {
	color: #639F22;
}
.asmecommerce .main-content .slogan  {
	color: #639F22;
	font-size: 18px;
}
.asmecommerce .main-content p {
	color: #555;
	font-size: 16px;
	line-height: 150%;
	
}

.block-pic-1, .block-pic-2, .block-pic-3, .block-pic-4 {
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/asmecommerce/sprite.jpg);
	width: 365px;
	height: 245px;
	margin: -15px;
	margin-right: 15px;
	float: left;
	border-radius: 5px 0 0 5px;
}

.block-pic-1, .block-pic-3 {
	float: right;
	margin-left: 15px;
	margin-right: -15px;
	border-radius: 0 5px 5px 0;
}
.block-pic-1 {
	background-position: -154px 0;
}
.block-pic-2 {
	background-position: -634px 0;
}
.block-pic-3 {
	background-position: 987px 0;
}
.block-pic-4 {
	background-position: 427px -54px;
}

#coupon-form label {
	position: absolute;
	top: -9999px;
}
#coupon-form .field {
	margin-bottom: 10px;
}
.sorteo h2 {
	font-size: 38px;
	color: #D72B68;
	line-height: 130%;
	margin-bottom: 20px;
	margin-top: 40px;
}
.sorteo .sub {
	font-size: 22px;
	color: #444;
	line-height: 150%;
	font-family: ASM, arial, sans-serif;
	margin-bottom: 30px;
}
.sorteo input {
	font-size: 16px;
}
.banner {
	display: block;
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/asmecommerce/landing-page-ecommerce_940px.gif);
	height: 100px;
	text-indent: -99999px;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}

</style>

<?php if(isset($_POST) && !empty($_POST) && empty($errors)): ?>
<div class="alert alert-success">
  Gracias por tu participación. El ganador del sorteo se comunicará el 15/01/2013 a través de nuestros perfiles oficiales en Redes Sociales de Twitter <a href="http://twitter.com/asmred">@asmred</a>
			y Facebook <a href="http://facebook.com/ASMRED">facebook.com/ASMRED</a>
</div>
<?php elseif(isset($_POST) && !empty($_POST) && !empty($errors)): ?>
<div class="alert alert-error">
  Ha habido un error al enviar el formulario. Comprueba que has rellenado todos los campos y que los valores introducidos son váidos (p.e. e-mail).
</div>
<?php endif; ?>

<div class="row detach">
	<div class="span12 block">
		<a href="#sorteo" class="banner">Sorteo de un iPad con pantalla Retina, Wi-fi y 4G, de 64GB</a>
	</div>
</div>

<div class="row detach asmecommerce">
	<div class="span12">
		<div class="main-pic"></div>
	</div>
</div>


<div class="row detach">
	<div class="span12">
		<div class="inside block asmecommerce-block">
			<div class="block-pic-1"></div>
			<h3>ENTREGA A DOMICILIO</h3>
			<p class="slogan">Especialistas en soluciones de entrega a domicilio <br />para tiendas online.</p>
			<p>Tu cliente recibirá una notificación de aviso para indicarle el día de entrega, y si no pudiera podrá acordar otro horario o día para la entrega, e incluso concertar la recogida en el punto de proximidad más cercano para él.</p>
		</div>
	</div>
</div>
<div class="row detach">
	<div class="span12">
		<div class="inside block asmecommerce-block alt">
			<div class="block-pic-2"></div>
			<h3>ENTREGA EN PUNTO DE PRÓXIMIDAD</h3>
			<p class="slogan">Más Cerca de Ti…
			<br />Mayor Comodidad para TI…</p>

			<p>Tu cliente podrá elegir entre recibir su pedido en el domicilio o acercarse al comercio de barrio más cercano dentro de nuestra amplia red de puntos de proximidad “PUNTOENVÍO” (papelerías, agencias de viajes, quioscos, etc.) </p>

		</div>
	</div>
</div>
<div class="row detach">
	<div class="span12">
		<div class="inside block asmecommerce-block">
			<div class="block-pic-3"></div>
			
			<h3>INTEGRACIÓN DE SISTEMAS </h3>
			<p class="slogan">Factor clave para el éxito de tu tienda online</p>

			<ul>
				<li>Integración con plataformas e-commerce y aplicaciones Web Service</li>
				<li>Información del pedido gracias a la entrega con terminales de reparto</li>
				<li>Gestión del cobro con tarjeta de crédito, contra reembolso o efectivo </li>
				<li>Optimización en la gestión de los pedidos </li>
			</ul>
		</div>
	</div>
</div>
<div class="row detach">
	<div class="span12">
		<div class="inside block asmecommerce-block alt">
			<div class="block-pic-4"></div>
			<h3>LOGÍSTICA ESPECIALIZADA</h3>
			<p class="slogan">Una buena optimización y servicio de devolución es posible </p>

			<ul style="margin-left: 384px">
				<li>Soluciones especializadas de almacenaje y preparación de los envíos. </li>
				<li>Gestión sin almacenes del envío directamente con tu proveedor </li>
				<li>Soluciones de Logística Inversa para aquellos de tus clientes que deseen devolver el producto </li>
			</ul>
		</div>
	</div>
</div>


<div class="row detach sorteo" id="sorteo">
	<div class="span12">
		
			
			<div class="row">
				<div class="span5">
						<img src="<?php echo get_bloginfo('stylesheet_directory') . "/images/asmecommerce/sorteo.png"; ?>" width="384" height="507" alt="iPad" />
				</div>
				<div class="span7">
					
						<h2>SORTEO de un iPad con pantalla Retina, Wi-Fi y 4G de 64GB</h2>
						<p class="sub">Rellena el cupón para solicitar más información y participar en el sorteo</p>
						
						<form id="coupon-form" class="form-horizontal" method="post">
							
							<div class="field">
								<label for="empresa">Empresa</label>
								<input type="text" id="empresa" name="empresa" value="Empresa" placeholder="Empresa" class="span4 required">
							</div>
						
							<div class="field">
								<label for="contacto">Persona de contacto</label>
								<input type="text" id="contacto" name="contacto" value="Persona de contacto" placeholder="Persona de contacto" class="span4 required">
							</div>
							<div class="field">	
								<label for="tel">Teléfono de contacto</label>
								<input type="text" id="tel" name="tel" value="Teléfono de contacto" placeholder="Teléfono de contacto" class="span4 required">
							</div>
							<div class="field">
								<label  for="email">Correo electrónico</label>
								<input type="text" id="email" name="email" value="Correo electrónico" placeholder="Correo electrónico" class="span4 required">
							</div>
							<div class="field">
								<label  for="email">Código postal</label>
								<input type="text" id="cp" name="cp" value="Código postal" placeholder="Código postal" class="span4 required">
							</div>
							<div class="field">
							 <button type="submit" id="submit" name="submit" class="btn btn-large">Enviar</button>
							</div>
					
						
						</form>
					
				</div>
			
			
			
			</div>
			
			<hr />
			
			<div class="fineprint">
			<p>El ganador del sorteo se comunicará el 15/01/2013 a través de nuestros perfiles oficiales en Redes Sociales de Twitter <a href="http://twitter.com/asmred">@asmred</a>
			y Facebook <a href="http://facebook.com/ASMRED">facebook.com/ASMRED</a></p>
			<p>Para más información póngase en contacto con nosotros a través del correo electrónico <a href="mailto:marketing@asmred.com">marketing@asmred.com</a></p>
			</div>
			
		</div>
</div>


<script>
$("#coupon-form").submit(function(){
	var hasErrors = false;
	$(".required").each(function(){
		
		if(jQuery.trim($(this).val()) == '' || this.value == this.defaultValue){
			hasErrors = true;
		}
				
	});
	
	
		if(hasErrors){
			alert("Por favor, rellena todos los campos antes de enviar el formulario.");
			return false;
		}
	
});

$('input[type="text"]').focus( function(){
            elementValue = $(this).val();
            $(this).val("");
        });
        $('input[type="text"]').blur( function(){
            if($(this).val() != elementValue && $(this).val() != ""){

            }else{
                $(this).val(elementValue);
            }

});

</script>

<?php
get_footer(); 
?>