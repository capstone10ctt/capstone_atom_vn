<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
            <td class="center" rowspan="2"><?php echo $column_floor; ?></td>
            <td class="center" colspan="2"><?php echo $column_paymoney; ?></td>
            <td class="center" rowspan="2"><?php echo $column_total; ?></td>
            <td class="center" colspan="2"><?php echo $column_receivedmoney; ?></td>
            <td class="center" rowspan="2"><?php echo $column_total; ?></td>
            <td class="center" rowspan="2"><?php echo $column_diff; ?></td>
          </tr>
          <tr>
            <td class="center"><?php echo $column_water; ?></td>
            <td class="center"><?php echo $column_electric; ?></td>
            <td class="center"><?php echo $column_water; ?></td>
            <td class="center"><?php echo $column_electric; ?></td>
          </tr>
        </thead>
        <tbody>
          <?php if ($floors) { ?>
          <?php foreach ($floors as $floor) { ?>
          <tr>
            <td class="left"><?php echo $floor['name']; ?></td>
            <td class="left"><?php echo $floor['wpay']; ?></td>
            <td class="left"><?php echo $floor['epay']; ?></td>
            <td class="left"><?php echo $floor['epay'] + $floor['wpay']; ?></td>
            <td class="left"><?php echo $floor['wpaid']; ?></td>
            <td class="left"><?php echo $floor['epaid']; ?></td>
            <td class="left"><?php echo $floor['wpaid'] + $floor['epaid']; ?></td>
            <td class="left"><?php echo ($floor['epay'] + $floor['wpay'])-($floor['wpaid'] + $floor['epaid']); ?></td>
          </tr>
          <?php } ?>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/customer_order&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>