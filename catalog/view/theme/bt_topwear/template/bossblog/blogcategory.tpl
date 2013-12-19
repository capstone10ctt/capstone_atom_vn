<?php echo $header; ?>
<div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
	<?php if($breadcrumb == end($breadcrumbs)){ ?>
		<a class="last" href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	<?php }else{ ?>
		<a href="<?php echo $breadcrumb['href']; ?>"><span><?php echo $breadcrumb['text']; ?></span></a>
    <?php } ?>
    <?php } ?>
</div>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
<div class="blogcategory_fr">
   <div class="page-title category-title">
    <h1><?php echo $heading_title; ?></h1>
  </div>
  
  <?php if ($thumb || $description) { ?>
      <?php if ($thumb) { ?>
        <div class="category-image blog_banner"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></div>
      <?php } ?>
      <?php if ($description) { ?> 
        <div class="category-description std">
             <?php echo $description; ?>
        </div>
      <?php } ?>  
  <?php } ?>
  
  <?php if ($blogcategories) { ?>
  <h2><?php echo $text_sub_category; ?></h2>
  <div class="category-list">
    <?php if (count($blogcategories) <= 5) { ?>
    <ul>
      <?php foreach ($blogcategories as $category) { ?>
      <li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></li>
      <?php } ?>
    </ul>
    <?php } else { ?>
    <?php for ($i = 0; $i < count($blogcategories);) { ?>
    <ul>
      <?php $j = $i + ceil(count($blogcategories) / 4); ?>
      <?php for (; $i < $j; $i++) { ?>
      <?php if (isset($blogcategories[$i])) { ?>
      <li><a href="<?php echo $blogcategories[$i]['href']; ?>"><?php echo $blogcategories[$i]['name']; ?></a></li>
      <?php } ?>
      <?php } ?>
    </ul>
    <?php } ?>
    <?php } ?>
  </div>
  <?php } ?>
  
  <?php if ($articles) { ?> 
  
        <div class="article-filter">
            <div class="rss-feed">
                <a href="<?php echo $link_rss; ?>" title='RSS'><img src='catalog/view/theme/default/image/bossblog/rss.png' alt='Subscribe' /></a>
            </div>
            <div class="limit"><b><?php echo $text_limit; ?></b>
              <select  id="blog_limit_select"   onchange="location = this.value;">
                <?php foreach ($limits as $limits) { ?>
                <?php if ($limits['value'] == $limit) { ?>
                <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
            <div class="sort"><b><?php echo $text_sort; ?></b>
              <select  id="blog_sort_select" onchange="location = this.value;">
                <?php foreach ($sorts as $sorts) { ?>
                <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
                <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
            </div>
            <div class="display"><b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <a onclick="display('grid');"><?php echo $text_grid; ?></a></div>
          </div>
    
		<?php
			$b_Layout_Settings = explode(',', $this->config->get('b_Layout_Setting'));
			if(isset($B_Layout_Settings)){
				$div_product = $B_Layout_Settings[2];
			}else{
				$div_product = 'grid_4';
			}
			if(($column_left==' ')&&($column_right=='')){
				if($div_product =='grid_5'){
					$div_product = 'grid_4';
				}
			}
		?>	   
		   
        <div class="boss_article-items">
            <div class="article-list"> 
                    <?php foreach ($articles as $article) { ?><div class="boss_article-item <?php echo $div_product; ?><?php if($article==end($articles)){echo ' last';} ?>">
                    <div class="article-name">
                        <h2><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h2>                    
                    </div>
                    <div class="std">					
                        <?php if($article['thumb']){ ?><div class="article-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /></a></div><?php } ?>
    					
    					<div class="time-stamp">
                            <?php $date = new DateTime($article['date_modified']);?>
                            <small><?php echo $date->format('l, M j, Y');?></small>
                        </div>
                        <div class="article-title"><p><?php  echo $article['title']; ?></p></div>
    					<div class="article-footer">
                            <span class="post-by"> Post by <span><?php echo $article['author']; ?></span></span>
                            <span class="separator">|</span>
        					<span class="comment-count"><span><?php echo $article['comment']; ?> </span><a href="<?php echo $article['href']; ?>">Comment(s)</a></span>                 
                        </div>
                    </div>
                    
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="pagination"><?php echo $pagination; ?></div>  
    <?php } else { ?>
      <div class="content"><?php echo $text_empty; ?></div>
    <?php } ?>
  <?php echo $content_bottom; ?>
  </div></div>
  <script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.article-grid').attr('class', 'article-list');
		
		$('.article-list > div').each(function(index, element) {
            html = '';
			var image = $(element).find('.article-image').html();
			if (image != null) { 
			html += '  <div class="article-image">' + $(element).find('.article-image').html() + '</div>';
			}
			
			html += '<div class="std">';
            
			html += '  <div class="article-name">' + $(element).find('.article-name').html() + '</div>';
			html += '  <div class="time-stamp">' + $(element).find('.time-stamp').html() + '</div>';		
			html += '  <div class="article-title">' + $(element).find('.article-title').html() + '</div>';
			html += '  <div class="article-footer">' + $(element).find('.article-footer').html() + '</div>';
				
			html += '</div>';

						
			$(element).html(html);
		});	

		$('.display').html('<b><?php echo $text_display; ?></b><a class="no-active-gird" onclick="display(\'grid\');"><?php echo $text_grid; ?></a><span class="active-list"><?php echo $text_list; ?> </span>');
		
		$.totalStorage('display', 'list'); 
	} else {
		$('.article-list').attr('class', 'article-grid');
		
		$('.article-grid > div').each(function(index, element) {
			html = '';
			html +='<div>';
			var image = $(element).find('.article-image').html();
			if (image != null) { 
			html += '<div class="article-image">' + $(element).find('.article-image').html() + '</div>';
			}
			html += '<div class="article-name">' + $(element).find('.article-name').html() + '</div>';
            html += '  <div class="time-stamp">' + $(element).find('.time-stamp').html() + '</div>';
            html += '  <div class="article-title">' + $(element).find('.article-title').html() + '</div>';
            html += '  <div class="article-footer">' + $(element).find('.article-footer').html() + '</div>';
			html +='</div>';
			$(element).html(html);
		});
		
		$('.display').html('<b><?php echo $text_display; ?></b><span class="active-gird"><?php echo $text_grid; ?></span><a class="no-active-list" onclick="display(\'list\');"><?php echo $text_list; ?></a>');
		
		$.totalStorage('display', 'grid');
	}
}
view = $.totalStorage('display');

if (view) {
	display(view);
} else {
	display('list');
}
$(document).ready(function() {
	category_resize();
});
$(window).resize(function() {
	category_resize();
});
function category_resize()
{
	if(getWidthBrowser() < 768){
		display('grid');
	}
}
//--></script> 
<script type="text/javascript">
$(function () {
	$("#blog_limit_select").selectbox();
	$("#blog_sort_select").selectbox();
});
</script>
<?php echo $footer; ?>