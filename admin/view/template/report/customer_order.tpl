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
      <?php if(isset($this->request->get['filter_floor'])) echo '<h2>'.$floorname.'</h2>'; ?>
      <table class="list">
        <thead>
          <tr>
            <td class="center" rowspan="2"><?php if(isset($this->request->get['filter_floor'])) {echo $entry_room;} else echo $column_floor; ?></td>
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
          <?php if ($rooms) {
		   foreach ($rooms as $room) { ?>
          <tr>
            <td class="left"><?php echo $room['name']; ?></td>
            <td class="left"><?php echo number_format($room['wpay'],0); ?></td>
            <td class="left"><?php echo number_format($room['epay'],0); ?></td>
            <td class="left"><?php echo number_format($room['epay'] + $room['wpay'],0); ?></td>
            <td class="left"><?php echo number_format($room['wpaid'],0); ?></td>
            <td class="left"><?php echo number_format($room['epaid'],0); ?></td>
            <td class="left"><?php echo number_format(($room['wpaid'] + $room['epaid']),0); ?></td>
            <td class="left"><?php echo number_format((($room['epay'] + $room['wpay'])-($room['wpaid'] + $room['epaid'])),0); ?></td>
          </tr>
          <?php }} else if ($floors) {
          foreach ($floors as $floor) { ?>
          <tr>
            <td class="left"><?php echo $floor['name']; ?></td>
            <td class="left"><?php echo number_format($floor['wpay'],0); ?></td>
            <td class="left"><?php echo number_format($floor['epay'],0); ?></td>
            <td class="left"><?php echo number_format($floor['epay'] + $floor['wpay'],0); ?></td>
            <td class="left"><?php echo number_format($floor['wpaid'],0); ?></td>
            <td class="left"><?php echo number_format($floor['epaid'],0); ?></td>
            <td class="left"><?php echo number_format(($floor['wpaid'] + $floor['epaid']),0); ?></td>
            <td class="left"><?php echo number_format((($floor['epay'] + $floor['wpay'])-($floor['wpaid'] + $floor['epaid'])),0); ?></td>
          </tr>
          <?php }} else { ?>
          <tr>
            <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <table class="list">
      	<colgroup>
	       <col span="1" style="width: 20%;">
	       <col span="1" style="width: 10%;">
	       <col span="1" style="width: 30%;">
	       <col span="1" style="width: 10%;">
	       <col span="1" style="width: 30%;">
    	</colgroup>
        <thead>
         <tr>
            <td class="center" rowspan="2" width=""></td>
            <td class="center" colspan="2"><?php echo $column_water; ?></td>
            <td class="center" colspan="2"><?php echo $column_electric; ?></td>
          </tr>
          <tr>
            <td class="center"><?php echo $column_count; ?></td>
            <td class="center"><?php echo $column_roomdetail; ?></td>
            <td class="center"><?php echo $column_count; ?></td>
            <td class="center"><?php echo $column_roomdetail; ?></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="left"><?php echo $entry_ontime; ?></td>
            <td class="left"><?php echo $roomstat[0]['wcount']; ?></td>
            <td class="left"></td>
            <td class="left"><?php echo $roomstat[0]['ecount']; ?></td>
            <td class="left"></td>
          </tr>
          <tr>
            <td class="left"><?php echo $entry_late1; ?></td>
            <td class="left"><?php echo $roomstat[1]['wcount']; ?></td>
            <td class="left"><?php echo $roomstat[1]['wlist']; ?></td>
            <td class="left"><?php echo $roomstat[1]['ecount']; ?></td>
            <td class="left"><?php echo $roomstat[1]['elist']; ?></td>
          </tr>
          <tr>
            <td class="left"><?php echo $entry_late2; ?></td>
            <td class="left"><?php echo $roomstat[2]['wcount']; ?></td>
            <td class="left"><?php echo $roomstat[2]['wlist']; ?></td>
            <td class="left"><?php echo $roomstat[2]['ecount']; ?></td>
            <td class="left"><?php echo $roomstat[2]['elist']; ?></td>
          </tr>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript">
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
	
	var filter_floor = $('select[name=\'filter_floor\']').attr('value');
	
	if (filter_floor != 0) {
		url += '&filter_floor=' + encodeURIComponent(filter_floor);
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