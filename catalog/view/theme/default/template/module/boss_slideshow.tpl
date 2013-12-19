<div class="boss_slide" style="width: <?php echo $width; ?>px; height: <?php echo $height; ?>px">
	<div class="fluid_container" style="width:100%">
		<div class="camera_wrap camera_emboss" id="camera_wrap_<?php echo $module; ?>" style="height:<?php echo $height; ?>px" >
			<?php foreach ($images as $image) { ?>
				<div data-src="<?php echo $image['image']; ?>"  data-link="<?php echo $image['link']; ?>">
					<?php if($image['description']){ ?>
					<div class="camera_caption fadeFromBottom">
						<?php echo $image['description']; ?>
					</div>
					<?php } ?>
				</div>
			<?php } ?>
		</div><!-- #camera_wrap_3 -->
	</div>
<?php if (file_exists('catalog/view/theme/bt_topwear/stylesheet/camera.css')) {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/camera.css" media="screen" />';
	} else {
		echo '<link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/camera.css" media="screen" />';
	}
?>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.mobile.customized.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.easing.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/camera.min.js"></script>
<?php
$Slide_value_effects = explode(',', $this->config->get('Slide_Effect'));
$effect = '';
if(in_array("",$Slide_value_effects)){
	$effect = "random";
}else {
	if(in_array("random",$Slide_value_effects)){
		$effect = "random";
	} else {
		foreach($Slide_value_effects as $Slide_value_effect){
			if($Slide_value_effect == 'simpleFade')
				$effect = $effect."simpleFade,";
			if($Slide_value_effect == 'curtain')
				$effect = $effect."curtainTopLeft,curtainTopRight,curtainBottomLeft,curtainBottomRight,curtainSliceLeft, curtainSliceRight, blindCurtainTopLeft, blindCurtainTopRight, blindCurtainBottomLeft, blindCurtainBottomRight, blindCurtainSliceBottom, blindCurtainSliceTop,";
			if($Slide_value_effect == 'mosaic')
				$effect = $effect."mosaic, mosaicReverse, mosaicRandom, mosaicSpiral, mosaicSpiralReverse,topLeftBottomRight, bottomRightTopLeft, bottomLeftTopRight, bottomLeftTopRight,";
			if($Slide_value_effect == 'stampede')
				$effect = $effect."stampede,";
			if($Slide_value_effect == 'scroll')
				$effect = $effect."scrollLeft, scrollRight, scrollHorz, scrollBottom, scrollTop";
		}
	}
}
?>
<script type="text/javascript">
	jQuery(function(){
		jQuery('#camera_wrap_<?php echo $module; ?>').camera({
			pagination: true,
			navigation: false,
			playPause: false,
			height: '51,14%',
			mobileAutoAdvance: true,
			thumbnails: false,
			fx:'<?php echo $effect; ?>',
			imagePath: 'catalog/view/theme/bt_topwear/image/',
			time: 2000
		});

	});
</script>
</div>