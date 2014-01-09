<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'cgd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'cg.sort_order') { ?>
                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                <?php } ?></td>                
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($manage_wies) { ?>
            <?php foreach ($manage_wies as $manage_wie) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($manage_wie['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $manage_wie['customer_group_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $manage_wie['customer_group_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $manage_wie['name']; ?></td>
              <td class="right"><?php echo $manage_wie['sort_order']; ?></td>
              <td class="right"><!--<?php foreach ($manage_wie['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?>-->[ <a onclick="viewRoomWieDetail(<?php echo $manage_wie['customer_group_id']?>);"><?php echo $text_view; ?></a> ]</td>
               <!-- <?php echo "<pre>" ?>
                <?php echo print_r($billing_wie)?>
                <?php echo "</pre>" ?>-->

                <?php if(isset($billing_wie[$manage_wie['customer_group_id']])) {?>
                <tr id="detail_wie_<?php echo $manage_wie['customer_group_id']?>" style="display:none;">
                	<td colspan="5">
                        <table class="tblWieDetail">
                        	<?php foreach($billing_wie[$manage_wie['customer_group_id']] as $key =>$month) { ?>
                            <tr id="detail_wie_month_<?php echo $key?>" class="header">
                                <td colspan="5"><?php echo $text_header.$key?></td>
                            </tr>
                           
                            <tr id="detail_wie_rows_<?php echo $key?>" style="display:none;">
                                <td>
                                	<table class="tblWieDetailRows">
                                        <tr class="header">
                                        	<td><?php echo $text_month?></td>
                                            <td><?php echo $text_title?></td>
                                            <td><?php echo $text_start_num?></td>
                                            <td><?php echo $text_end_num?></td>
                                            <td><?php echo $text_usage?></td>
                                            <td><?php echo $text_cost?></td>
                                        </tr>
                                        <?php foreach($month as $type => $bill) { ?>
                                        <tr class="body">
                                        	<td><?php echo $text_month.' '.$key?></td>
                                            <td><?php echo (($type == 'elec') ? $text_electric: $text_water)?></td>
                                            <td><?php echo $bill[0]['Start']?></td>
                                            <td><?php echo $bill[0]['End']?></td>
                                            <td><?php echo (int)$bill[0]['End'] - (int)$bill[0]['Start']?></td>
                                            <td>heheheh</td>
                                        </tr>
                                         <?php } ?>
                                       <!-- <tr>
                                            <td colspan="5">
                                                <table class="tblWieDetailLimit">
                                                    <tr class="header">
                                                        <td width="10%"><?php echo $text_limit?></td>
                                                        <td><?php echo $text_limit_text?></td>
                                                        <td><?php echo $text_price?></td>
                                                        <td><?php echo $text_total?></td>
                                                    </tr>
                                                    <tr class="body">
                                                        <td><?php echo $text_limit?></td>
                                                        <td><?php echo $text_limit_text?></td>
                                                        <td><?php echo $text_price?></td>
                                                        <td><?php echo $text_total?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>-->
                                    </table>
                                </td>
                            </tr>
                           
                            <?php } ?>
                        </table>
                        
                    </td>
                </tr>
            </tr>
            <?php } ?>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
	function viewRoomWieDetail(id) {
		$('tr[id^=\'detail_wie_' + id + '\']').slideToggle(500);
	}
	
	$('tr[id^=\'detail_wie_month_\']').click(function() {
		$('tr[id^=\'detail_wie_rows_\']').fadeOut(100);
		var trid = parseInt($(this).attr('id').replace('detail_wie_month_',''));
		$('tr[id=\'detail_wie_rows_' + trid + '\']').slideToggle(500);
	});
	
//--></script> 

<?php echo $footer; ?> 