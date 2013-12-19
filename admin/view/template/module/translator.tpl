<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
	    <?php echo $translation_total_overall; ?>
		<?php if (isset($button_create)) { ?>
			<a onclick="$('#form').attr('action', '<?php echo $createFiles; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><?php echo $button_create; ?></a>
			<a onclick="$('#form').attr('action', '<?php echo $checkData; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><?php echo $button_check_data; ?></a>
			<a onclick="$('#form').attr('action', '<?php echo $exportExcel; ?>'); $('#form').attr('target', '_blank'); $('#form').submit();" class="button"><?php echo $button_excel; ?></a>
		<?php } ?>
		<a onclick="$('#form').attr('action', '<?php echo $loadData; ?>'); $('#form').attr('target', '_self'); $('#form').submit();" class="button"><?php echo $button_load_data; ?></a>
		</div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td><?php if ($sort == 'module') { ?>
                <a href="<?php echo $sort_module; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_module; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_module; ?>"><?php echo $column_module; ?></a>
                <?php } ?></td>
              <td><?php if ($sort == 'folder') { ?>
                <a href="<?php echo $sort_folder; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_folder; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_folder; ?>"><?php echo $column_folder; ?></a>
                <?php } ?></td>
              <td><?php if ($sort == 'file') { ?>
                <a href="<?php echo $sort_file; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_file; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_file; ?>"><?php echo $column_file; ?></a>
                <?php } ?></td>
              <td><?php if ($sort == 'variable') { ?>
                <a href="<?php echo $sort_variable; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_variable; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_variable; ?>"><?php echo $column_variable; ?></a>
                <?php } ?></td>
              <td><?php if ($sort == 'translation_source') { ?>
                <a href="<?php echo $sort_translation_source; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_translation_source; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_translation_source; ?>"><?php echo $column_translation_source; ?></a>
                <?php } ?><select onChange="filter();" name="filter_language_source">
				<?php if ($filter_language_destination == 0) { ?>
				<option value="0" selected="selected"><?php echo $entry_empty; ?></option>
				<?php } else { ?>
				<option value="0"><?php echo $entry_empty; ?></option>
				<?php } ?>
                <?php foreach ($languages as $language) { ?>
					<?php if ($language['language_id'] == $filter_language_source) { ?>
					<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
					<?php } ?>
                <?php } ?>
              </select></td>
              <td><?php if ($sort == 'translation_destination') { ?>
                <a href="<?php echo $sort_translation_destination; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_translation_destination; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_translation_destination; ?>"><?php echo $column_translation_destination; ?></a>
                <?php } ?><select onChange="filter();" name="filter_language_destination">
				<?php if ($filter_translation_destination== 0) { ?>
				<option value="0" selected="selected"><?php echo $entry_empty; ?></option>
				<?php } else { ?>
				<option value="0"><?php echo $entry_empty; ?></option>
				<?php } ?>
                <?php foreach ($languages as $language) { ?>
					<?php if ($language['language_id'] == $filter_language_destination) { ?>
					<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
					<?php } else { ?>
					<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
					<?php } ?>
                <?php } ?>
              </select></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td><input type="text" name="filter_module" value="<?php echo $filter_module; ?>" /></td>
              <td><input type="text" name="filter_folder" value="<?php echo $filter_folder; ?>" /></td>
              <td><input type="text" name="filter_file" value="<?php echo $filter_file; ?>" /></td>
              <td><input type="text" name="filter_variable" value="<?php echo $filter_variable; ?>" /></td>
              <td><input type="text" name="filter_translation_source" value="<?php echo $filter_translation_source; ?>" /></td>
              <td><input type="text" name="filter_translation_destination" value="<?php echo $filter_translation_destination; ?>" /></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($translations) { ?>
            <?php foreach ($translations as $translation) { ?>
            <tr>
              <td><?php echo $translation['module']; ?></td>
              <td><?php echo $translation['folder']; ?></td>
              <td><?php echo $translation['file']; ?></td>
              <td><?php echo $translation['variable']; ?></td>
              <td><?php echo $translation['translation_source']; ?></td>
              <td><?php echo $translation['translation_destination']; ?></td>
              <td class="right"><?php foreach ($translation['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>" target="_blank"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=module/translator&token=<?php echo $token; ?>';
	
	var filter_module = $('input[name=\'filter_module\']').attr('value');
	
	if (filter_module) {
		url += '&filter_module=' + encodeURIComponent(filter_module);
	}
	
	var filter_folder = $('input[name=\'filter_folder\']').attr('value');
	
	if (filter_folder) {
		url += '&filter_folder=' + encodeURIComponent(filter_folder);
	}
	
	var filter_file = $('input[name=\'filter_file\']').attr('value');
	
	if (filter_file) {
		url += '&filter_file=' + encodeURIComponent(filter_file);
	}
	
	var filter_variable = $('input[name=\'filter_variable\']').attr('value');

	if (filter_variable) {
		url += '&filter_variable=' + encodeURIComponent(filter_variable);
	}	
	
	var filter_translation_source = $('input[name=\'filter_translation_source\']').attr('value');
	
	if (filter_translation_source) {
		url += '&filter_translation_source=' + encodeURIComponent(filter_translation_source);
	}
	
	var filter_translation_destination = $('input[name=\'filter_translation_destination\']').attr('value');
	
	if (filter_translation_destination) {
		url += '&filter_translation_destination=' + encodeURIComponent(filter_translation_destination);
	}

	var filter_language_source = $('select[name=\'filter_language_source\']').attr('value');
	
	if (filter_language_source) {
		url += '&filter_language_source=' + encodeURIComponent(filter_language_source);
	}
	
	var filter_language_destination = $('select[name=\'filter_language_destination\']').attr('value');
	
	if (filter_language_destination) {
		url += '&filter_language_destination=' + encodeURIComponent(filter_language_destination);
	}
	
	location = url;
}
//--></script>  
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$.widget('custom.catcomplete', $.ui.autocomplete, {
	_renderMenu: function(ul, items) {
		var self = this, currentCategory = '';
		
		$.each(items, function(index, item) {
			if (item.category != currentCategory) {
				ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
				
				currentCategory = item.category;
			}
			
			self._renderItem(ul, item);
		});
	}
});

$('input[name=\'filter_file\']').catcomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						category: item.customer_group,
						label: item.name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_file\']').val(ui.item.label);
						
		return false;
	}
});
//--></script> 
<?php echo $footer; ?>