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
    	<?php if(isset($this->request->get['filter_floor'])) echo '<h1>'.$floor_name.'</h1>'; ?>
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="15" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="15" /></td>
            <td><?php echo $entry_room; ?>
            <select name="filter_floor" style="margin-bottom:10px;width:135px">
            <option value="0"><?php echo $text_all; ?></option>
    <?php 
    $floorname = '';
    foreach ($floorlist as $fl)  {
        echo '<option value="'.$fl['floor_id'].'" ';
        if(isset($this->request->get['filter_floor']) && $this->request->get['filter_floor']==$fl['floor_id']){
         echo 'selected';
         $floorname=$fl['floor_name'];
        }
        echo '>'.$fl['floor_name'].'</option>';
    }?>
    </select></td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class='list'>
        <thead>
          <tr>
            <td class="center"><?php echo $column_room; ?></td>
            <td class="center"><?php echo $column_water; ?></td>
            <td class="center"><?php echo $column_electric; ?></td>
            <td class="center"><?php echo $column_total_money; ?></td>
            <td class="center"><?php echo $column_total_money_paid; ?></td>
            <td class="center"><?php echo $column_total_money_remain; ?></td>
            <td class="center"><?php echo $charged_date; ?></td>
          </tr>
        </thead>
        <tbody>
        <?php $totalPay_w = 0; $totalPay_e = 0; $totalPay_sum = 0; $totalPaid_sum = 0; $totalRemain = 0;?>
          <?php if (isset($rooms)) {
          foreach ($rooms as $room) { 
      			$totalPay_w += (int)$room['wpay'];
              	$totalPay_e += (int)$room['epay'];
              	$totalPay_sum += (int)$room['wpay'] + (int)$room['epay'];
              	$totalPaid_sum += (int)$room['wpaid'] + (int)$room['epaid'];
              	$totalRemain += (int)$room['epay']+$room['wpay']-$room['epaid']-$room['wpaid'];

          	?>
          <tr>
            <td class="left"><?php echo $room['name']; ?></td>
            <td class="left"><?php echo number_format($room['wpay'],0); ?></td>
            <td class="left"><?php echo number_format($room['epay'],0); ?></td>
            <td class="left"><?php echo number_format($room['epay']+$room['wpay'] ,0); ?></td>
            <td class="left"><?php echo number_format($room['epaid']+$room['wpaid'] ,0); ?></td>
            <td class="left"><?php echo number_format($room['epay']+$room['wpay']-$room['epaid']-$room['wpaid'] ,0); ?></td>
            <td class="left"><?php echo date("d/m/Y   H:i:s", strtotime($room['charged_date']))?></td>
          </tr>
          <?php }}?>

          <tr>
            <td class="left"><strong><?php echo $total_sum; ?></strong></td>
            <td class="left"><strong><?php echo number_format($totalPay_w,0); ?></strong></td>
            <td class="left"><strong><?php echo number_format($totalPay_e,0); ?></strong></td>
            <td class="left"><strong><?php echo number_format($totalPay_sum,0); ?></strong></td>
            <td class="left"><strong><?php echo number_format($totalPaid_sum,0); ?></strong></td>
            <td class="left"><strong><?php echo number_format($totalRemain,0); ?></strong></td>
            <td class="left"><strong>--</strong></td>
          </tr>

        </tbody>
      </table>


      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/customer_order2&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
	
  var filter_floor = $('select[name=\'filter_floor\']').attr('value');
  
  if (filter_floor != 0) {
    url += '&filter_floor=' + encodeURIComponent(filter_floor);
  } 

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datetimepicker({dateFormat: 'yy-mm-dd'});
	
	$('#date-end').datetimepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>