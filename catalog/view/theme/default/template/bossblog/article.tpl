<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1 class="article-title-boss"><?php echo $heading_title; ?></h1> 
  <div class="boss_article-item boss_article-detail">
    <div class="article-title">
		<div class="date-post">
		<small class="time-stamp">
            <?php $date = new DateTime($date_modified);?>
            <?php echo $date->format('l, M j, Y');?>
        </small>
        <span class="separator">|</span>
        <span class="post-by"> Post by <span><?php echo $author; ?></span></span>
        <span class="separator">|</span>
		<span class="comment-count"><span><?php echo $comments; ?></span> comment(s)</span>
		</div>
        <p><?php echo $title;?></p>
        
    </div>
            
            <div class="article-content">
                <?php echo $content;?>
            </div>
            <div class="boss_article-action">
                    <?php if ($tags) { ?>
                      <div class="tags"><span><?php echo $text_tags; ?>: </span>
                      <ul>
                        <?php for ($i = 0; $i < count($tags); $i++) { ?>
                        <?php if ($i < (count($tags) - 1)) { ?>
                        <li class="item"><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
                        <?php } else { ?>
                        <li class="item"><a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a></li>
                        <?php } ?>
                        <?php } ?>
                      </ul>
                      </div>
                    <?php } ?>
                    <div class="article-share">
                            <span>Share this article</span>
                    <!-- Share This Post -->
                        <a href="http://www.facebook.com/sharer.php?u=<?php echo $href; ?>&title=<?php echo $name; ?>" target="_blank">
                                <img border="0" src="http://3.bp.blogspot.com/_vLeiVavkV_M/SnleIlLdGwI/AAAAAAAABd8/RfHnWIGGMEY/s200/facebook.png" alt="Post item information on Facebook" title="Post item information on Facebook" />
                        </a>

                        <a href="http://twitter.com/home?status=Share <?php echo $href; ?>" title="Click to send this Article to Twitter!" target="_blank">
                                <img border="0" src="http://www.cbc.ca/news/yourvoice/assets/images/yourvoice-twitter.png" alt="Add To Twiiter" title="Add To Twiiter" />
                        </a>

                        <a title="Add To Del.icio.us" target="_blank" href="http://del.icio.us/article?url=<?php echo $href; ?>&amp;title=<?php echo $name; ?>">
                                <img border="0" src="http://2.bp.blogspot.com/_vLeiVavkV_M/Snld35mPSDI/AAAAAAAABds/ccrOpOmP9Zk/s200/delicious.png" alt="Add To Del.icio.us" title="Add To Del.icio.us" />
                        </a>

                        <a title="Stumble This" target="_blank" href="http://www.stumbleupon.com/refer.php?url=<?php echo $href; ?>&amp;title=<?php echo $name; ?>">
                                <img border="0" src="http://2.bp.blogspot.com/_vLeiVavkV_M/SnleiulEMVI/AAAAAAAABeU/kO09nNTlQeo/s200/stumbleupon.png" alt="Stumble This" title="Stumble This" />
                        </a>

                        <a title="Digg This" target="_blank" href="http://digg.com/submit?phase=2&amp;url=<?php echo $href; ?>&amp;title=<?php echo $name; ?>">
                                <img border="0" src="http://3.bp.blogspot.com/_vLeiVavkV_M/Snld_x-wXoI/AAAAAAAABd0/cTsGU_Y-zQ8/s200/digg.png" alt="Digg This" title="Digg This" />
                        </a>

                        <a title="Add To Reddit" target="_blank" href="http://reddit.com/submit?url=<?php echo $href; ?>&amp;title=<?php echo $name; ?>">
                                <img border="0" src="http://3.bp.blogspot.com/_vLeiVavkV_M/SnleX1tMMtI/AAAAAAAABeM/gQSYdrmSc3k/s200/reddit.png" alt="Add To Reddit" title="Add To Reddit">
                        </a>

                        <a title="Add To Yahoo" target="_blank" href="http://myweb2.search.yahoo.com/myresults/bookmarklet?t=<?php echo $href; ?>&amp;title=<?php echo $name; ?>">
                                <img border="0" src="http://1.bp.blogspot.com/_vLeiVavkV_M/SnlexsGX2QI/AAAAAAAABes/ai6zvzZKCgw/s200/yahoo.png" alt="Add To Yahoo" title="Add To Yahoo">
                        </a>
                    <!-- End Share This Post-->
                    </div>
                </div>
            <div class="article-related">
                <h3 class="form-title"><?php echo $article_related; ?></h3>
                 <ul>
                   <?php foreach ($articles as $article) { ?> 
                       <li><a href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a></li>
                   <?php } ?> 
                 </ul>
            </div>
			
			<div id="productRelated">
			<h3 class="form-title"><?php echo $text_product_related ?></h3>
				<div class="box-product">
                        <?php $j = 1; ?>
                    	<?php $num = count($products); ?>   
                        <?php foreach ($products as $product) {  
                    		if($j%4==0) {
                    			echo '<div class="relProduct last">';
                    		} else {
                    			echo '<div class="relProduct">';
                    		} $j++; ?>                        
    						<?php if ($product['thumb']) { ?>
                                <div class="image">
                                    <a title="<?php echo $product['name']; ?>" href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a>
                                </div>
                            <?php } ?>
    						<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
    						<?php if ($product['price']) { ?>
                                <div class="price">
                                  <?php if (!$product['special']) { ?>
                                  <?php echo $product['price']; ?>
                                  <?php } else { ?>
                                  <span class="price-old"><?php echo $product['price']; ?></span> <span class="price-new"><?php echo $product['special']; ?></span>
                                  <?php } ?>
                                </div>
                            <?php } ?>
                            <?php if ($product['rating']) { ?>
                                <div class="rating"><img src="catalog/view/theme/default/image/bossblog/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
                            <?php } ?>
    						<div class="cart"><a class="button button-boss" onclick="addToCart('<?php echo $product['product_id']; ?>');"><span><?php echo $button_cart; ?></span></a></div>
    					</div>
                    <?php } ?>
					
				</div>
			</div>
			
			
                
                <?php if ($allow_comment!=0) {?>
                    <?php if ($comment_status==1||$allow_comment==1) {?>
            <div class="comments">
                
				<div id="article-comments">
                   </div> 
                <div class="form-comment-container">
                    <span id="new">
                    	<h3><?php echo $text_comment; ?> </h3>
                    </span>       
                    <div id="0_comment_box" class="form-comment">
                    	  <?php if(!$login){?>
                    		  <div class="field" id="username">
                    			  <label class="required" for="name"><?php echo $text_username; ?><em>*</em></label>
                    			  <div class="input-box">
                    				  <input type="text" class="input-text required-entry" value="" title="Name" id="name" name="username">
                    			  </div>
                    		  </div>
                    
                    		  <div class="field" id="email">
                    			  <label class="required" for="email"><?php echo $text_email; ?><em>*</em></label>
                    			  <div class="input-box">
                    				  <input type="text" class="input-text required-entry validate-email" value="" title="Email" id="email" name="email">
                    			  </div>
                    		  </div>
                    	  <?php } else{?>
                                <input type="hidden" class="input-text required-entry" value="<?php echo $username; ?>" title="Name" id="name" name="username">
                                <input type="hidden" class="input-text required-entry validate-email" value="<?php echo $email; ?>" title="Email" id="email" name="email">
                          <?php } ?>
                    	  <div class="input-box">
                    		  <label class="required" for="comment"><?php echo $entry_comment; ?><em>*</em></label>
                    		  <textarea rows="2" cols="10" class="required-entry input-text" style="width:540px;height:200px" title="Comment" id="comment" name="comment_content"></textarea>
                    	  </div>
                    	  
                    	  <?php if($capcha){?>
                          <div class="captcha">
                    	   <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
                           <input type="text" name="captcha" value="" />
                    	   <label class="required-1 " for="recaptcha"><?php echo $text_required?><em>*</em></label>
                    	  </div>
                          <?php }?>
              	          <div>
                            <div class="left"><a id="button-comment" class="button button-boss"><span><?php echo $button_continue; ?></span></a></div>
                          </div>
                    	  </div>
            	   </div>
                   
             </div>
             <?php } } ?>        
        </div>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
$('#article-comments .pagination a').live('click', function() {
	$('#article-comments').fadeOut('slow');
		
	$('#article-comments').load(this.href);
	
	$('#article-comments').fadeIn('slow');
	
	return false;
});			

$('#article-comments').load('index.php?route=bossblog/article/comment&blog_article_id=<?php echo $blog_article_id; ?>');

$('#button-comment').bind('click', function() {
	$.ajax({
		url: 'index.php?route=bossblog/article/write&blog_article_id=<?php echo $blog_article_id; ?>&need_approval=<?php echo $need_approval; ?>&approval_status=<?php echo $approval_status; ?>',
		type: 'post',
		dataType: 'json',
		data: 'username=' + encodeURIComponent($('input[name=\'username\']').val()) + '&comment_content=' + encodeURIComponent($('textarea[name=\'comment_content\']').val()) + '&email=' + encodeURIComponent($('input[name=\'email\']').val()) + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-comment').attr('disabled', true);
			$('#new').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-comment').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(data) {
			if (data['error']) {
				$('#new').after('<div class="warning">' + data['error'] + '</div>');
			}
			
			if (data['success']) {
				$('#new').after('<div class="success">' + data['success'] + '</div>');
				$('#article-comments').load('index.php?route=bossblog/article/comment&blog_article_id=<?php echo $blog_article_id; ?>');				
				$('input[name=\'username\']').val('');
				$('textarea[name=\'comment_content\']').val('');
				$('input[name=\'email\']').val('');
                $('input[name=\'captcha\']').val('');
			}
		}
	});
});
//--></script> 
<?php echo $footer; ?>