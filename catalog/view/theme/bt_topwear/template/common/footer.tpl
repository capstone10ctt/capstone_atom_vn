</div>
<div id="container_footer">
<div id="footer">
<div class="container_24">
<div class="footer-column">
  <?php /******************FOOTER SETTINGS*********************/ ?>
<?php include "catalog/view/theme/bt_topwear/template/bossthemes/Boss_footer_setting.php"; ?>
  <?php if ($informations) { ?>
  <div class="column">
	<div class="column_content">
		<h3><?php echo $text_information; ?></h3>
		<ul>
		  <?php foreach ($informations as $information) { ?>
		  <li><a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a></li>
		  <?php } ?>
		</ul>
	</div>
  </div>
  <?php } ?>
   <!-- <div class="column">
	<div class="column_content">
		<h3><?php echo $text_service; ?></h3>
		<ul>
		  <li><a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a></li>
		  <li><a href="<?php echo $return; ?>"><?php echo $text_return; ?></a></li>
		  <li><a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a></li>
		</ul>
	</div>
  </div>
<div class="column">
	<div class="column_content">
		<h3><?php echo $text_extra; ?></h3>
		<ul>
		  <li><a href="<?php echo $manufacturer; ?>"><?php echo $text_manufacturer; ?></a></li>
		  <li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
		  <li><a href="<?php echo $affiliate; ?>"><?php echo $text_affiliate; ?></a></li>
		  <li><a href="<?php echo $special; ?>"><?php echo $text_special; ?></a></li>
		</ul>
	</div>
  </div>
  <div class="column">
	<div class="column_content">
		<h3><?php echo $text_account; ?></h3>
		<ul>
		  <li><a href="<?php echo $account; ?>"><?php echo $text_account; ?></a></li>
		  <li><a href="<?php echo $order; ?>"><?php echo $text_order; ?></a></li>
		  <li><a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a></li>
		  <li><a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a></li>
		</ul>
	</div>
  </div>-->
 </div>

</div>
<div id="powered"><div class="container_24"><div class="powered-1"><?php echo $powered; ?></div></div></div>
</div>
</div>
<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->

<!--
OpenCart is open source software and you are free to remove the powered by OpenCart if you want, but its generally accepted practise to make a small donation.
Please donate via PayPal to donate@opencart.com
//-->
</div>
</body></html>