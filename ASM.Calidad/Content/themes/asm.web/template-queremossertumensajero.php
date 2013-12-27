<?php
/*
	Template Name: Queremos ser tu mensajero
*/
get_header();
?>
<style>
body {
	background: #FFF !important;
}

.topbar li a {
	color: #FFF;
	background: #D3002D;
}
.topbar li a:hover {
	background: #D3002D;
}
.topbar li a.lang-es, .topbar li a.lang-en { display: none; }

.footer-wrapper { padding-top: 20px; border-top: 1px #CCC solid; }
.navbar { display: none; }

.menu {
	border-top: 1px #CCC solid;
	border-bottom: 1px #CCC solid;
	margin: 0;
}
.menu li {
	display: inline-block;
}
.menu a {
	display: block;
	padding: 11px;
	color: #999;
	font-family: ASM, arial, sans-serif;
	font-size: 18px;
}
.menu a:hover {
	text-decoration: none;
	color: #444;
}
.menu span {
	display: block;
	float: left;
	background-image: url(<?php bloginfo('stylesheet_directory'); ?>/images/queremossertumensajero/sprite.jpg);
	width: 31px;
	height: 33px;
	margin-right: 5px;
	margin-top: -7px;
}
.menu .menu-icon-2 span {
	background-position: -32px 0px;
}
.menu .menu-icon-3 span {
	background-position: -65px 0px;
}
.menu .menu-icon-4 span {
	background-position: -97px 0px;
}
.menu .menu-icon-5 span {
	background-position: -129px 0px;
}
.menu .menu-icon-1:hover span {
	background-position: 0px 33px;
}
.menu .menu-icon-2:hover span {
	background-position: -32px 33px;
}
.menu .menu-icon-3:hover span {
	background-position: -65px 33px;
}
.menu .menu-icon-4:hover span {
	background-position: -97px 33px;
}
.menu .menu-icon-5:hover span {
	background-position: -129px 33px;
}
.main-pic {
	height: 435px;
	background: #DDD;
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/queremossertumensajero/hero.jpg);
	border-bottom: 1px #CCC solid;
}
.mensajero-button {
	
}
.mensajero-button h2 {
	font-size: 26px;
}
.mensajero-button p {
	font-size: 16px;
	color: #888;
}
.mensajero-button a {
	display: block;
	padding: 20px 0;
	color: #555;
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/queremossertumensajero/arrow.png) right center no-repeat;
}
.mensajero-button a:hover {
	text-decoration: none;
	color: #D3002D;
}
.one-liner a {
	padding-top: 30px;
}
.mensajero-button span {
	display: block;
	background: url(<?php bloginfo('stylesheet_directory'); ?>/images/queremossertumensajero/buttons.png);
	background-repeat: no-repeat;
	height: 104px;
	width: 103px;
	float: left;
	margin-right: 20px;
	margin-top: -20px;
}
.button-1 span {
	background-position: -206px 0px;
}
.button-2 span {
	background-position: -311px 0px;
}
.button-3 span {
	background-position: -207px -141px;
}
.button-4 span {
	background-position: -311px -141px;
}
.button-1:hover span {
	background-position: 1px 1px;
}
.button-2:hover span {
	background-position: -102px 1px;
}
.button-3:hover span {
	background-position: 0px -140px;
}
.button-4:hover span {
	background-position: -102px -140px;
}
hr {
	border:0;
	border-bottom: 1px #CCC solid;
}
#tracking { display: none; position: fixed; z-index: 20; top: 50%; left: 50%; margin-top: -100px; margin-left: -200px; }
.blackout { background: black; opacity: 0.5; position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: -1;  filter: alpha(opacity = 50);}
</style>

<ul class="menu">
	<li><a href="<?php echo get_permalink(get_option('asm_loc_farecalculator')); ?>" class="menu-icon-2"><span></span>Tarifas</a></li>
	<li><a href="#" class="tracking-modal" class="menu-icon-3"><span></span>Seguimiento</a></li>
	<li><a href="<?php echo get_permalink(get_option('asm_loc_storelocator')); ?>" class="menu-icon-4"><span></span>Agencia más cercana</a></li>
	<li><a href="http://twitter.com/asmred_clientes" class="menu-icon-5"><span></span>Atención al cliente</a></li>
</ul>

<div class="row detach asmecommerce">
	<div class="span12">
		<div class="main-pic"></div>
	</div>
</div>


<div class="row detach with-line">
	<div class="span6">
		<div class="mensajero-button button-1">
			<a href="<?php echo get_permalink(get_option('asm_loc_farecalculator')); ?>"><span></span><h2>TARIFAS</h2><p>Consulta el precio de tu envío</p></a>
		</div>
	</div>
	<div class="span6">
		<div class="mensajero-button button-2">
			<a href="#" class="tracking-modal"><span></span><h2>SEGUIMIENTO</h2><p>Consulta el estado de tu envío</p></a>
		</div>
	</div>
</div>
<hr />
<div class="row detach with-line">
	<div class="span6">
		<div class="mensajero-button button-3">
			<a href="http://twitter.com/asmred_clientes"><span></span><h2>ATENCIÓN AL CLIENTE</h2><p>@asmred_clientes</p></a>
		</div>
	</div>
	<div class="span6">
		<div class="mensajero-button button-4">
			<a href="<?php echo get_permalink(get_option('asm_loc_storelocator')); ?>"><span></span><h2>AGENCIA MÁS CERCANA</h2><p>Encuentra tu agencia ASM más cercana</p></a>
		</div>
	</div>
</div>



<div id="tracking">
<div class="span4 block parcel-tracking middle-box">
				<div class="inside highlight rounded">
					<h2 style="margin-bottom: 29px;">Seguimiento<br> de envíos</h2>
					
					<form action="http://www.asmred.com/extranet/public/ExpedicionASM.aspx" class="push form-inline" style="margin-bottom:0;" method="get" target="_blank">
					
						<hr style="margin: 7px 0" class="hr-on-dark">
						
						<h6>Código de envío / Albarán</h6>
						
						<input type="text" name="codigo">
						
						<h6 style="margin-top:6px;">Código postal de envío</h6>
						
						<input type="text" name="cpDst">
						
						<hr style="margin: 7px 0" class="hr-on-dark">
						
						<div> 
							<input type="submit" class="btn btn-primary" value="Encontrar">	
						</div>
						
					</form>
					
					
				</div>
			</div>
</div>
<script>
	$(".tracking-modal").click(function(){
		
		
		$("#tracking").append('<div class="blackout"></div>').fadeIn('slow');
		$(".blackout").click(function(){
			$("#tracking").fadeOut('slow');
		});
		return false;
	});
	
</script>
<?php
get_footer(); 
?>