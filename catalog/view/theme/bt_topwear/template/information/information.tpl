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
<div class="infomation_fr">
  <h1><?php echo $heading_title; ?></h1>
  <?php echo $description; ?>
  <div class="buttons">
    <div class="left"><a href="<?php echo $continue; ?>" class="button cst"><span class="button_fr"><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php echo $content_bottom; ?></div></div>
<?php echo $footer; ?>