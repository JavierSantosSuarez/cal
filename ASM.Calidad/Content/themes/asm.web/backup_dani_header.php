<?php
    $time = time() + (60 * 60 * 24 * 30 * 2);
    $mode = (isset($_COOKIE['asm_warnings'])) ? "hide" : "show";
    if(!$_COOKIE['asm_warnings']) setcookie("asm_warnings","1",$time,"/");
    
?><!DOCTYPE html>
<html dir="ltr" lang="<?php bloginfo('language'); ?>"  xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<title>
    <?php
        global $page, $paged;
        wp_title( '|', true, 'right' );
        bloginfo( 'name' );
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) echo " | $site_description";
        if ( $paged >= 2 || $page >= 2 ) echo ' | ' . sprintf( __( 'Página %s', 'twentyten' ), max( $paged, $page ) );
    ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">

	<link rel="schema.DC" href="http://purl.org/dc/elements/1.1/" />
	<meta name="description" content="Agencia de Paqueter&iacute;a Urgente ASMRED. Te ofrecemos Transporte urgente de mercanc&iacute;a con servicios adaptados según el horario que necesites de entrega"/>
	<meta name="keywords" content="paqueteria urgente, agencia de paqueteria, transporte urgente, servicios de paqueter&iacute;a, transporte urgente de mercanc&iacute;a, paqueter&iacute;a urgente, agencia de paqueter&iacute;a"/>
	<meta name="DC.title" content="Agencia de Paqueter&iacute;a Urgente. ASMRED"/>
	<meta name="DC.description" CONTENT="Agencia de Paqueter&iacute;a Urgente ASMRED. Te ofrecemos Transporte urgente de mercanc&iacute;a con servicios adaptados según el horario que necesites de entrega"/>
	<meta name="DC.keywords" CONTENT="paqueteria urgente, agencia de paqueteria, transporte urgente, servicios de paqueter&iacute;a, transporte urgente de mercanc&iacute;a, paqueter&iacute;a urgente, agencia de paqueter&iacute;a"/>
	<meta http-equiv="Pragma" content="no-cache"/>
	<meta name="robots" content="all" />
	<meta name="revisit-after" content="10 Days" />
	<meta name="Language" content="Spanish" />
	<meta name="distribution" content="GLOBAL" />
	<meta name="category" content="Transportes" />
	<meta name="identifier-url" content="http://www.asmred.com" />
	<meta name="rating" content="General" />
	
	<meta name="google-site-verification" content="1XM0sRHIlzpHYo2OKSevmZBf7gLOWrd4oTiyf9kNsPU" />

	<!-- Le CSS -->
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/bootstrap/css/bootstrap.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" type="text/css" media="all" />
	
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/fonts/font-awesome.css">
	
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/js/jqueryui/css/smoothness/jquery-ui-1.8.20.custom.css">
	
	<!--[if IE 6]>
	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_directory' ); ?>/iefix.css">
	<![endif]-->
	<!--[if IE]>
	<style>.social-buttons { display:none !important; }.acceso-clientes { white-space:nowrap; width:88px; overflow:hidden; }</style>
	<![endif]-->
	<!--[if IE 7]>
	<style>.icon-home { background:url(<?php bloginfo( 'stylesheet_directory' ); ?>/images/home.png) 3px -5px; }</style>
	<![endif]-->
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	
	<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/js/jquery.cycle.all.js"></script>
	
	<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/js/jquery.scrollTo-1.4.2-min.js"></script>
	
	<script src="<?php echo get_bloginfo('stylesheet_directory'); ?>/js/jqueryui/js/jquery-ui-1.8.20.custom.min.js"></script>
	

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
   <!--[if lt IE 9]>
     <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	
   <!-- Le fav and touch icons 
   <link rel="shortcut icon" href="">
   <link rel="apple-touch-icon-precomposed" sizes="114x114" href="">
   <link rel="apple-touch-icon-precomposed" sizes="72x72" href="">
   <link rel="apple-touch-icon-precomposed" href="">-->

	<?php wp_head(); ?>
	
	

	
</head>

<body  <?php body_class("random-background-".rand(1,5)); ?>>

<!-- Le Facebook integration -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_ES/all.js#xfbml=1&appId=288576294554370";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="wrapper">
<div class="container">




<div class="topbar">
	<ul>
		<!--<li class="privatezone">
		<a data-toggle="modal" href="#privatezone"> <span class="icon-user"></span> ZONA PRIVADA</a>
		</li>-->
		<li class="onlinechat"><a href="http://195.55.73.115:8585/ChatEnduserWelcomePage.jsp?queue=1&accountID=free" target="_blank"> <span class=" icon-headphones icon-large"></span> CHAT ONLINE</a></li>
		<li class="twitter" style="margin-top:12px;">	
		<a href="http://twitter.com/asmred_clientes" target="_blank">  @asmred_clientes</a>
		</li>
		<li class="directline"><a href="#"><span  class="icon-info-sign icon-large"></span> 902 11 33 00</a></li>
		<li><a href="http://www.asmred.com" class="lang-es on">Español</a><a href="http://www.asmred.com/en" class="lang-en off">English</a></li>
	</ul>
	<div class="clear"></div>
</div>

<?php $args = array(
  'container'       => false, 

  'menu_class'      => 'nav', 
  'echo'            => true,
  'depth'           => 1 ); ?>

<div class="social-buttons hidden-phone">

	<div class="fb-like" data-href="https://www.facebook.com/ASMRED" style="position:relative;top:-2px ;" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false"></div>
	
	<a href="https://twitter.com/asmred" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @asmred</a>
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
	
	<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
	<script type="IN/FollowCompany" data-id="763936" data-counter="right"></script>
	
	<!-- Place this tag where you want the +1 button to render -->
	<g:plusone size="medium"></g:plusone>
	
	<!-- Place this render call where appropriate -->
	<script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	
	

</div>

<div class="logo">
	<a href="<?php bloginfo('url'); ?>"><h1>ASM. Transporte urgente</h1></a>
</div>
<div class="clear"></div>

 <!-- le javascript for le private zone -->
 <script>
 	$('#privatezone').modal();
 	$('.dropdown-toggle').dropdown()
 </script>
 
 <div class="navbar">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          
          <div class="nav-collapse">
            <ul id="home-menu" class="nav">
            	<li <?php if(is_home()) echo 'class="active"';?>><a href="/"><span class="icon-home"></span></a></li>
            </ul>
            
            <?php wp_nav_menu( $args );  ?> 
            
            <ul class="nav pull-right nav-pills">
            	<li class="divider-vertical"></li>
            	
            	<li>
	                <a class="acceso-clientes" target="_blank" href="http://www.asmred.com/extranet/login.aspx?ReturnUrl=~/Default.aspx">
             			 Zona Privada
             		</a>
	                
                </li>
            	
            	
                
              </ul>
            
          </div> <!--/.nav-collapse -->
          
       
        </div>
      </div>
    </div>

      <div class="alert alert-error" style="border:0;background:#D30042;">
            <a class="close" data-dismiss="alert">×</a>
            <a data-toggle="modal" style="color:#FFF;text-shadow:none;" href="#phishing" ><strong>AVISO IMPORTANTE:</strong> Detectado uso fraudulento de la marca ASM en e-mails.</a>
       </div>
       
<?php if($mode == 'show') echo'<div class="modal-backdrop fade in"></div>'; ?>      
       
<div class="modal <?php echo $mode; ?>" id="phishing">
  <div class="modal-header">
    <a type="button" class="close close-dialog" data-dismiss="modal">×</a>
    <h3 style="color:#D30042;">AVISO: Detectado uso fraudulento de la marca ASM en e-mails.</h3>
  </div>
  <div class="modal-body">
    
    <div style="text-align:right;"><p>28 de junio de 2012<br /><b>ASM Departamento de Calidad</b></div>
    
    <p>Estimados clientes y colaboradores de la RED ASM:</p>
 
    <p>Hemos detectado mensajes de correo electrónico recibidos desde la dirección <u>mlm@mayerbrown.es</u>, identificándose como ASMRed España y prestadores del servicio ASMRed Desembolso Anticipado, en los que ofrecen teléfonos móviles que para recibirlos, deben previamente facilitarles sus datos bancarios y abonar una cantidad para proceder a su entrega. </p>
 
    <p>ASM, nunca solicita los datos bancarios de sus clientes o destinatarios, no se dedica a la comercialización de telefonía móvil, informática, etc..., <b>Esta dirección está haciendo uso fraudulento de la marca ASM</b> para conseguir datos bancarios en nombre de ASM. Trasladen esta información a sus clientes caso de que hayan recibido también correos similares en nombre de ASM.</p>
 
    <p><b>Desde ASM estamos tomando todas las acciones y medidas legales necesarias para parar cuanto antes este ciber-fraude</b>. Les rogamos a su vez nos informen de la recepción de los mismos para dar traslado a la autoridad competente, remitiéndolo al correo <a href="mailto:seguridad@asmred.com">seguridad@asmred.com</a>.</p>
 
 
    <p>Para más información: 902 11 33 00</p>  
 
        
        
  </div>
  <div class="modal-footer">
    <a href="#" class="btn close-dialog" data-dismiss="modal" style="display:block;width: 40%;margin:0 auto;">Cerrar aviso</a>
    
  </div>
</div>

<script>
    $("#phishing .close-dialog").click(function(){
        $("#phishing").hide();
        $(".modal-backdrop").hide();
    });
    
    
</script>
  