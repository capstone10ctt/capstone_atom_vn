<?php 
if($data_template){
	echo $data_template;
} else { ?>
<div class="cpanelContainer" style="display:none; clear:both;">
	<div class="boss-themedesign">
		<div class="cpanel_icon">
			<span>icon</span>
		</div> <!-- End .cpanel_icon-->

		<h2>Theme Design</h2>
		<ul id="bt_category">
			<li> <!-- Design background -->
				<span class="expand">Design Background</span>
				<ul class="design_background"> 
				<h3>Body Background</h3>
					<?php foreach ($bg_images as $image => $settings) {?>
					<li><a onclick="addBackground('<?php echo $settings;?>','body')" href="#"><img alt="Background" src="image/data/background/<?php echo $settings; ?>" /></a></li>
					<?php } ?>
				</ul>
				
				<ul class="design_background"> 
					<h3>Header Background</h3>
					<?php foreach ($bg_images as $image => $settings) {?>
					<li><a onclick="addBackground('<?php echo $settings;?>','header')" href="#"><img alt="Background" src="image/data/background/<?php echo $settings; ?>" /></a></li>
					<?php } ?>
				</ul>
				
				<ul class="design_background"> 
				<h3>Footer Background</h3>
					<?php foreach ($bg_images as $image => $settings) {?>
					<li><a onclick="addBackground('<?php echo $settings;?>','footer')" href="#"><img alt="Background" src="image/data/background/<?php echo $settings; ?>" /></a></li>
					<?php } ?>
				</ul>
			</li> <!-- End Design background-->
			
			<li><!-- Mode Css-->
				<span class="expand">Mode CSS</span>
				<?php $b_Mode_CSS = $this->config->get('b_Mode_CSS'); ?>
				<ul class="mode_css"> 
					<input type="radio" id="mode_box" value="box" onclick="changeModeCSS('box')" name="b_Mode_CSS" <?php if ($b_Mode_CSS == 'box') echo ' checked="checked"'; ?> /> Box
					<input type="radio" id="mode_wide" value="wide" onclick="changeModeCSS('wide')" name="b_Mode_CSS" <?php if ($b_Mode_CSS == 'wide') echo ' checked="checked"'; ?> /> Wide
				</ul>
			</li>
			
			<li><!-- product grid view-->
				<span class="expand">Product Grid View</span>
				<?php $b_Layout_Setting = $this->config->get('b_Layout_Setting'); ?>
				<ul class="mode_css"> 
					<p><input type="radio" id="view_grid_8_grid_8_grid_8" value="grid_8,grid_8,grid_8" onclick="changeProductView('grid_8','grid_8','grid_8')" name="b_Layout_Setting" <?php if ($b_Layout_Setting == 'grid_8,grid_8,grid_8') echo ' checked="checked"'; ?> /> Extra</p>
					<p><input type="radio" id="view_grid_6_grid_6_grid_6" value="grid_6,grid_6,grid_6" onclick="changeProductView('grid_6','grid_6','grid_6')" name="b_Layout_Setting" <?php if ($b_Layout_Setting == 'grid_6,grid_6,grid_6')  echo ' checked="checked"'; ?> /> Large</p>
					<p><input type="radio"  id="view_grid_4_grid_5_grid_5" value="grid_4,grid_5,grid_5" onclick="changeProductView('grid_4','grid_5','grid_5')" name="b_Layout_Setting" <?php if ($b_Layout_Setting == 'grid_4,grid_5,grid_5') echo ' checked="checked"'; ?> /> Medium 1</p>
					<p><input type="radio" id="view_grid_4_grid_4_grid_4" value="grid_4,grid_4,grid_4" onclick="changeProductView('grid_4','grid_4','grid_4')" name="b_Layout_Setting" <?php if ($b_Layout_Setting == 'grid_4,grid_4,grid_4') echo ' checked="checked"'; ?> /> Medium 2</p>
					<p><input type="radio" id="view_grid_6_grid_6_grid_3" value="grid_6,grid_6,grid_3" onclick="changeProductView('grid_6','grid_6','grid_3')" name="b_Layout_Setting" <?php if ($b_Layout_Setting == 'grid_6,grid_6,grid_3') echo ' checked="checked"'; ?> /> Small</p>
				</ul>
			</li>
			
			<li><!-- Font setting-->
				<span class="expand">Font Setting</span>
				<ul class="accordion_content"> 
					<?php
						$json = file_get_contents("catalog/view/theme/".$this->config->get('config_template')."/fonts/webfonts.json", true);
						$decode = json_decode($json, true);
						$webfonts = array();
						foreach ($decode['items'] as $key => $value) {
							// FONT FAMILY
							$item_family = $decode['items'][$key]['family'];
							$item_family_trunc =  str_replace(' ','+',$item_family);
							$webfonts[$item_family_trunc] = $item_family;
						}
						//print_r ($default);
						$defaultFont = array( 
							'Arial', 
							'Verdana', 
							'Helvetica', 
							'Lucida Grande', 
							'Trebuchet MS', 
							'Times New Roman', 
							'Tahoma', 
							'Georgia'
							);
						$FontWeight = array( 'default','normal', 'bold' );
						
					?>
					<?php $FontsSizes = array( 
						'default', '10px', '11px', '12px', '13px', '14px', '15px', '16px', '17px', '18px', '19px', '20px', '21px', '22px', '23px', '24px', '25px', 
						'26px', '27px', '28px', '29px', '30px', '31px', '32px', '33px',
						'34px', '35px', '36px', '37px', '38px', '39px', '40px', '41px',
						'42px', '43px', '44px', '45px', '46px', '47px', '48px', '49px', '50px'
					); ?>
					<?php 
						$b_Font_Data = array();
						$b_Font_Data = $this->config->get('b_Font_Data');
					?>
					<?php $objXML = simplexml_load_file("config_xml/font_setting.xml"); ?>
					<?php foreach ($objXML->children() as $child) {	
						foreach($child->children() as $childOFchild){ ?>
						<li><h3><?php echo $childOFchild->text; ?></h3>
							<div class="boss_font">
								<select id="<?php echo $childOFchild->style; ?>" name="b_Font_Data[<?php echo $childOFchild->style; ?>]" onchange="selectedFontStyle('<?php echo $childOFchild->style; ?>','<?php echo $childOFchild->class_name; ?>')">
									<option>default</option>
									<optgroup label="HTML default fonts">
									<?php foreach ($defaultFont as $key) { ?>
										<?php ($key ==  $b_Font_Data[''.$childOFchild->style.'']) ? $selected = 'selected' : $selected = ''; ?>
										<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
									<?php } ?>
									</optgroup>
									<optgroup label="Google fonts">
									<?php foreach ($webfonts as $key => $face ) { ?>
										<?php ($key ==  $b_Font_Data[''.$childOFchild->style.'']) ? $selected = 'selected' : $selected=''; ?>
										<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $face; ?></option>
									<?php } ?>
									</optgroup>
								</select>
							</div>
							<div class="boss_size">
								<select id="<?php echo $childOFchild->size; ?>" name="b_Font_Data[<?php echo $childOFchild->size; ?>]" onchange="selectedFontSize('<?php echo $childOFchild->size; ?>','<?php echo $childOFchild->class_name; ?>')">
									<?php foreach ($FontsSizes as $key) { ?>
										<?php ($key ==  $b_Font_Data[''.$childOFchild->size.'']) ? $selected = 'selected' : $selected=''; ?>
										<option value="<?php echo $key; ?>" <?php echo $selected; ?>><?php echo $key; ?></option>
									<?php } ?>
								</select>
							</div>
						</li>
					<?php } } ?>
				</ul>
			</li> <!-- End font setting-->
			
			<li><!-- Color setting-->
				<span class="expand">Color Setting</span>
				<ul class="accordion_content"> 
					<li><h3>Template Color</h3>
						<div class="boss_color_scheme">
							<?php
								$b_Setting = $this->config->get('b_Setting');
								$b_Color_Data = $this->config->get('b_Color_Data');
							?>
							<select id="temp_setting" name="b_Setting[temp_setting]" onchange="changeTemplate();">
								<option value="custom" <?php ($b_Setting['temp_setting']) =='custom' ? $selected = 'selected' : $selected = ''; ?>>Custom</option>
								<?php foreach ($temp_setting_arr as $key => $value){ ?>
									<?php if ($key == $b_Setting['temp_setting']){ ?>
										<option value="<?php echo $key; ?>" selected="selected"><?php echo $temp_name_arr[$key]; ?></option>
									<?php } else{ ?>
										<option value="<?php echo $key; ?>"><?php echo $temp_name_arr[$key]; ?></option>
									<?php } ?>
								 <?php } ?>
							</select>
						</div>
					</li>
					<?php $objXML = simplexml_load_file("config_xml/color_setting.xml"); ?>
					<?php foreach ($objXML->children() as $child) { ?>
							<h2 class="title"><?php echo $child->getName();  ?></h2>
					<?php foreach($child->children() as $childOFchild){ ?>
							<li> 
								<h3><?php echo $childOFchild->text; ?></h3>
							<?php foreach($childOFchild->children() as $childOF){ ?>
								<?php if($childOF->text || $childOF->name ){ ?>
								<?php if($childOF->text && $childOF->name ){ echo '<p>'; } ?>
									<?php if($childOF->text){ ?>
										<span><?php echo $childOF->text; ?></span>
									<?php } ?>
									<?php if($childOF->name){ ?>
										<input size=6 type="text" class="hex" style="width:50px" name="b_Color_Data[<?php echo $childOF->name; ?>]" id="<?php echo $childOF->name; ?>" value="<?php echo $b_Color_Data[''.$childOF->name.''] ?>" />
									<?php } ?>
								<?php if($childOF->text && $childOF->name ){ echo '</p>'; } ?>
								<?php	} ?>
							<?php	} ?>
							</li> 
					<?php } } ?>
				</ul>
			</li> <!-- End Color setting -->
			<span class="button_black"><input type="button" value="Reset" onclick="ResetAll()" /></span>
			<input type="hidden" id="colors_data" name="colors_data" value='<?php echo $colors_data; ?>' />
		</ul>

	</div> <!-- End .boss-themedesign--> 
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.dcjqaccordion.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/bossthemes.setting.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.total-storage.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/colorpicker.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/eye.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/utils.js"></script>
<!--<script type="text/javascript" src="catalog/view/javascript/bossthemes/layout.js"></script>-->
<?php include "catalog/view/javascript/bossthemes/layout.js.php"; ?>
<?php if (file_exists('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/boss_editorthemes.css')) {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/boss_editorthemes.css" media="screen" />';
	} else {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/boss_editorthemes.css" media="screen" />';
	}
?>
<?php if (file_exists('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/colorpicker.css')) {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/colorpicker.css" media="screen" />';
	} else {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/colorpicker.css" media="screen" />';
	}
?>
<?php if (file_exists('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/layout.css')) {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/layout.css" media="screen" />';
	} else {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/layout.css" media="screen" />';
	}
?>
<script type="text/javascript"><!--
$('.cpanelContainer').css("display", "block");
var colorsData = jQuery.parseJSON($("#colors_data").val());
<?php $objXML = simplexml_load_file("config_xml/color_setting.xml");
$code_color = array();
foreach ($objXML->children() as $child){
	foreach($child->children() as $childOFchild){
		foreach($childOFchild->children() as $childOF){ 
			if($childOF->name!=''){
				$code_color[] = $childOF->name;
			}
		}
	}	
}
?>
var id_Color_List = Array(<?php foreach ($code_color as $color) {
								if($color==end($code_color))
									echo "'".$color."'";
								else
									echo "'".$color."'".", ";
								
								} ?>);
function changeTemplate() {
	themeName = $("#temp_setting").val();
	if(themeName!='custom'){
	themeData = colorsData[themeName];
	<?php	
		foreach ($objXML->children() as $child){
			foreach($child->children() as $childOFchild){
				foreach($childOFchild->children() as $childOF){ 
					if($childOF->name!=''){ ?>
						$("<?php echo $childOF->class ?>").css('<?php echo $childOF->style; ?>','#' + themeData['<?php echo $childOF->name ?>']);
						$("#<?php echo $childOF->name ?>").css('background', '#' + themeData['<?php echo $childOF->name ?>']);
						$("#<?php echo $childOF->name ?>").val(themeData['<?php echo $childOF->name ?>']);
					<?php }
				}
			}	
		}
	?>	
	}
	if(themeName=='custom'){
		<?php
			$b_Color_Data = $this->config->get('b_Color_Data');
		?>
		<?php	
			foreach ($objXML->children() as $child){
				foreach($child->children() as $childOFchild){
					foreach($childOFchild->children() as $childOF){ 
						if($childOF->name!=''){ ?>
							$("<?php echo $childOF->class ?>").css('<?php echo $childOF->style; ?>',"#<?php echo $b_Color_Data[''.$childOF->name.''] ?>");
							$("#<?php echo $childOF->name ?>").css('background', "#<?php echo $b_Color_Data[''.$childOF->name.''] ?>");
							$("#<?php echo $childOF->name ?>").val("<?php echo $b_Color_Data[''.$childOF->name.''] ?>");
							
						<?php }
					}
				}	
			}
		?>
	}
};
//--></script>
<script type="text/javascript"><!-- 
$(window).ready(function(){
	$(window).click(function() {
	$('.colorpicker').hide();
	});
	$('input[type="text"]').focus(function() {
	$('.colorpicker').hide();
});
});
function changeProductView($class_left,$class_right,$class_product){
	var class_left = $class_left;
	var class_right = $class_right;
	var class_right_old = $class_right;
	var class_product = $class_product;
	var class_product_old = $class_product;
	$('#column-left').removeClass();
	$('#column-left').addClass(class_left + ' alpha');
	<?php
	if(($column_left==' ')&&($column_right=='')){ ?>
		if(class_product=='grid_5'){
			class_product = 'grid_4';
		}
	<?php } ?>
	$id = 'column-left';
	$check = $('body').find('#'+$id).attr('id');
	if((class_right == 'grid_5')&&($check != $id))
	{
		class_right = 'grid_4';
		$('#column-right').removeClass();
		$('#column-right').addClass(class_right + ' omega');
	} else{
		$('#column-right').removeClass();
		$('#column-right').addClass(class_right + ' omega');
	}
	$('.product-grid > div').removeClass();
	$('.product-grid > div').addClass(class_product);
	$('.article-grid > div').removeClass();
	$('.article-grid > div').addClass(class_product);
	var class_array_new = new Array();
	class_array_new[0] = class_left;
	class_array_new[1] = class_right_old;
	class_array_new[2] = class_product_old;
	$.totalStorage('changeProductView', class_array_new);
}
function changeModeCSS($Mode_class){
	var Mode_class = $Mode_class;
	$('#container').removeClass();
	$('#container').addClass(Mode_class);
	$.totalStorage('changeModeCSS', Mode_class);
}
	Mode_class = $.totalStorage('changeModeCSS');
	if (Mode_class) {
		changeModeCSS(Mode_class);
		document.getElementById('mode_'+ Mode_class).checked=true;
	}
function addBackground($link_image,$location){
	var link_image = $link_image;
	var location = $location;
	var repeat = 'repeat';
	var position = 'left top';
	switch(location){
		case 'body':
			if(link_image != ''){
				$("#container").css('background-image', "url(image/data/background/" + link_image + ")");
				$("#container").css('background-repeat', repeat);
				$("#container").css('background-position', position);
			}else{
				$("#container").css('background-image','');
				$("#container").css('background-repeat', '');
				$("#container").css('background-position','');
			}
			$.totalStorage('addBackground_body', link_image);
			
			break;
		case 'footer':
			if(link_image != ''){
				$("#footer").css('background-image', "url(image/data/background/" + link_image + ")");
				$("#footer").css('background-repeat', repeat);
				$("#footer").css('background-position', position);
			}else{
				$("#footer").css('background-image', '');
				$("#footer").css('background-repeat', '');
				$("#footer").css('background-position','');
			}
			$.totalStorage('addBackground_footer', link_image);
			
			break;
		case 'header':
			if(link_image != ''){
				$("#header").css('background-image', "url(image/data/background/" + link_image + ")");
				$("#header").css('background-repeat', repeat);
				$("#header").css('background-position', position);
			}else{
				$("#header").css('background-image', '');
				$("#header").css('background-repeat', '');
				$("#header").css('background-position', '');
			}
			$.totalStorage('addBackground_header', link_image);
			
			break;
	}
}
link_image_body = $.totalStorage('addBackground_body');
if (link_image_body) {
	addBackground(link_image_body,'body');
}
link_image_header = $.totalStorage('addBackground_header');
if (link_image_header) {
	addBackground(link_image_header,'header');
}
function ResetAll(){
	addBackground('','footer');
	addBackground('','body');
	addBackground('','header');
	var Mode_class_old = '<?php echo $this->config->get('b_Mode_CSS') ;?>';
	changeModeCSS(Mode_class_old);
	document.getElementById('mode_'+ Mode_class_old).checked=true;
	<?php
	$b_Layout_Settings = explode(',', $this->config->get('b_Layout_Setting'));
	?>
	var class_left = '<?php echo $b_Layout_Settings[0] ; ?>';
	var class_right = '<?php echo $b_Layout_Settings[1] ; ?>';
	var class_product = '<?php echo $b_Layout_Settings[2] ; ?>';
	changeProductView(class_left,class_right,class_product);
	document.getElementById('view_'+ class_left + '_' + class_right + '_' + class_product).checked=true;
	$("#temp_setting").val('<?php echo($b_Setting['temp_setting']); ?>')
	var template = '<?php echo($b_Setting['temp_setting']); ?>';
	<?php
		$b_Color_Data = $this->config->get('b_Color_Data');
	?>
	
	<?php	
		foreach ($objXML->children() as $child){
			foreach($child->children() as $childOFchild){
				foreach($childOFchild->children() as $childOF){ 
					if($childOF->name!=''){ ?>
						$("<?php echo $childOF->class ?>").css('<?php echo $childOF->style; ?>',"#<?php echo $b_Color_Data[''.$childOF->name.''] ?>");
						$("#<?php echo $childOF->name ?>").css('background', "#<?php echo $b_Color_Data[''.$childOF->name.''] ?>");
						$("#<?php echo $childOF->name ?>").val("<?php echo $b_Color_Data[''.$childOF->name.''] ?>");
						
					<?php }
				}
			}	
		}
	?>
}
$(document).ready(function() {
	class_array_new = $.totalStorage('changeProductView');
	if (class_array_new) {
		changeProductView(class_array_new[0],class_array_new[1],class_array_new[2]);
		document.getElementById('view_'+ class_array_new[0] + '_' + class_array_new[1] + '_' + class_array_new[2]).checked=true;
	}
	link_image_footer = $.totalStorage('addBackground_footer');
	if (link_image_footer) {
		addBackground(link_image_footer,'footer');
	}
});
//--></script>
</div> <!-- End .cpanelContainer -->
<?php } ?>