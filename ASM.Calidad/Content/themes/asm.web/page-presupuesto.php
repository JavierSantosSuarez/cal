<?php 
/* 
	Template Name: Presupuesto 
*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>ASMRed</title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/bootstrap/css/bootstrap.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="all" />
<style>
	body {
		background: #F1F2F3;
		font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
		font-size: 14px;
		margin: 20px;
	}
	.wrapper {
		padding: 20px;
		width: 800px;
		background: #FFF;
		-webkit-box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.7);
		margin: 0 auto;
	}
	.do-not-print {
		text-align: center;
		margin: 20px 0;
	}
	.content {
		color: #444;
		
		padding: 0 32px;
		margin: 20px 0 0 0;
	}
	.content p {
		font-size: 15px;
		line-height: 150%;
	}
	.content .fineprint {
		font-size: 12px;
	}
	.title {
		float: right;
		color: #555;
		padding-right: 32px;
	}
	.highlight {
		color: #D40046;
		background: none !important;
	}
	.price {
		font-size: 22px;
		font-weight: bold;
		padding-top: 10px !important;
	}
	.results td {
		border-bottom: 1px #DDD solid;
		padding: 10px 0;
	}
	.fare-service-desc {
		font-size: 13px !important;
	}
	#results h3 {
		display:none;
	}
	#results .alert {
		display: block;
	}
	.alert {
		display: none;
	}
	@media print {
	  .do-not-print {
	  	display: none;
	  }
	  .wrapper {
	  	border-top: 0px !important;
	  }
	  .alert { padding-left:10px; }
	}
</style>
</head>
<?php 

$args = $_REQUEST['b'];

if(!$args) exit("Missing parameters");

$args = base64_decode($args);

$args = explode("|",$args);


$_REQUEST['origin'] = $args[0];
$_REQUEST['destination'] = $args[1];
$_REQUEST['bulks'] = $args[2];
$_REQUEST['weight'] = $args[3];
$_REQUEST['length'] = $args[4];
$_REQUEST['width'] = $args[5];
$_REQUEST['height'] = $args[6];


 ?>
<body>
<div class="do-not-print">
	<a href="javascript:print()" class="btn btn-primary btn-large"> <span class=" icon-print icon-white"></span> Imprimir</a>
</div>

<div class="wrapper">
	<h1 class="title">Presupuesto <?php echo rand(000000,999999); ?></h1>
	<img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" />
	<div class="content">
	<p>Desde <b>ASM</b> ponemos a su disposición un simulador de tarifas con diferentes servicios 
	para que pueda elegir el servicio más adecuado a su necesidad según los datos 
	facilitados.</p>
	<p>Si lo desea puede ponerse en contacto con su <b>Agencia ASM</b> más cercana para facilitarle 
	la mejor oferta para su envío.</p>
	
	<?php include 'farecalculator/results.php'; ?>
	
	
	
	</div>
	
	
</div>


</body>
</html>