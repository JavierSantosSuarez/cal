<?php
define("TEMPLATE_URL", get_bloginfo('stylesheet_directory'));

function issue_name(){
$months = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
				$post_month = date("m",time())-1;
				$post_year = date("Y",time());
				
$issue_name = $months[$post_month] . " " . $post_year;
return $issue_name;
}



function insert_story($i){

    
    $newsletter = get_category_by_slug('newsletter');
    $newsletter = $newsletter->term_id;
  	
    $articles = get_posts('numberposts=-1&category='.$newsletter);
  

?>    

   <li class='insert-news-story' <?php if($i!=1): echo 'style="display:none;"'; endif; ?>>
    <select name="insert-story[<?php echo $i; ?>]">
        <option value="false">Selecciona artículo</option>
        
    <?php $curarticles = ""; $pastarticles = ""; 
    foreach($articles as $article): ?>
    
    <?php
    setup_postdata($article);
    
    $date = $article->post_date;
    $date = strtotime($date);
    $date = date("ym",$date);
    $curdate = date("ym",time());
    
    $date = ($date==$curdate) ? true : false;
    
    $html = "<option value='".$article->ID."'>".$article->post_title."</option>";
    
    if($date){
        $curarticles .= $html;
    } else {
        $pastarticles .= $html;
    }
   
   
    endforeach; ?> 
      <optgroup label="Publicados en <?php echo issue_name(); ?>">
        <?php echo $curarticles; ?>
      </optgroup> 
    
      <optgroup label="Publicados anteriormente...">
        <?php echo $pastarticles; ?>
      </optgroup>
      
        
    </select>
    
    <?php if($i!=15): ?><a href='#' class="show-select">Añadir otra...</a><?php endif; ?>
    <a href="#" class="hide-select" style='display:none;'>Eliminar</a>
    
   </li>

<?php
}

function get_newsletter_category($id){
    $category = get_the_category( $id );
    
    foreach($category as $cat){
    
        if($cat->slug != 'newsletter'){
            $post_cat = $cat;
        }
    
    }
    
    $return = array(
        'name' => $post_cat->name,
        'slug' => $post_cat->slug
    );
    
    return $return;
    
}

function get_article($id){
    
    $post = get_post($id);
    setup_postdata($post);
   
  
   $cat = get_newsletter_category($id);
   
   

    if($cat['slug'] != 'la-voz-asm'){

    $a = "<tr><td colspan='2' style='padding-top:8px;padding-bottom:8px;border-bottom: 2px #d40046 solid;'>";
        $a.='<h2 style="margin:0;padding:0;font-size: 22px;color:#d40046;font-family:Arial,sans-serif;">
					<img src="'.TEMPLATE_URL.'/images/newsletter/noticias.png" style="vertical-align: middle;" width="30"  border="0" alt="" title="" /> '.$cat['name'].'
				</h2>';
    $a.= "</td></tr>";
    $a.= "<tr><td colspan='2'>";
        $a .= "<table cellspacing='0' cellpadding='0' border='0' width='100%'>";    
        $a .= "<tr><td rowspan='2' width='200' style='padding:0' valign='top'>";
            $a .= '<a href="'.get_permalink($id).'"> <img src="'.get_post_picture($id,'newsletter').'" width="200"  border="0" alt="" title=""  alt="" title="" border="0" /> </a>';
        $a .= "</td><td width='400' style='padding:0;padding-left:15px;'  valign='top'>";
            $a .= '<a href="'.get_permalink($id).'" style="color:#d40046;text-decoration:none;"><h3 style="margin-top:0;line-height:145%;font-size:18px;font-weight:normal;">'.$post->post_title.'</h3></a>';
            $a .= '<p style="margin:0;line-height:135%;color:#555;font-size:13px;">'.get_the_excerpt().'</p>';
         
        
        $a.= '<tr><td style="padding:0;padding-left:15px;" valign="bottom"><p style="margin:0;"><a href="'.get_permalink($id).'" style="display:block;background:#EEE;padding:10px;border-top:1px #CCC solid;text-align:right;color:#d40046;">Leer más</a></p></td></tr>';
        
        $a .= "</td></tr></table>";    
        $a .= "</td></tr>";
    } else {
        
        
        $a = "<tr><td colspan='2' style='padding-top:8px;padding-bottom:8px;border-bottom: 2px #d40046 solid;'>";
        $a.='<h2 style="margin:0;padding:0;font-size: 22px;color:#d40046;font-family:Arial,sans-serif;">
					<img src="'.TEMPLATE_URL.'/images/newsletter/noticias.png" style="vertical-align: middle;" width="30"  border="0" alt="" title="" /> '.$cat['name'].'
				</h2>';
        $a.= "</td></tr>";
        $a.= "<tr><td colspan='2'>";
        $a .= '<a href="'.get_permalink($id).'"> <img src="'.get_post_picture($id,'large').'" width="600"  border="0" alt="" title=""  alt="" title="" border="0" /> </a>';             
        $a .= "</td></tr>";
        
    }
    return $a;
}

function get_articles($args){
    
    $articles = "";

    foreach($args as $article){
    
       if(is_numeric($article)) $articles .= get_article($article);
    
    }
    
    return $articles;
}


function construct_template($args,$pdf){
    
   
    
    $template = '
    <div class="wrapper" style="background:#d40046;padding:20px;">

	<center>
	<table cellpadding="15" cellspacing="0" border="0" width="630"
		style="background:#FFF;font-family:Arial,sans-serif;font-size:13px;text-align:left">
		<tr>
			<td width="300" style="border-bottom:1px #DDD solid;">
				<a href="index.html"><h1 style="margin:0;padding:0;"><img src="'.TEMPLATE_URL.'/images/newsletter/asm-news.png" alt="ASM News" title="ASM News" border="0" /></h1></a>
			</td>
			<td width="300" valign="top" style="text-align:right;font-size:13px;color:#777;border-bottom:1px #DDD solid;">
				
				<div style="text-align:right;">
					<img src="' . TEMPLATE_URL . '/images/newsletter/tel.png" border="0" alt="902 11 33 00" title="" />
					<a href="https://www.facebook.com/oficialASM"><img src="' . TEMPLATE_URL . '/images/newsletter/facebook.png" border="0" alt="Facebook" title="" /></a>
					<a href="http://twitter.com/#!/ASM_oficial"><img src="' . TEMPLATE_URL . '/images/newsletter/twitter.png"  border="0" alt="Twitter" title="" /></a>
					<a href="http://www.youtube.com/user/MarketingASM"><img src="' . TEMPLATE_URL . '/images/newsletter/youtube.png"  border="0" alt="YouTube" title="" /></a>
				</div>
				<div style="margin: 5px 0px;">
					<a href="mailto:asmnews@asmred.com"><img src="' . TEMPLATE_URL . '/images/newsletter/email.png" border="0" alt="asmnews@asmred.com" title="asmnews@asmred.com" /></a>
				</div>		
				<div style="font-size: 18px;color:#888;">
					'.issue_name().'
				</div>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="border-bottom: 1px #DDD solid;text-align:right;padding:5px 15px;">
				<right><a href="'.$pdf.'" style="color:#888;font-size:12px;">DESCARGAR EN PDF</a></right>
			</td>
		</tr>
		
		
		
		  '.get_articles($args).'
		
	

		<tr>
			<td  colspan="2" style="background:#d40046; color:#FFF;font-size:11px;font-family:Arial,sans-serif;"><strong>AVISO LEGAL</strong>: El contenido de este mensaje de correo electrónico, incluidos los ficheros adjuntos, es confidencial y está protegido por el artículo 18.3 de la Constitución Española, que garantiza el secreto de las comunicaciones. Si usted recibe este mensaje por error, por favor póngase en contacto con el remitente para informarle de este hecho, y no difunda su contenido ni haga copias. </td>
		</tr>
		
	</table>
	</center>
</div>';

return $template;
 
    
}


?><style>
 .subject { font-size: 24px; }
 .form { margin-right: 20px; }
 .newsletter-body table td { padding:15px; }
 .newsletter-body .wrapper { margin-top:20px; 
     -webkit-box-shadow: inset 0px 5px 25px -10px rgba(0,0,0,0.7);
     
 }
 .insert-news-story {
     background: #EEE;
     border: 1px #DDD solid;
     padding: 10px;
     margin: 5px 0;
 }
  .insert-news-story select {
      padding: 4px; font-size: 16px;
      width: 80%;
  }
</style>
<h2>Newsletter</h2>

<?php


if(isset($_POST['preview'])):

$args = $_POST['insert-story'];
$pdf = $_POST['pdf'];
$url = get_permalink($args[1]);

?>

<form class="form" method="post">


<input name="articles" value="<?php echo implode(",",$args); ?>" type="hidden" />

<div style="margin-bottom:10px;">
<label for="subject">
    Enviar a...
</label>
<input type="text" name="recipient" id="recipient" class="widefat subject" value="" />
</div>


<label for="subject">
    Asunto:
</label>
<input type="text" name="subject" id="subject" class="widefat subject" value="<?php echo $_POST['subject']; ?>"  style="margin-bottom:10px;" />

<label for="subject">
    PDF (o <a href="<?php echo $url . '?print=' . base64_encode(implode(",",$args)); ?>">generar automáticamente</a>)
</label>
<input type="text" name="pdf" id="pdf" class="widefat subject" value="<?php echo $_POST['pdf']; ?>" />



<div class="newsletter-body">

    <?php echo construct_template($args,$pdf); ?>
    
</div>
<div style="text-align:center;padding:20px;">
<input type="submit" name="submit" class="button-primary" value="Enviar" style="font-size:18px !important;padding: 8px 20px;" />
</div>
</form>


<?php


elseif(isset($_POST['submit'])):
    
    $articles = $_POST['articles'];
    $args = explode(",",$articles);
    $pdf = $_POST['pdf'];
   

    $message = construct_template($args,$pdf);

    $to = $_POST['recipient'];
	$subject = $_POST['subject'];
	$from = "ASM News <asmnews@asmred.com>";
	
    $header = 'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/html; charset=UTF-8' . "\r\nFrom: $from\r\n";
    
    if(mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header)):







?>
    <div style="background:#FFFBCC;padding:40px;font-size:18px;">
        
        Newsletter enviada a <b><?php echo $_POST['recipient']; ?></b>
        
    </div>
<?php

    else:
?>
<div style="background:#FFFBCC;padding:40px;font-size:18px;">
        
        Error enviando e-mail a <b><?php echo $_POST['recipient']; ?></b>
        
 </div>
<?php
    endif;

else : 
?>

<form class="form" method="post">
<label for="subject">
    Asunto:
</label>
<input type="text" name="subject" id="subject" class="widefat subject" style="margin-bottom:10px;" />

<label for="pdf">
    Descarga PDF:
</label>
<input type="text" name="pdf" id="pdf" class="widefat subject" />

<div class="newsletter-body">
<ul class="insert">
   <?php
   
   $insert = 15;
   for($i=1;$i<=$insert;$i++):
   
        insert_story($i);
   
   endfor;
   
   ?>
</ul>
</div>
<script>

   
   jQuery(".show-select").click(function(){
   
        jQuery(this).parent().next().show();
        jQuery(this).hide();
        jQuery(this).next('a').show();
        
        return false;
   
   });
   
   jQuery(".hide-select").click(function(){
       
       jQuery(this).parent().remove();
       return false;
       
   });
    

</script>

<div style="text-align:center;padding:20px;">

<input type="submit" name="preview" class="button-primary" value="Previsualizar..." style="font-size:18px !important;padding: 8px 20px;" />

</div>

</form>
<?php
endif; ?>