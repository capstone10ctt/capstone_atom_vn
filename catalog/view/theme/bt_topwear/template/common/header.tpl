<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<head>
<meta charset="UTF-8" />
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<meta content="width=device-width, initial-scale=1, maximum-scale=1" name="viewport">
<?php if ($keywords) { ?>
<meta name="keywords" content="<?php echo $keywords; ?>" />
<?php } ?>
<?php if ($icon) { ?>
<link href="<?php echo $icon; ?>" rel="icon" />
<?php } ?>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/stylesheet.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/boss_menu.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/1200.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/boss_add_cart.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/jquery.selectbox.css" />
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/unsemantic-grid-responsive-tablet.css" />
<?php if ($this->config->get('b_General_Respon')) { ?>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/responsive.css" />
<?php } ?>
<?php foreach ($styles as $style) { ?>
<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="catalog/view/javascript/bossthemes/getwidthbrowser.js"></script>
<script type="text/javascript" src="catalog/view/javascript/common.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/bossthemes.js"></script>
<script type="text/javascript" src="catalog/view/javascript/bossthemes/notify.js"></script>	
<script type="text/javascript" src="catalog/view/javascript/bossthemes/jquery.selectbox-0.2.js"></script>	
<?php foreach ($scripts as $script) { ?>
<script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php } ?>
<!--[if IE 8]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/ie8.css" />
<![endif]-->
<!--[if IE 9]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/ie9.css" />
<![endif]-->
<!--[if IE 7]> 
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/ie7.css" />
<![endif]-->
<!--[if lt IE 7]>
<link rel="stylesheet" type="text/css" href="catalog/view/theme/bt_topwear/stylesheet/ie6.css" />
<script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
<script type="text/javascript">
DD_belatedPNG.fix('#logo img');
</script>
<![endif]-->
<!--[if !IE]><!--><script>  
if (/*@cc_on!@*/false) {  
    document.documentElement.className+=' ie10';  
}  
</script><!--<![endif]-->

<?php if ($stores) { ?>
<script type="text/javascript"><!--
$(document).ready(function() {
<?php foreach ($stores as $store) { ?>
$('body').prepend('<iframe src="<?php echo $store; ?>" style="display: none;"></iframe>');
<?php } ?>
});
//--></script>
<?php } ?>

<?php /********************THEME COLOR SETTINGS******************/ ?>
<?php include "catalog/view/theme/bt_topwear/template/bossthemes/Boss_color_setting.php";?>

<?php /******************THEME FONTS SETTINGS*********************/ ?>
<?php include "catalog/view/theme/bt_topwear/template/bossthemes/Boss_font_setting.php"; ?>

<?php echo $google_analytics; ?>
</head>
<body>
<?php
$b_Mode_CSS = $this->config->get('b_Mode_CSS');
if(!isset($b_Mode_CSS)){
	$b_Mode_CSS ="wide";
}
?>
<div id="container" class="<?php echo $b_Mode_CSS; ?>">

<div id="header">
<div class="container_24">	
<div class="grid_24 omega alpha">
  <div class="top_header">
  <div id="welcome">
    <?php if (!$logged) { ?>
    <?php echo $text_welcome; ?>
    <?php } else { ?>
    <?php echo $text_logged; ?>
    <?php } ?>
  </div>
  <!--<div class="links"><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a><a href="<?php echo $wishlist; ?>" id="wishlist-total"><?php echo $text_wishlist; ?></a><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></div>-->
  </div>
  <div class="bottom_header">
  <?php if ($logo) { ?>
  <div id="logo"><a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a></div>
  <?php } ?>
  
  <?php echo $language; ?>
  <!--<?php echo $cart; ?>
   <?php echo $currency; ?>
  
  <div id="search">
    <div class="button-search" title="<?php echo $text_search; ?>"></div>
    <input type="text" name="search" placeholder="<?php echo $text_search; ?>" value="<?php echo $search; ?>" />
  </div>-->
  
  </div>
</div>
</div>
</div>
<div class="boss_menu">	
<div class="container_24">		
	<?php if ($this->config->get('b_General_Menu')) { ?>	
	<?php if(isset($boss_megamenu)){echo $boss_megamenu; } ?>
	<?php }  if ($this->config->get('b_General_Menu')=='0') { ?>
	<?php if ($categories) { ?>
		<div id="menu" class="hide-on-mobile">
		  <ul>
			<?php foreach ($categories as $category) { ?>
			<li><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
			  <?php if ($category['children']) { ?>
			  <div>
			  <div>
				<?php for ($i = 0; $i < count($category['children']);) { ?>
				<ul>
				  <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
				  <?php for (; $i < $j; $i++) { ?>
				  <?php if (isset($category['children'][$i])) { ?>
				  <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
				  <?php } ?>
				  <?php } ?>
				</ul>
				<?php } ?>
			  </div>
			  </div>
			  <?php } ?>
			</li>
			<?php } ?>
		  </ul>
		</div>
	<?php } ?>
	<?php } ?>
	<div id="megamenu-responsive" class="hide-on-desktop hide-on-tablet" >
		<ul id="megamenu-responsive-root">
			<li class="menu-toggle"><p></p>Navigation</li>
			<li class="root">
				<ul>
				<?php foreach ($categories as $category) { ?>
					<li <?php if ($category['children']) echo 'class="parent"'; ?>><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
					  <?php if ($category['children']) { ?>
					
						<?php for ($i = 0; $i < count($category['children']);) { ?>
						<ul>
						  <?php $j = $i + ceil(count($category['children']) / $category['column']); ?>
						  <?php for (; $i < $j; $i++) { ?>
						  <?php if (isset($category['children'][$i])) { ?>
						  <li><a href="<?php echo $category['children'][$i]['href']; ?>"><?php echo $category['children'][$i]['name']; ?></a></li>
						  <?php } ?>
						  <?php } ?>
						</ul>
						<?php } ?>
					 
					  <?php } ?>
					</li>
				<?php } ?>
				<li><a href="index.php?route=bossblog/bossblog">Blog</a></li>
				</ul>
			</li>
		</ul>
	</div>

	<script type="text/javascript">

		/*Pc responsive*/
			
			$('document').ready(function(){
				$('#megamenu-responsive-root li.parent').prepend('<p>+</p>');
				
				$('.menu-toggle').click(function(){
					$('.root').toggleClass('open');
				});
				
				$('#megamenu-responsive-root li.parent > p').click(function(){

					if ($(this).text() == '+'){
						$(this).parent('li').children('ul').slideDown(300);
						$(this).text('-');
					}else{
						$(this).parent('li').children('ul').slideUp(300);
						$(this).text('+');
					}  
					
				});
			});
		
		/*$('document').ready(function(){
				iconClickIpad();			
			});*/
	</script>
</div>
</div>
<?php 
if(isset($boss_editorthemes)){
	echo $boss_editorthemes;
} ?>
<div class="container_24">
<div id="notification"></div>
