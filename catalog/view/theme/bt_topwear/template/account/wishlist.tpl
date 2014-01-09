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

<?php //echo $column_left; ?><?php //echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
 <div class="wishlist-fr">
  <h1 class="h1margin"><?php echo $heading_title; ?></h1>
  <?php if ($success) { ?>
<div class="success"><?php echo $success; ?><img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>
<?php } ?>
  <?php if ($products) { ?>
 
 <div class="wishlist-info">
    <table>
      <thead>
        <tr>
          <td class="image"><?php echo $column_name; ?></td>
          <td class="name"></td>
          <td class="model"><?php echo $column_model; ?></td>
		  <td class="unitprice"><?php echo $column_price; ?></td>
          <td class="stock"><?php echo $column_stock; ?></td>
          <td class="action"></td>
          <td class="remove"></td>
        </tr>
      </thead>
      <?php foreach ($products as $count => $product) { ?>
      <tbody <?php if($count==0){echo 'class="first"';} ?>id="wishlist-row<?php echo $product['product_id']; ?>">
        <tr>
          <td class="image"><?php if ($product['thumb']) { ?>
            <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
            <?php } ?></td>
          <td class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
          <td class="model"><?php echo $product['model']; ?></td>
		  <td class="unitprice"><?php if ($product['price']) { ?>
            <div class="price">
              <?php if (!$product['special']) { ?>
              <?php echo $product['price']; ?>
              <?php } else { ?>
              <s><?php echo $product['price']; ?></s> <b><?php echo $product['special']; ?></b>
              <?php } ?>
            </div>
            <?php } ?></td>
          <td class="stock"><?php echo $product['stock']; ?></td>
          <td class="action<?php echo ($product==end($products) ? ' last' : ''); ?>"><input type="button" class="button" onclick="boss_addToCart('<?php echo $product['product_id']; ?>');" value="<?php echo $button_cart; ?>"></td>
          <td class="remove<?php echo ($product==end($products) ? ' last' : ''); ?>"><a href="<?php echo $product['remove']; ?>"><img src="catalog/view/theme/bt_topwear/image/remove.png" alt="<?php echo $button_remove; ?>" title="<?php echo $button_remove; ?>" /></a></td>
        </tr>
      </tbody>
      <?php } ?>
    </table>
  </div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button cst"><span class="button_fr"><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button cst"><span class="button_fr"><?php echo $button_continue; ?></span></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div></div>
<?php echo $footer; ?>