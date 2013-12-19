<script type="text/javascript"><!--
$(document).ready(function() {
	function addStyle(i){
		$("#" + id_Color_List[i]).css('background', '#' + $("#" + id_Color_List[i]).val());
	}
	for(var i = 0 ; i < id_Color_List.length; i++ ){
			addStyle(i);
	};
});
(function($){
	function changeColorPicker(id_name,class_name,style){
		$('#' + id_name).ColorPicker({
			onSubmit: function(hsb, hex, rgb, el) {
				$(el).val(hex);
				$(el).css({backgroundColor:"#" + hex});
				$(el).ColorPickerHide();
			},
			onChange: function (hsb, hex, rgb) {
				if ($("#temp_setting").val() != "custom") {
                  $("#temp_setting").val("custom");
                }
				var idName = id_name;
				var className = class_name;
				$("#" + id_name).css('background', '#' + hex);
				$("#" + id_name).val(hex);
				$(class_name).css(style,'#' + hex);
			},
			onBeforeShow: function () {
				$(this).ColorPickerSetColor(this.value);
			}
			
		});
	};	
	var initLayout = function() {
		<?php	
			foreach ($objXML->children() as $child){
				foreach($child->children() as $childOFchild){
					foreach($childOFchild->children() as $childOF){ 
						if($childOF->name!=''){ ?>
							changeColorPicker('<?php echo $childOF->name ?>','<?php echo $childOF->class ?>','<?php echo $childOF->style; ?>');
						<?php }
					}
				}	
			}
		?>
	};	
	EYE.register(initLayout, 'init');
})(jQuery)
//--></script>




















