<?php 
$address = "ContactoWEB_SerAgencia@asmred.com, gchulia@clickcomunicacio.com";

define("_TO_ADDRESS",$address);
function clean($string){
	return "-".$string;
}
$empresa=null;$persona_de_contacto=null;$direccion=null;$telefono=null;$poblacion=null;
$n_expedicion=null;
$errors = array();



if(isset($_POST) && $_POST){
	
	
	
	if(!empty($_POST['nombre'])){ $nombre = clean($_POST['nombre']); } else { $errors['nombre']=true; }
							
	if(!empty($_POST['direccion'])){ $direccion = clean($_POST['direccion']); } else { $errors['direccion']=true;}
						
	if(!empty($_POST['poblacion'])){ $poblacion = clean($_POST['poblacion']); } else { $errors['poblacion']=true;}
					
	if(!empty($_POST['telefono'])){ $telefono = clean($_POST['telefono']); } else { $errors['telefono']=true;}
	
	if(!empty($_POST['email'])){ $email = $_POST['email']; } else { $errors['email']=true;}
	
	if(!empty($_POST['how_did_you_hear_about_us'])){ $how_did_you_hear_about_us = clean($_POST['how_did_you_hear_about_us']); } else { $errors['how_did_you_hear_about_us']=true;}

	if(!empty($_POST['experience'])){ $experience = clean($_POST['experience']); } else { $errors['experience']=true;}
	
	if(!empty($_POST['methods'])){ $methods = clean($_POST['methods']); } else { $errors['methods']=true;}


	


	if(empty($errors)):
		$success=true;
		
		
		$message="
-
-NOMBRE:
-".$nombre."
-
-DIRECCIÓN:
-".$direccion."
-
-POBLACIÓN:
-".$poblacion."
-
-TELÉFONO:
-".$telefono."
-
-E-MAIL:
-".$email."
-
-¿CÓMO NOS CONOCIÓ?:
-".$how_did_you_hear_about_us."
-
-EXPERIENCIA:
-".$experience."
-
-MEDIOS QUE DISPONE:
-".$methods."
-		
		";
		
	$to = _TO_ADDRESS;
	$subject = "[QUIERO SER AGENCIA ASM] " . $nombre;
	$from = $email;
		
	 $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\nFrom: $from\r\n";
    
    mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
		
		
	endif;
	

}



?>
			<h4>Contacte con nosotros</h4>
			
			<p>Si desea unirse a nuestra Red Agencial, rellene el siguiente formulario y nos pondremos en contacto con usted para proporcionarle información más detallada. </p>
			
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
				<div class="control-group <? if($errors['empresa']) echo 'error'; ?>">
					<label class="control-label" for="nombre">Nombre</label>
					<div class="controls">
						<input type="text" id="nombre" name="nombre" value="<?=$nombre?>" class="span4" />
					</div>
				</div>
				
				
				
				<div class="control-group <? if($errors['direccion']) echo 'error'; ?>">
					<label class="control-label" for="direccion">Dirección</label>
					<div class="controls">
						<input type="text" id="direccion" name="direccion" value="<?=$direccion?>" class="span4" />
					</div>
				</div>
				
				<div class="control-group <? if($errors['poblacion']) echo 'error'; ?>">
					<label class="control-label" for="poblacion">Población</label>
					<div class="controls">
						<input type="text" id="poblacion" name="poblacion" value="<?=$poblacion?>" class="span4" />
					</div>
				</div>
				
				<div class="control-group <? if($errors['telefono']) echo 'error'; ?>">
					<label class="control-label" for="telefono">Teléfono</label>
					<div class="controls">
						<input type="text" id="telefono" name="telefono" value="<?=$telefono?>" class="span4" />
					</div>
				</div>
				
				<div class="control-group <? if($errors['email']) echo 'error'; ?>">
					<label class="control-label" for="email">E-mail</label>
					<div class="controls">
						<input type="email" id="email" name="email" value="<?=$email?>" class="span4" />
					</div>
				</div>
				
				<div class="control-group <? if($errors['how_did_you_hear_about_us']) echo 'error'; ?>">
					<label class="control-label" for="how_did_you_hear_about_us">¿Cómos nos conoció?</label>
					<div class="controls">
						<input type="text" id="how_did_you_hear_about_us" name="how_did_you_hear_about_us" value="<?=$how_did_you_hear_about_us?>" class="span4" />
					</div>
				</div>
				
				<div class="control-group <? if($errors['experience']) echo 'error'; ?>">
					<label class="control-label" for="experience">Experiencia en el sector</label>
					<div class="controls">
						<input type="text" id="experience" name="experience" value="<?=$experience?>" class="span4" />
					</div>
				</div>
				
				<div class="control-group <? if($errors['methods']) echo 'error'; ?>">
					<label class="control-label" for="methods">Medios que dispone</label>
					<div class="controls">
						<input type="text" id="methods" name="methods" value="<?=$methods?>" class="span4" />
					</div>
				</div>
									
											
				<div class="form-actions">
				            <button type="submit" id="submit" name="submit" class="btn btn-primary">Enviar</button>
				            
				          </div>
			
			</form>
			<?php endif;?>
			
			
