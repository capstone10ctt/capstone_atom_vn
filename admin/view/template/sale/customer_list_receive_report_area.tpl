<?php echo $header;
$count_field = array();

foreach ($genders as $gender)
{
  $count_field[$gender['gender_id']] = array();
  $count_field[$gender['gender_id']]["0"]=0;
  foreach ($fields as $field) { 
  $count_field[$gender['gender_id']][$field['field_id']] = 0;
  }
foreach ($customers as $customer) {
  if($customer['gender']==$gender['gender_name'])
  {
    $count_field[$gender['gender_id']][$customer['field']]++;
  }
}
 
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
    <h2><?php echo $text_report; ?></h2>
      <a href="<?php echo $report_online; ?>"><?php echo $text_online_app; ?></a><br />
      <a href="<?php echo $report_paper; ?>"><?php echo $text_paper_app; ?></a><br />
      <a href="<?php echo $report_no_paper; ?>"><?php echo $text_no_paper_app; ?></a><br />
      <?php echo $text_area_app; ?><br />
    </div>
    <div id="rightcol" style="margin-left:500px;width:500px;text-alignment:left">
        <table class="list">
          <thead>
            <tr>
              
              <!--
              /////////////////////// Modification//////////////////////
              // ID: 1051015        
              // Name: Luu Minh Tan           
              // Class: 10CTT
              // Date created: 22/12/2013
              // Description: Add columns in view-table and sort function
              // Date modified: 2/1/2014
              ////////////////////////////////////////////////////////////// 
              -->
              <!-- start LMT -->
              <!-- Add column Student field -->
              <td class="left"></td>
              <!-- end LMT -->
              <!-- Add column Student ID -->
              <?php foreach ($genders as $gender) {
              echo '<td class="left">'.$gender['gender_name'].'</td>';
              }?>
              <!-- end LMT -->
              <td class="left"><?php echo $text_total; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr>
                <td class="left"><?php echo $text_unidentified_field; ?></td>
                <?php $total=0;
                foreach ($genders as $gender) {
                  echo '<td class="left">'.$count_field[$gender['gender_id']][0].'</td>';
                  $total+=$count_field[$gender['gender_id']][0];
                }?>
                <td class="left"><?php echo $total; ?></td>
            </tr>
            <?php foreach ($fields as $field) {?>
            <tr>
                <td class="left"><?php echo $field['field_name']; ?></td>
                <?php $total=0;
                foreach ($genders as $gender) {
                  echo '<td class="left">'.$count_field[$gender['gender_id']][$field['field_id']].'</td>';
                  $total+=$count_field[$gender['gender_id']][$field['field_id']];
                }?>
                <td class="left"><?php echo $total; ?></td>
            </tr>
            <?php } ?>
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
});
//--></script>
<?php echo $footer; ?> 