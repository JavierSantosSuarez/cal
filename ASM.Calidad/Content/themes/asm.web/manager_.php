<?php


if(isset($_POST['update'])):
	
	/*update_option("asm_loc_farecalculator",$_POST['asm_loc_farecalculator']);
	update_option("asm_loc_storelocator",$_POST['asm_loc_storelocator']);
	update_option("asm_loc_empresa",$_POST['asm_loc_empresa']);
	update_option("asm_loc_servicios",$_POST['asm_loc_servicios']);
	update_option("asm_loc_legal",$_POST['asm_loc_legal']);*/

	update_option("fares_discount",$_POST['fares_discount']);
	update_option("fares_vat",$_POST['fares_vat']);

	echo "<div style='background:yellow'><b>Datos actualizados</b></div>";

endif;


$pages = get_posts('post_type=page&numberposts=-1');

?>
<form method="post">
<h1>Calcula tu envío</h1>
<label for="fares_discount">Aplicar descuento</label>
<p><input name="fares_discount" id="fares_discount" type="number" min="0" step="1" value ="<?php echo get_option('fares_discount'); ?>" /> %</p>

<label for="fares_vat">IVA</label>
<p><input name="fares_vat" id="fares_vat" type="number" min="0" step="1" value ="<?php echo get_option('fares_vat'); ?>" /> %</p>

<?php /*
<h4>Enlaces</h4>
<label>Calcula tu envío</label>
<p><select name="asm_loc_farecalculator">
<?php foreach($pages as $page): ?>
<?php $selected = ($page->ID == get_option('asm_loc_farecalculator')) ? "selected='selected'" : false;  ?>
	<option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title; ?></option>
<?php endforeach; ?>
</select></p>

<label>Agencias ASM</label>
<p><select name="asm_loc_storelocator">
<?php foreach($pages as $page): ?>
<?php $selected = ($page->ID == get_option('asm_loc_storelocator')) ? "selected='selected'" : false;  ?>
	<option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title; ?></option>
<?php endforeach; ?>
</select></p>

<label>Empresa</label>
<p><select name="asm_loc_empresa">
<?php foreach($pages as $page): ?>
<?php $selected = ($page->ID == get_option('asm_loc_empresa')) ? "selected='selected'" : false;  ?>
	<option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title; ?></option>
<?php endforeach; ?>
</select></p>

<label>Servicios</label>
<p><select name="asm_loc_servicios">
<?php foreach($pages as $page): ?>
<?php $selected = ($page->ID == get_option('asm_loc_servicios')) ? "selected='selected'" : false;  ?>
	<option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title; ?></option>
<?php endforeach; ?>
</select></p>

<label>Legal</label>
<p><select name="asm_loc_legal">
<?php foreach($pages as $page): ?>
<?php $selected = ($page->ID == get_option('asm_loc_legal')) ? "selected='selected'" : false;  ?>
	<option value="<?php echo $page->ID; ?>" <?php echo $selected; ?>><?php echo $page->post_title; ?></option>
<?php endforeach; ?>
</select></p>
*/ ?>

<input type="submit" class="button-primary" name="update" value="Actualizar" />
</form>