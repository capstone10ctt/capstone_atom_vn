<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $text_boss_catalog; ?></h1>
        <div class="htabs">
             <a href="<?php echo $boss_category; ?>" style="display: inline;"><?php echo $text_boss_category ; ?></a>
             <a class="selected" href="<?php echo $boss_articles; ?>" style="display: inline;"><?php echo $text_boss_articles; ?></a>
             <a href="<?php echo $boss_comments; ?>" style="display: inline;"><?php echo $text_boss_comments; ?></a>
             <a href="<?php echo $boss_settings; ?>" style="display: inline;"><?php echo $text_boss_settings; ?></a>
         </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
      <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs">
          <a href="#tab-general"><?php echo $tab_general; ?></a>
          <a href="#tab-data"><?php echo $tab_data; ?></a>
          <a href="#tab-meta"><?php echo $tab_meta; ?></a>
          <a href="#tab-related"><?php echo $tab_related; ?></a>
          <a href="#tab-related-product"><?php echo $tab_related_product; ?></a>
          <a href="#tab-design"><?php echo $tab_design; ?></a>
      </div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                <td><input type="text" name="article_description[<?php echo $language['language_id']; ?>][name]" size="100" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['name'] : ''; ?>" />
                  <?php if (isset($error_name[$language['language_id']])) { ?>
                  <span class="error"><?php echo $error_name[$language['language_id']]; ?></span>
                  <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_title; ?></td>
                <td><textarea name="article_description[<?php echo $language['language_id']; ?>][title]" cols="40" rows="5"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['title'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_content; ?></td>
                <td><textarea name="article_description[<?php echo $language['language_id']; ?>][content]" id="content<?php echo $language['language_id']; ?>"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['content'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><span class="required">*</span> <?php echo $entry_author; ?></td>
                <td><input type="text" name="author" value="<?php echo $author; ?>" />
                    <?php if ($error_author) { ?>
                    <span class="error"><?php echo $error_author; ?></span>
                    <?php } ?></td>
              </tr>
              <tr>
                <td><?php echo $entry_tag; ?></td>
                <td><input type="text" name="article_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['tag'] : ''; ?>" size="80" /></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        <div id="tab-data">
          <table class="form">
              <tr>
                  <td><?php echo $entry_category; ?></td>
                  <td><div class="scrollbox">
                      <?php $class = 'odd'; ?>
                      <?php foreach ($article_categories as $blog_category) { ?>
                      <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                      <div class="<?php echo $class; ?>">
                        <?php if (in_array($blog_category['blog_category_id'], $article_category)) { ?>
                        <input type="checkbox" name="article_category[]" value="<?php echo $blog_category['blog_category_id']; ?>" checked="checked" />
                        <?php echo $blog_category['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="article_category[]" value="<?php echo $blog_category['blog_category_id']; ?>" />
                        <?php echo $blog_category['name']; ?>
                        <?php } ?>
                      </div>
                      <?php } ?>
                    </div>
                    <a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a></td>
                </tr>
            <tr>
              <td><?php echo $entry_image; ?></td>
              <td><div class="image"><img src="<?php echo $thumb; ?>" alt="" id="thumb" /><br />
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="image" />
                  <a onclick="image_upload('image', 'thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#thumb').attr('src', '<?php echo $no_image; ?>'); $('#image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
            </tr>
            <tr>
              <td><?php echo $entry_keyword; ?></td>
              <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" size="55" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_store; ?></td>
              <td><div class="scrollbox">
                  <?php $class = 'even'; ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array(0, $article_store)) { ?>
                    <input type="checkbox" name="article_store[]" value="0" checked="checked" />
                    <?php echo $text_default; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="article_store[]" value="0" />
                    <?php echo $text_default; ?>
                    <?php } ?>
                  </div>
                  <?php foreach ($article_stores as $article_store) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div class="<?php echo $class; ?>">
                    <?php if (in_array($article_store['store_id'], $article_store)) { ?>
                    <input type="checkbox" name="article_store[]" value="<?php echo $article_store['store_id']; ?>" checked="checked" />
                    <?php echo $article_store['name']; ?>
                    <?php } else { ?>
                    <input type="checkbox" name="article_store[]" value="<?php echo $article_store['store_id']; ?>" />
                    <?php echo $article_store['name']; ?>
                    <?php } ?>
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
            <tr>
              <td><?php echo $entry_date_modified; ?></td>
              <td><input type="text" name="date_modified" value="<?php echo $date_modified; ?>" size="12" class="date" /></td>
            </tr>
            <tr>
              <td><?php echo $entry_allow_comment; ?></td>
              <td><select name="allow_comment">
                  <?php if ($allow_comment==2) { ?>
                  <option value="2" selected="selected"><?php echo $text_inherited; ?></option>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else if ($allow_comment==1) { ?>
                  <option value="2" ><?php echo $text_inherited; ?></option>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0" ><?php echo $text_disabled; ?></option>
                  <?php } else {?>
                  <option value="2" ><?php echo $text_inherited; ?></option>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_need_approval; ?></td>
              <td><select name="need_approval">
                  <?php if ($need_approval==2) { ?>
                  <option value="2" selected="selected"><?php echo $text_inherited; ?></option>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else  if ($need_approval==1){ ?>
                  <option value="2" ><?php echo $text_inherited; ?></option>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0" ><?php echo $text_disabled; ?></option>
                  <?php } else{?>
                  <option value="2" ><?php echo $text_inherited; ?></option>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_status; ?></td>
              <td><select name="status">
                  <?php if ($status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
            </tr>
            <tr>
              <td><?php echo $entry_sort_order; ?></td>
              <td><input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" /></td>
            </tr>
          </table>
        </div>
        
        <div id="tab-meta">
          <div id="languages" class="htabs">
            <?php foreach ($languages as $language) { ?>
            <a href="#language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
            <?php } ?>
          </div>
          <?php foreach ($languages as $language) { ?>
          <div id="language<?php echo $language['language_id']; ?>">
            <table class="form">
              <tr>
                <td><?php echo $entry_meta_description; ?></td>
                <td><textarea name="article_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
              </tr>
              <tr>
                <td><?php echo $entry_meta_keyword; ?></td>
                <td><textarea name="article_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($article_description[$language['language_id']]) ? $article_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
              </tr>
            </table>
          </div>
          <?php } ?>
        </div>
        
        <div id="tab-related">
          <table class="form">
            <tr>
              <td><?php echo $entry_related; ?></td>
              <td><input type="text" name="related_article" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="article-related" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($article_relateds as $article_related) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="article-related<?php echo $article_related['blog_article_id']; ?>" class="<?php echo $class; ?>"> <?php echo $article_related['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="article_related[]" value="<?php echo $article_related['blog_article_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
          </table>
        </div>
        
        <div id="tab-related-product">
          <table class="form">
            <tr>
              <td><?php echo $entry_related_product; ?></td>
              <td><input type="text" name="related_product" value="" /></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td><div id="product-related" class="scrollbox">
                  <?php $class = 'odd'; ?>
                  <?php foreach ($product_relateds as $product_related) { ?>
                  <?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
                  <div id="product-related<?php echo $product_related['product_id']; ?>" class="<?php echo $class; ?>"> <?php echo $product_related['name']; ?><img src="view/image/delete.png" />
                    <input type="hidden" name="product_related[]" value="<?php echo $product_related['product_id']; ?>" />
                  </div>
                  <?php } ?>
                </div></td>
            </tr>
          </table>
        </div>
        
        <div id="tab-design">
          <table class="list">
            <thead>
              <tr>
                <td class="left"><?php echo $entry_store; ?></td>
                <td class="left"><?php echo $entry_layout; ?></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="left"><?php echo $text_default; ?></td>
                <td class="left"><select name="article_layout[0][layout_id]">
                    <option value=""></option>
                    <?php foreach ($layouts as $layout) { ?>
                    <?php if (isset($article_layout[0]) && $article_layout[0] == $layout['layout_id']) { ?>
                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php foreach ($article_stores as $article_store) { ?>
            <tbody>
              <tr>
                <td class="left"><?php echo $article_store['name']; ?></td>
                <td class="left"><select name="article_layout[<?php echo $article_store['store_id']; ?>][layout_id]">
                    <option value=""></option>
                    <?php foreach ($article_layouts as $article_layout) { ?>
                    <?php if (isset($article_layout[$article_store['store_id']]) && $article_layout[$article_store['store_id']] == $article_layout['layout_id']) { ?>
                    <option value="<?php echo $article_layout['layout_id']; ?>" selected="selected"><?php echo $article_layout['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $article_layout['layout_id']; ?>"><?php echo $article_layout['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select></td>
              </tr>
            </tbody>
            <?php } ?>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('content<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'related_article\']').autocomplete({
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=bossblog/articles/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.blog_article_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#article-related' + ui.item.value).remove();
		
		$('#article-related').append('<div id="article-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="article_related[]" value="' + ui.item.value + '" /></div>');

		$('#article-related div:odd').attr('class', 'odd');
		$('#article-related div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#article-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#article-related div:odd').attr('class', 'odd');
	$('#article-related div:even').attr('class', 'even');	
});
//--></script> 

<script type="text/javascript"><!--
$('input[name=\'related_product\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=bossblog/articles/productauto&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
		
	}, 
	select: function(event, ui) {
		$('#product-related' + ui.item.value).remove();
		
		$('#product-related').append('<div id="product-related' + ui.item.value + '">' + ui.item.label + '<img src="view/image/delete.png" /><input type="hidden" name="product_related[]" value="' + ui.item.value + '" /></div>');

		$('#product-related div:odd').attr('class', 'odd');
		$('#product-related div:even').attr('class', 'even');
				
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
});

$('#product-related div img').live('click', function() {
	$(this).parent().remove();
	
	$('#product-related div:odd').attr('class', 'odd');
	$('#product-related div:even').attr('class', 'even');	
});
//--></script> 

<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript"><!--
$('.date').datepicker({dateFormat: 'yy-mm-dd'});
$('.datetime').datetimepicker({
	dateFormat: 'yy-mm-dd',
	timeFormat: 'h:m'
});
$('.time').timepicker({timeFormat: 'h:m'});
//--></script> 
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#languages a').tabs(); 
$('#vtab-option a').tabs();
//--></script> 
<?php echo $footer; ?>