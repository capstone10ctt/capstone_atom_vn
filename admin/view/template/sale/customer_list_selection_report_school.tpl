<?php echo $header;
$count_total=array();
$count_new_valid=array();
$count_resident_valid=array();
$count_new_invalid=array();
$count_resident_invalid=array();
foreach ($genders as $gender)
{
  $count_new_valid[$gender['gender_id']]=0;
$count_resident_valid[$gender['gender_id']]=0;
$count_new_invalid[$gender['gender_id']]=0;
$count_resident_invalid[$gender['gender_id']]=0;
foreach ($customers as $customer) {
  if($customer['gender']==$gender['gender_name'])
if($customer['resident'] == $text_resident)
  {
    if($customer['valid'] == $text_valid)
      $count_resident_valid[$gender['gender_id']]++;
    else
      $count_resident_invalid[$gender['gender_id']]++;
  }
  else
  {
    if($customer['valid'] == $text_valid)
      $count_new_valid[$gender['gender_id']]++;
    else
      $count_new_invalid[$gender['gender_id']]++;
  }
}
$count_total[$gender['gender_id']] = $count_resident_valid[$gender['gender_id']]+$count_resident_invalid[$gender['gender_id']]+$count_new_valid[$gender['gender_id']]+$count_new_invalid[$gender['gender_id']];
}
 ?>
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
      <div class="buttons">
      <!-- 
      /////////////////////// Modification//////////////////////
      // ID: 1051015        
      // Name: Luu Minh Tan           
      // Class: 10CTT
      // Date created: 22/12/2013
      // Description: Delete unnecessary func
      // Date modified: 2/1/2014
      //////////////////////////////////////////////////////////////
      -->
      <!-- start LMT -->
      <!-- 
      <a onclick="$('form').attr('action', '<?php echo $approve; ?>'); $('form').submit();" class="button"><?php echo $button_approve; ?></a>
      -->
      <!-- end LMT -->
      </div>
    </div>
    <div class="content">
    <div id="leftcol" style="float:left;width:300px;text-alignment:left">
    <?php echo $text_period; ?>
    <br />
    <select name="filter_period">
                  <option value=""></option>
                  <?php foreach ($periods as $period) { ?>
                  <?php if ((is_null($filter_period) && $period['is_apply'] == '1') || (!is_null($period) && $period['period_id'] == $filter_period)) { ?>
                  <option value="<?php echo $period['period_id']; ?>" selected="selected"><?php echo date('d/m/Y', strtotime($period['period_start'])).' - '.date('d/m/Y', strtotime($period['period_end'])) ; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $period['period_id']; ?>"><?php echo date('d/m/Y', strtotime($period['period_start'])).' - '.date('d/m/Y', strtotime($period['period_end'])) ; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select><br />
    <h2><?php echo $text_report; ?></h2>
      <a href="<?php echo $report_amount; ?>"><?php echo 'Số lượng tuyển sinh'; ?></a><br />
      <?php echo 'Trường'; ?><br />
      <a href="<?php echo $report_area; ?>"><?php echo 'Diện chính sách'; ?></a><br />
    </div>
    <div id="rightcol" style="margin-left:500px;width:500px;text-alignment:left">
        <table class="list">
          <thead>
            <tr>
              <!-- Add column Student field -->
              <td class="left"></td>
              <!-- end LMT -->
              <!-- Add column Student ID -->
              <?php foreach ($genders as $gender) {
              echo '<td class="left">'.$gender['gender_name'].'</td>';
              }?>
              <!-- end LMT -->
              <td class="left"><?php echo 'Tổng'; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td class="left"><?php echo 'Chỉ tiêu'; ?></td>
                <?php $total=0;
                foreach ($genders as $gender) {
                  echo '<td class="left">'.$count_total[$gender['gender_id']].'</td>';
                  $total+=$count_total[$gender['gender_id']];
                }?>
                <td class="left"><?php echo $total; ?></td>
            </tr>
            <tr>
                <td class="left"><?php echo 'Thực tế'; ?></td>
                <?php $total=0;
                foreach ($genders as $gender) {
                  echo '<td class="left">'.$count_new_valid[$gender['gender_id']].'</td>';
                  $total+=$count_new_valid[$gender['gender_id']];
                }?>
                <td class="left"><?php echo $total; ?></td>
            </tr>
            
          </tbody>
        </table>
      </form>
    </div>
      
      <div class="pagination" style="clear:both"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
/////////////////////// Modification//////////////////////
// ID: 1051015        
// Name: Luu Minh Tan           
// Class: 10CTT
// Date created: 25/12/2013
// Description: Add funct get list of university
// Date modified: 31/12/2013
//////////////////////////////////////////////////////////////
// start LMT 
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'dd-mm-yy'});
  $('select[name=\'filter_period\']').on('change', function (e) {
    
    var valueSelected = this.value;
    url = 'index.php?route=sale/customer_selection/report_school&token=<?php echo $token; ?>';
    if(valueSelected)
    {
      url +="&filter_period="+encodeURIComponent(valueSelected);
      location = url;
    }
});
});
//--></script>
<?php echo $footer; ?> 