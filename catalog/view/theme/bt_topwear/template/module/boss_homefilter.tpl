<?php if(!empty($tabs)){ ?>
<?php if($use_tab){ ?>
<div id="boss_homefilter_tabs<?php echo $module; ?>" class="homefilter_tabs">
	<?php foreach ($tabs as $numTab => $tab) { ?>
	<a href="#homefiltertab-<?php echo $numTab; ?><?php echo $module; ?>" <?php if($use_scrolling_panel){ ?> onclick="updateCarouFredSelHomefilter(<?php echo $numTab; ?>, <?php echo $module; ?>);" <?php } ?> ><?php echo $tab['title']; ?></a>
	<?php } ?>
</div>
<?php } ?>

<?php foreach ($tabs as $numTab => $tab) { ?>
<div class="home_filter_content" id="homefiltertab-<?php echo $numTab; ?><?php echo $module; ?>">
  <div class="box">
	<div class="<?php echo $tab['color']; ?> box-heading" <?php echo ($use_tab ? 'style="display: none"' : '') ?>><?php echo $tab['title']; ?></div>
	<div class="box-content">
		<div class="list_carousel responsive" >
		<?php if(!empty($tab['products'])){ ?>
		<ul id="boss_home_filter_<?php echo $numTab; ?><?php echo $module; ?>" class="box-product">
			<?php foreach ($tab['products'] as $product) { ?>
			  <li>
				<?php if ($product['thumb']) { ?>
				<div class="hover_img">
				<div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>"/></a></div>
				<div class="filterbt">
				<a onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" class="button"><?php echo $button_cart; ?></a>
				</div>
				<?php } ?>
				<div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
				<?php if ($product['price']) { ?>
					<?php if ($product['special']) { ?>
					<div class="discount boss_label">
						<p>sale</p>
					</div>
				<?php }} ?>	
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
				<div class="rating"><img src="catalog/view/theme/<?php echo $template; ?>/image/stars-<?php echo $product['rating']; ?>.png" alt="<?php echo $product['reviews']; ?>" /></div>
				<?php } ?>
				</div>
			  </li>
			<?php } ?>
		</ul>
		<div class="clearfix"></div>
		<?php if ($use_scrolling_panel) { ?>
			<a id="prev_filter_<?php echo $numTab; ?><?php echo $module; ?>" class="prev" href="#"></a>
			<a id="next_filter_<?php echo $numTab; ?><?php echo $module; ?>" class="next" href="#"></a>
		<?php } ?>
		<?php } ?>
		</div>
	</div> <!-- end div box content -->
  </div>
</div>
<?php } ?>

<?php if ($use_scrolling_panel) { ?>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.touchSwipe.min.js"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	<?php foreach ($tabs as $numTab => $tab) { ?>
	$('#boss_home_filter_<?php echo $numTab; ?><?php echo $module; ?>').carouFredSel({
		auto: false,
		responsive: true,
		width: '100%',
		prev: '#prev_filter_<?php echo $numTab; ?><?php echo $module; ?>',
		next: '#next_filter_<?php echo $numTab; ?><?php echo $module; ?>',
		swipe: {
			onTouch : true
		},
		items: {
			width:235,
			height:350,
			visible: {
				min: 1,
				max: 6
			}
		},
		scroll: {
			direction : 'left',    //  The direction of the transition.
			duration  : 900   //  The duration of the transition.
		}
	});
	<?php } ?>
});
<?php if($use_tab){ ?>
	//update carousel cho truong hop tab > 767
	function updateCarouFredSelHomefilter(numTab, module){
		$("#boss_home_filter_"+numTab+module).trigger("destroy", true);
		$('.home_filter_content').hide();
		$('#homefiltertab-'+numTab+module).show();
		$("#boss_home_filter_"+numTab+module).carouFredSel({
			auto: false,
			responsive: true,
			width: '100%',
			prev: '#prev_filter_'+numTab+module,
			next: '#next_filter_'+numTab+module,
			swipe: {
			onTouch : true
			},
			items: {
				width:235,
				height:350,
				visible: {
					min: 1,
					max: 6
				}
			},
			scroll: {
				direction : 'left',    //  The direction of the transition.
				duration  : 900   //  The duration of the transition.
			}
		});
	}
<?php } ?>
//--></script>
<?php } ?>
<script type="text/javascript"><!--
$('.home_filter_content').on('click', 'div.box-heading', function() {
	if($(this).next().css('display') == 'none'){
		$(this).next().show();
		$(this).addClass('active');
	}else{
		$(this).next().hide();
		$(this).removeClass('active');
	}
});

$(document).ready(function() {
	boss_homehomefilter_resize();
});

$(window).resize(function() {
	boss_homehomefilter_resize();
});

function boss_homehomefilter_resize()	{
	<?php if($use_tab){ ?>
		if(getWidthBrowser() < 768){
			// destroy tab, hide tab, show heading, show content
			$('#boss_homefilter_tabs<?php echo $module; ?> a').tabs('destroy');
			$('#boss_homefilter_tabs<?php echo $module; ?>').hide();
			$('.home_filter_content').show();
			$('.home_filter_content .box-content').show();
			$('.home_filter_content .box-heading').show();
			$('.home_filter_content .box-heading').addClass('active');
		} else {
			//show div tab, hide div heading
			$('#boss_homefilter_tabs<?php echo $module; ?>').show();
			$('.home_filter_content .box-heading').hide();
			$('#boss_homefilter_tabs<?php echo $module; ?> a').tabs();
			var list = $('#boss_homefilter_tabs<?php echo $module; ?> a');
			list.each(function( index ) {
				if($(this).hasClass('selected')){
					$(this).click();
				}
			});
		}
	<?php } else { ?>
		$('.home_filter_content .box-content').show();
		if(getWidthBrowser() < 768){
			$('.home_filter_content .box-heading').addClass('active');
		}
		$('.home_filter_content div.box-heading').on('click', function(e) {
			if(getWidthBrowser() > 767){
				e.preventDefault();
				return false;
			}
		});
	<?php } ?>
}
//--></script>
<?php } ?>
