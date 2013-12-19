<?php if ($modules) { ?>
<?php
$b_Layout_Settings = explode(',', $this->config->get('b_Layout_Setting'));
$column_right = $b_Layout_Settings[1];
?>
<div id="column-right" class="<?php echo $column_right; ?> omega">
  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>
  <script type="text/javascript"><!--
	$(document).ready(function() {
		<?php
		$b_Layout_Settings = explode(',', $this->config->get('b_Layout_Setting'));
		$column_right = $b_Layout_Settings[1];
		?>
		$id = 'column-left';
		var class_right = '<?php echo $column_right;?>';
		$check = $('body').find('#'+$id).attr('id');
		if((class_right == 'grid_5')&&($check != $id))
		{
			class_right = 'grid_4';
			$('#column-right').removeClass();
			$('#column-right').addClass(class_right + ' omega');
		}
	});
//--></script>
</div>
<?php } ?>