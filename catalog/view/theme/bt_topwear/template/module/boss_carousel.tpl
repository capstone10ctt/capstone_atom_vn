<div class="list_carousel list_carousel_footer responsive">

	<ul id="carousel<?php echo $module; ?>">
    <?php foreach ($banners as $banner) { ?>
    <li><div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></div></li>
    <?php } ?>
	<?php foreach ($banners as $banner) { ?>
    <li><div><a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" title="<?php echo $banner['title']; ?>" /></a></div></li>
    <?php } ?>
	</ul>
	<a id="prev_carousel_<?php echo $module; ?>" class="prev" href="#"></a>
	<a id="next_carousel_<?php echo $module; ?>" class="next" href="#"></a>

</div>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.touchSwipe.min.js"></script>
<script type="text/javascript"><!--
$('#carousel<?php echo $module; ?>').carouFredSel({
		auto: false,
		responsive: true,
		width: '100%',
		prev: '#prev_carousel_<?php echo $module; ?>',
		next: '#next_carousel_<?php echo $module; ?>',
		swipe: {
			onTouch : true
		},
		items: {
			width:180,
			height:103,
			visible: {
				min: 1,
				max: 7
			}
		},
		
		scroll: {
			direction : 'left',    //  The direction of the transition.
			duration  : 900   //  The duration of the transition.
		}
	});
//--></script>