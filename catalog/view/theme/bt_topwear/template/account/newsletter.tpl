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
 <div class="newsletter_fr">
  <h1><?php echo $heading_title; ?></h1>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td><?php if ($newsletter) { ?>
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <span><?php echo $text_yes; ?></span>&nbsp;
            <input type="radio" name="newsletter" value="0" />
            <span><?php echo $text_no; ?></span>
            <?php } else { ?>
            <input type="radio" name="newsletter" value="1" />
            <span><?php echo $text_yes; ?></span>&nbsp;
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <span><?php echo $text_no; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <div class="buttons">
      <div class="left"><a href="<?php echo $back; ?>" class="button cst"><span class="button_fr"><?php echo $button_back; ?></span></a></div>
      <div class="right"><span class="button_fr_ip"><input type="submit" value="<?php echo $button_continue; ?>" class="button cst" /></span></div>
    </div>
  </form>
  <?php echo $content_bottom; ?></div></div>
<?php echo $footer; ?>