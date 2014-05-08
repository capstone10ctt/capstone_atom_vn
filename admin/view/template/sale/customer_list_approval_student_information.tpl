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
      <a onclick="$('form').attr('action', '<?php echo $verify; ?>'); $('form').submit();" class="button"><?php echo $text_verify; ?></a>
      <a href="<?php echo $report; ?>" class="button"><?php echo $text_report; ?></a></div>
    </div>
    <div class="content">
    <div id="leftcol" style="float:left;width:300px;text-alignment:left">
    </div>
    <div id="rightcol" style="margin-left:300px;text-alignment:left">
      <?php if(isset($student['student_id']))
      { ?>
      <h3><?php echo $column_student_id.': '.$student['student_id']; ?></h3>
      <h3><?php echo $text_fullname.': '.$student['firstname'].' '.$student['lastname']; ?></h3>
      <?php echo $column_field; ?>: 
      <select name="filter_field">
                  <option value=""></option>
                  <?php foreach ($fields as $field) { ?>
                  <?php if ($student['field_id'] == $filter_field) { ?>
                  <option value="<?php echo $field['field_id']; ?>" selected="selected"><?php echo $field['field_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $field['field_id']; ?>"><?php echo $field['field_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
                <br />
       <?php
        echo $text_type.':  ';
       if($student['resident'] == 1)
        echo $text_resident;
      else
        echo $text_new;
        echo '<br />';
         echo $entry_gender. ': ';
      if($student['gender'] == 0)
        echo $entry_female;
      else
        echo $entry_male;
        echo '<br />';
      $dateTime = datetime::createfromformat('Y-d-m',$student['date_of_birth']);
      
      echo $column_date_of_birth.': ';
      echo $dateTime->format('d/m/Y');

      ?>
      <br />
      <form action="" method="post" enctype="multipart/form-data" id="form">
      <input type="hidden" name="selected[]" value="<?php echo $student['customer_id']; ?>"/>
      <a onclick="$('form').attr('action', '<?php echo $verify; ?>'); $('form').submit();" class="button"><?php echo $text_verify; ?></a>
      </form>

    <?php } ?>
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
var nkid = '<?php echo $NKUniversity ?>';
$('select[name=\'filter_university\']').bind('change', function() {
  $.ajax({
    url: 'index.php?route=sale/customer/childcategory&token=<?php echo $token; ?>&filter_university=' + $('select[name=\'filter_university\']').val(),
    dataType: 'json',
    /* start LMT
    beforeSend: function() {
      $('select[name=\'filter_university\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
    },
    end LMT */
    complete: function() {
      $('.wait').remove();
    },      
    success: function(json) {
      
      html = '<option value=""><?php echo $text_select; ?></option>';
      if (json) {
        for (i = 0; i < json.length; i++) {
              html += '<option value="' + json[i]['faculty_id'] + '"';
            
          if (json[i]['faculty_id'] == '<?php echo $filter_faculty; ?>') {
                html += ' selected="selected"';
            }
  
            html += '>' + json[i]['name'] + '</option>';
        }
      } else {
        html += '<option value="" selected="selected"><?php echo $text_none; ?></option>';
      }
      
      $('select[name=\'filter_faculty\']').html(html);
      
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

$('select[name=\'filter_university\']').trigger('change');
  // end LMT

/////////////////////// Modification//////////////////////
// ID: 1051015        
// Name: Luu Minh Tan           
// Class: 10CTT
// Date created: 25/12/2013
// Description: Add filter functions
// Date modified: 2/1/2014
////////////////////////////////////////////////////////////// 
           
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'dd-mm-yy'});
});
//--></script>
<?php echo $footer; ?> 