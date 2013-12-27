<?php 
/*
	Template Name: Contacto
*/
if(!defined("_EMBEDDED"))
	get_header(); 

$recipients = array(
	1 => 'ContactoWEB_CE@asmred.com',
	2 => 'ContactoWEB_SerAgencia@asmred.com',
	3 => 'ContactoWEB_TrabajoASM@asmred.com',
	4 => 'ContactoWEB_Marketing@asmred.com',
	5 => 'ContactoWEB_Reclama@asmred.com',
	6 => 'ContactoWEB_Sugerencias@asmred.com',
	7 => 'ContactoWEB_Comercial@asmred.com');


/* For testing

$recipients = array(
	1 => 'gchulia@clickcomunicacio.com',
	2 => 'gchulia@clickcomunicacio.com',
	3 => 'gchulia@clickcomunicacio.com',
	4 => 'gchulia@clickcomunicacio.com',
	5 => 'gchulia@clickcomunicacio.com',
	6 => 'gchulia@clickcomunicacio.com',
	7 => 'gchulia@clickcomunicacio.com'); 
 */

function clean($string){
	return "-".$string;
}
$empresa=null;$persona_de_contacto=null;$direccion=null;$telefono=null;$poblacion=null;
$n_expedicion=null;
$errors = array();

$peticiones = array(
	1 => '-Consulta sobre un envío',
	2 => '-Quiero ser una Agencia ASM',
	3 => '-Quiero trabajar en ASM',
	4 => '-Contactar Dpto. Marketing y Comunicación',
	5 => '-Reclamación',
	6 => '-Sugerencia',
	7 => '-Contactar Dtpo. Comercial');

if(isset($_POST) && $_POST){



	if(!empty($_POST['empresa'])){ $empresa = "-".$_POST['empresa']; } else { $errors['empresa']=true; }

	if(!empty($_POST['persona_de_contacto'])){ $persona_de_contacto = "-".$_POST['persona_de_contacto']; } else { $errors['persona_de_contacto']=true;}

	if(!empty($_POST['direccion'])){ $direccion = "-".$_POST['direccion']; } else { $errors['direccion']=true;}

	if(!empty($_POST['poblacion'])){ $poblacion = "-".$_POST['poblacion']; } else { $errors['poblacion']=true;}

	if(!empty($_POST['cp'])){ $cp = "-".$_POST['cp']; } else { $errors['cp']=true; }

	if(!empty($_POST['telefono'])){ $telefono = "-".$_POST['telefono']; } else { $errors['telefono']=true;}

	if(!empty($_POST['email'])){ $email = $_POST['email']; } else { $errors['email']=true;}

	if(!empty($_POST['peticion']) && $_POST['peticion']!='false'){ $peticion = $_POST['peticion']; } else { $errors['peticion']=true;}


	$n_expedicion = (isset($_POST['n_expedicion'])) ? "-".$_POST['n_expedicion'] : null;
	$cp_origen = (isset($_POST['cp_origen'])) ? "-".$_POST['cp_origen'] : null;
	$cp_destino = (isset($_POST['cp_destino'])) ? "-".$_POST['cp_destino'] : null;

	if($peticion=='1'){
		if(empty($_POST['n_expedicion'])) $errors['n_expedicion']=true;
		if(empty($_POST['cp_origen'])) $errors['cp_origen']=true;
		if(empty($_POST['cp_destino'])) $errors['cp_destino']=true;
	}
	$peticion_text = $peticiones[$peticion];

	$mensaje = (isset($_POST['mensaje'])) ? $_POST['mensaje'] : null;

	if(empty($errors)):
		$success=true;
		$email_p = "-".$email;
		

		$message="

EMPRESA:
 ".$empresa."

PERSONA DE CONTACTO:
 ".$persona_de_contacto."

DIRECCIÓN:
 ".$direccion."

POBLACIÓN:
 ".$poblacion."

CÓDIGO POSTAL:
 ".$cp."

TELÉFONO:
 ".$telefono."

E-MAIL:
 ".$email_p."

PETICIÓN:
 ".$peticion_text."

";

	if($peticion=='1' or $peticion == '5'){
	$message.="Nº EXPEDICIÓN:
 ".$n_expedicion."

CP ORIGEN:
 ".$cp_origen."

CP DESTINO:
 ".$cp_destino."
"; 
	}
	$message.="- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - 

 ".$mensaje."

";

	$to = $recipients[$peticion];
	$subject = "[ASM CONTACTO] " . $peticion_text;
	$from = $email;

	$header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\nFrom: $from\r\n";




$ar_message='
<h1><img src="http://www.asmred.com/wp/wp-content/themes/asm.web/images/logo.png" width="150" title="ASM. Transporte Urgente" alt="ASM. Transporte Urgente" /></h1>
<p style="font-family:Arial, sans-serif;font-size:13px;">Estimado señor o señora:</p>

<p style="font-family:Arial, sans-serif;font-size:13px;">Este es un correo generado automáticamente por el sistema, por favor, no responda a esta comunicación.</p>

<p style="font-family:Arial, sans-serif;font-size:13px;">Su consulta se ha registrado en nuestro sistema y será atendida en un <u>plazo máximo de 24 horas</u>.</p>

<p style="font-family:Arial, sans-serif;font-size:13px;">Muchas gracias por confirmar en nosotros.</p>

<p style="font-family:Arial, sans-serif;font-size:13px;">Atentamente,<br />
ASM Transporte Urgente</p>

';
	$ar_to = $email;
	$ar_subject = "[ASM CONTACTO] " . $peticion_text;
	$ar_from = "noreply@asmred.com";

	$ar_header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\nFrom: $from\r\n";


	try {
		@mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
		@mail($_POST['email'], '=?UTF-8?B?'.base64_encode($ar_subject).'?=', $ar_message, $ar_header);
		
	} catch (Exception $e) {
		echo "Error al enviar el e-mail. Vuelva a intentarlo más tarde\n";
	}



	endif;


}



while(have_posts()): the_post();


?>

<div class="content detach post-page">

<div class="row">
	<div class="span8 main-content">
		<div class="inside block contact-block">
			<h2 class="single-title" style="margin-bottom:10px">
			<?php the_title(); ?></h2>
			<div class="post-content">


			<div class="contact-text">
				<?php the_content(); ?>
			</div>

			<hr />
			<?php if(!empty($errors)): ?>
			<div class="alert alert-error">
			  <a class="close" data-dismiss="alert">×</a>
			  <strong>Error:</strong> Faltan algunos campos por rellenar. Revisa el formulario y vuelve a intentarlo.
			</div>
			<?php elseif($success): ?>
			<div class="alert alert-success">
			  <a class="close" data-dismiss="alert">×</a>
			  <strong>Enviado:</strong> Gracias por contactar con ASM. Responderemos a tu petición lo más pronto posible.
			</div>
			<?php endif; ?>


			<?php if(!$success): ?>

			<form class="form-horizontal" method="post">
				<div class="control-group <?php if($errors['empresa']) echo 'error'; ?>">
					<label class="control-label" for="empresa">Empresa</label>
					<div class="controls">
						<input type="text" id="empresa" name="empresa" value="<?php echo $empresa?>" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['persona_de_contacto']) echo 'error'; ?>">
					<label class="control-label" for="persona_de_contacto">Persona de contacto</label>
					<div class="controls">
						<input type="text" id="persona_de_contacto" value="<?php echo $persona_de_contacto?>" name="persona_de_contacto" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['direccion']) echo 'error'; ?>">
					<label class="control-label" for="direccion">Dirección</label>
					<div class="controls">
						<input type="text" id="direccion" name="direccion" value="<?php echo $direccion?>" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['poblacion']) echo 'error'; ?>">
					<label class="control-label" for="poblacion">Población</label>
					<div class="controls">
						<input type="text" id="poblacion" name="poblacion" value="<?php echo $poblacion?>" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['poblacion']) echo 'error'; ?>">
					<label class="control-label" for="cp">Código Postal</label>
					<div class="controls">
						<input type="text" id="cp" name="cp" class="input-small" value="<?php echo $cp?>" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['telefono']) echo 'error'; ?>">
					<label class="control-label" for="telefono">Teléfono</label>
					<div class="controls">
						<input type="text" id="telefono" name="telefono" value="<?php echo $telefono?>" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['email']) echo 'error'; ?>">
					<label class="control-label" for="email">E-mail</label>
					<div class="controls">
						<input type="email" id="email" name="email" value="<?php echo $email?>" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['peticion']) echo 'error'; ?>">
					<label class="control-label" for="peticion">Petición</label>
					<div class="controls">
						<select id="peticion" name="peticion" class="span4">
							<option value="false">Selecciona...</option>
							<optgroup>
								<option value="1" <?php if($peticion==1) echo "selected='selected'"; ?>>Consulta sobre un envío</option>
								<option value="2" <?php if($peticion==2) echo "selected='selected'"; ?>>Quiero ser una Agencia ASM</option>
								<option value="3" <?php if($peticion==3) echo "selected='selected'"; ?>>Quiero trabajar en ASM</option>
								<option value="4" <?php if($peticion==4) echo "selected='selected'"; ?>>Contactar Dpto. Marketing y Comunicación</option>
								<option value="7" <?php if($peticion==7) echo "selected='selected'"; ?>>Contactar con el Dpto. Comercial</option>
								<option value="5" <?php if($peticion==5) echo "selected='selected'"; ?>>Reclamación</option>
								<option value="6" <?php if($peticion==6) echo "selected='selected'"; ?>>Sugerencia</option>

							</optgroup>
						</select>
					</div>
				</div>

			<div class="display-only-if-about-shipment" <?php if($peticion!='1'): ?>style="display:none"<?php endif; ?>>
				<div class="control-group <? if($errors['n_expedicion']) echo 'error'; ?>">
					<label class="control-label" for="n_expedicion">Nº expedición</label>
					<div class="controls">
						<input type="text" value="<?php echo $n_expedicion?>" id="n_expedicion" name="n_expedicion" class="span4" />
					</div>
				</div>

				<div class="control-group <?php if($errors['cp_origen']) echo 'error'; ?>">
					<label class="control-label" for="cp_origen">Código Postal origen</label>
					<div class="controls">
						<input type="text" value="<?php echo $cp_origen?>" id="cp_origen" name="cp_origen" class="input-small" />
					</div>
				</div>

				<div class="control-group <?php if($errors['cp_destino']) echo 'error'; ?>">
					<label class="control-label" for="cp_destino">Código Postal destino</label>
					<div class="controls">
						<input type="text" value="<?php echo $cp_destino?>" id="cp_destino" name="cp_destino" class="input-small" />
					</div>
				</div>


			</div>

			<div class="control-group">
				<label class="control-label" for="mensaje"></label>
				<div class="controls">
					<textarea class="span4" id="mensaje" name="mensaje" style="height:200px;"></textarea>
				</div>
			</div>

				<div class="form-actions">
							<button type="submit" id="submit" name="submit" class="btn btn-primary">Enviar</button>

						  </div>

			</form>
			<?php endif;?>

			<script>
				$("#peticion").change(function(){
					var value = $(this).val();


					if( value == '1' || value == '5'){
						$(".display-only-if-about-shipment").slideDown(500);
					} else {
						$(".display-only-if-about-shipment").slideUp(200);
					}


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


<?php endwhile;
if(!defined("_EMBEDDED"))
	 get_footer(); ?>