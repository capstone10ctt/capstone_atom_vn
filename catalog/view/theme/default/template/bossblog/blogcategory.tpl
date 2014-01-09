<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <div class="page-title category-title">
    <h1><?php echo $heading_title; ?></h1>
  </div>
  
  <?php if ($thumb || $description) { ?>
      <?php if ($thumb) { ?>
        <p class="category-image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" title="<?php echo $heading_title; ?>" /></p>
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
              <select onchange="location = this.value;">
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
              <select onchange="location = this.value;">
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
    
        <div class="boss_article-items">
            <div class="article-list">
         
                <?php $i = 1; ?>
                	<?php $num = count($articles); ?>   
                    <?php foreach ($articles as $article) {
                		if($i%2==0) {
                			echo '<div class="boss_article-item last">';
                		} else {
                			echo '<div class="boss_article-item">';
                		}
               		$i++;
            	?>
                    <div class="article-name">
                        <h2><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></h2>                    
                    </div>
                    <div class="std">					
                        <div class="article-image"><a href="<?php echo $article['href']; ?>"><img src="<?php echo $article['thumb']; ?>" title="<?php echo $article['name']; ?>" alt="<?php echo $article['name']; ?>" /></a></div>
    					
    					<div class="time-stamp">
                            <?php $date = new DateTime($article['date_modified']);?>
                            <small><?php echo $date->format('l, M j, Y');?></small>
                        </div>
                        <div class="article-title"><p><?php  echo $article['title']; ?></p></div>
    					<div class="article-footer">
                            <span class="post-by"> Post by <span><?php echo $article['author']; ?></span></span>
                            <span class="separator">|</span>
        					<span class="comment-count"><span><?php echo $article['comment']; ?></span> <a href="<?php echo $article['href']; ?>">Comment(s)</a></span>                 
                        </div>
                    </div>
                    
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="pagination"><?php echo $pagination; ?></div>  
    <?php } else { ?>
      <div class="content"><?php echo $text_empty; ?></div>
    <?php }?>
  <?php echo $content_bottom; ?></div>
  
  <script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.article-grid').attr('class', 'article-list');
		
		$('.article-list > div').each(function(index, element) {
            html = '';
			html += '  <div class="article-name">' + $(element).find('.article-name').html() + '</div>';
					
			
			html += '<div class="std">';
            
			html += '  <div class="article-image">' + $(element).find('.article-image').html() + '</div>';
			html += '  <div class="time-stamp">' + $(element).find('.time-stamp').html() + '</div>';		
			html += '  <div class="article-title">' + $(element).find('.article-title').html() + '</div>';
			html += '  <div class="article-footer">' + $(element).find('.article-footer').html() + '</div>';
				
			html += '</div>';

						
			$(element).html(html);
		});	
			
		$('.display').html('<b><?php echo $text_display; ?></b><a class="no-active-gird" onclick="display(\'grid\');"><?php echo $text_grid; ?></a><span class="active-list"><?php echo $text_list; ?> </span>');
		
		$.cookie('display', 'list'); 
	} else {
		$('.article-list').attr('class', 'article-grid');
		
		$('.article-grid > div').each(function(index, element) {
			html = '';
			
			html += '<div class="article-image">' + $(element).find('.article-image').html() + '</div>';
			html += '<div class="article-name">' + $(element).find('.article-name').html() + '</div>';
            html += '  <div class="time-stamp">' + $(element).find('.time-stamp').html() + '</div>';
            html += '  <div class="article-title">' + $(element).find('.article-title').html() + '</div>';
            html += '  <div class="article-footer">' + $(element).find('.article-footer').html() + '</div>';
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display; ?></b><span class="active-gird"><?php echo $text_grid; ?></span><a class="no-active-list" onclick="display(\'list\');"><?php echo $text_list; ?></a>');
		
		$.cookie('display', 'grid');
	}
}
view = $.cookie('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script> 
<?php echo $footer; ?>