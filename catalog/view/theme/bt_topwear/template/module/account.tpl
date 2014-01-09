<?php 
    if(isset($_GET['route']))
    {
		$b_login = 0; $b_register = 0;$b_forgotten = 0; $b_account = 0;	$b_edit = 0;	$b_password = 0;	$b_wishlist = 0;	$b_order = 0; $b_download = 0;		$b_return = 0; 	 $b_transaction = 0;  $b_newsletter = 0;  $b_logout = 0;  
		
		switch($_GET['route']){
			case 'account/login':		$b_login = 1;			break;		
			case 'account/register':	$b_register = 1;		break;		
			case 'account/forgotten':	$b_forgotten = 1;		break;		
			case 'account/account':		$b_account = 1;			break;		
			case 'account/edit':		$b_edit = 1;			break;		
			case 'account/password':	$b_password = 1;		break;		
			case 'account/wishlist':	$b_wishlist = 1;		break;		
			case 'account/order':		$b_order = 1;			break;		
			case 'account/download':	$b_download = 1;		break;		
			case 'account/return':		$b_return = 1;			break;		
			case 'account/transaction':	$b_transaction = 1;		break;		
			case 'account/newsletter':	$b_newsletter = 1;		break;
		}
    }  
?>
<div class="box account">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <ul>
      <?php if (!$logged) { ?>
      <li <?Php echo ($b_login==1 ? 'class="active"' : ''); ?>><a <?Php echo ($b_login==1 ? 'class="active"' : ''); ?> href="<?php echo $login; ?>"><span><?php echo $text_login; ?></span></a> / <a  <?Php echo ($b_register==1 ? 'class="active"' : ''); ?> href="<?php echo $register; ?>"><span><?php echo $text_register; ?></span></a></li>
      <li <?Php echo ($b_forgotten==1 ? 'class="active"' : ''); ?>><a  <?Php echo ($b_forgotten==1 ? 'class="active"' : ''); ?> href="<?php echo $forgotten; ?>"><span><?php echo $text_forgotten; ?></span></a></li>
      <?php } ?>
      <li <?Php echo ($b_account==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_account==1 ? 'class="active"' : ''); ?> href="<?php echo $account; ?>"><span><?php echo $text_account; ?></span></a></li>
      <?php if ($logged) { ?>
      <li  <?Php echo ($b_edit==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_edit==1 ? 'class="active"' : ''); ?> href="<?php echo $edit; ?>"><span><?php echo $text_edit; ?></span></a></li>
      <li <?Php echo ($b_password==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_password==1 ? 'class="active"' : ''); ?> href="<?php echo $password; ?>"><span><?php echo $text_password; ?></span></a></li>
      <?php } ?>
        <li><a href="<?php echo $address; ?>"><?php echo $text_address; ?></a></li>
      <li <?Php echo ($b_wishlist==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_wishlist==1 ? 'class="active"' : ''); ?> href="<?php echo $wishlist; ?>"><span><?php echo $text_wishlist; ?></span></a></li>
      <li <?Php echo ($b_order==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_order==1 ? 'class="active"' : ''); ?> href="<?php echo $order; ?>"><span><?php echo $text_order; ?></span></a></li>
      <li <?Php echo ($b_download==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_download==1 ? 'class="active"' : ''); ?> href="<?php echo $download; ?>"><span><?php echo $text_download; ?></span></a></li>
      <li <?Php echo ($b_return==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_return==1 ? 'class="active"' : ''); ?> href="<?php echo $return; ?>"><span><?php echo $text_return; ?></span></a></li>
      <li <?Php echo ($b_transaction==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_transaction==1 ? 'class="active"' : ''); ?> href="<?php echo $transaction; ?>"><span><?php echo $text_transaction; ?></span></a></li>
      <li <?Php echo ($b_newsletter==1 ? 'class="active"' : ''); ?> ><a  <?Php echo ($b_newsletter==1 ? 'class="active"' : ''); ?> href="<?php echo $newsletter; ?>"><span><?php echo $text_newsletter; ?></span></a></li>
      <?php if ($logged) { ?>
      <li><a href="<?php echo $logout; ?>"><span><?php echo $text_logout; ?></span></a></li>
      <?php } ?>
    </ul>
  </div>
</div>
