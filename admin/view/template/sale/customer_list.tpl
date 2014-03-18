<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?
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
      <a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
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
              <!-- Add column Student ID -->
              <td class="left"><?php if ($sort == 'student_id') { ?>
                <a href="<?php echo $sort_student_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_student_id; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_student_id; ?>"><?php echo $column_student_id; ?></a>
                <?php } ?></td>
              <!-- end LMT -->
              <td class="left"><?php if ($sort == 'name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <!-- start LMT -->
                <!-- Add column Date of birth -->
              <td class="left"><?php if ($sort == 'date_of_birth') { ?>
                <a href="<?php echo $sort_date_of_birth; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_of_birth; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_of_birth; ?>"><?php echo $column_date_of_birth; ?></a>
                <?php } ?></td>
               <!-- Add column university -->
              <td class="left"><?php if ($sort == 'university') { ?>
                <a href="<?php echo $sort_university; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_university; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_university; ?>"><?php echo $column_university; ?></a>
                <?php } ?></td>
                <!-- Add column Faculty -->
              <td class="left"><?php if ($sort == 'faculty') { ?>
                <a href="<?php echo $sort_faculty; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_faculty; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_faculty; ?>"><?php echo $column_faculty; ?></a>
                <?php } ?></td>
              <!-- Add column Floor -->
              <td class="left"><?php if ($sort == 'floor') { ?>
                <a href="<?php echo $sort_floor; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_floor; ?></a>
                <?php } else { ?>
                 <a href="<?php echo $sort_floor; ?>"><?php echo $column_floor; ?></a>
                <?php } ?></td>
              <!-- end LMT -->
              
              <td class="left"><?php if ($sort == 'customer_group') { ?>
                <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                <?php } ?></td>
                <!-- start LMT -->
               <!-- Add column Bed -->
               <td class="left"><?php if ($sort == 'bed') { ?>
                <a href="<?php echo $sort_bed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_bed; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_bed; ?>"><?php echo $column_bed; ?></a>
                <?php } ?></td>
                 <!-- Add column Ethnic -->
                <td class="left"><?php if ($sort == 'ethnic') { ?>
                <a href="<?php echo $sort_ethnic; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_ethnic; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_ethnic; ?>"><?php echo $column_ethnic; ?></a>
                <?php } ?></td>
                <!-- Add column Address 1 -->
                <td class="left"><?php if ($sort == 'address_1') { ?>
                <a href="<?php echo $sort_address_1; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_address_1; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_address_1; ?>"><?php echo $column_address_1; ?></a>
                <?php } ?></td>
              
              <!-- Delete
              <td class="left"><?php if ($sort == 'c.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>

              <td class="left"><?php if ($sort == 'c.approved') { ?>
                <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?></a>
                <?php } ?></td>
                -->
                <!-- end LMT -->
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td></td>
              <!--
              /////////////////////// Modification//////////////////////
              // ID: 1051015        
              // Name: Luu Minh Tan           
              // Class: 10CTT
              // Date created: 25/12/2013
              // Description: Add filter functions
              // Date modified: 2/1/2014
              ////////////////////////////////////////////////////////////// 
              -->
              <!-- start LMT -->
              <td></td>
              <!-- end LMT -->
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <!-- start LMT -->
              <!-- add filter date of birth --> 
              <td><input type="text" name="filter_date_of_birth" value="<?php echo $filter_date_of_birth; ?>" size="12" id="date" /></td>
              <!-- add filter university --> 
              <td><select name="filter_university">
                <option value=""><?php echo $text_select; ?></option>
                <?php foreach ($universities as $university) { ?>
                <?php if ($university['category_id'] == $filter_university) { ?>
                <option value="<?php echo $university['category_id']; ?>" selected="selected"><?php echo $university['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $university['category_id']; ?>"><?php echo $university['name']; ?></option>
                <?php } ?>
                <?php } ?>
              </select>
              </td>
              <!-- add filter faculty --> 
              
              <td><select name="filter_faculty">
                    </select>
                    </td>
           
              <td><select name="filter_floor_id">
                  <option value=""></option>
                  <?php foreach ($floors as $floor) { ?>
                  <?php if ($floor['floor_id'] == $filter_floor_id) { ?>
                  <option value="<?php echo $floor['floor_id']; ?>" selected="selected"><?php echo $floor['floor_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $floor['floor_id']; ?>"><?php echo $floor['floor_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>

                <td><select name="filter_customer_group_id">
                  <option value=""></option>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
                 <!-- end LMT -->
                <!-- start LMT -->
                <!-- add filter bed -->
                 <!--<td><input type="text" name="filter_bed" value="<?php echo $filter_bed; ?>" /></td>-->
                  <td><select name="filter_bed">
                  <option value=""></option>
                  <?php foreach ($beds as $bed) { ?>
                  <?php if ($bed['bed_id'] == $filter_bed) { ?>
                  <option value="<?php echo $bed['bed_id']; ?>" selected="selected"><?php echo $bed['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $bed['bed_id']; ?>"><?php echo $bed['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
                 <!-- add filter ethnic -->
                 <td><input type="text" name="filter_ethnic" value="<?php echo $filter_ethnic; ?>" /></td>
                 <!-- add filter address_1 -->
                 <td><select name="filter_address_1">
                  <option value=""><?php echo $text_select; ?></option>
                  <?php foreach ($regions as $region) { ?>
                  <?php if ($region['zone_id'] == $filter_address_1) { ?>
                  <option value="<?php echo $region['zone_id']; ?>" selected="selected"><?php echo $region['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $region['zone_id']; ?>"><?php echo $region['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>

                <!-- Delete
              <td><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <td><select name="filter_approved">
                  <option value="*"></option>
                  <?php if ($filter_approved) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_approved) && !$filter_approved) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>
                -->
                <!-- end LMT -->
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($customers) { ?>
            <?php foreach ($customers as $customer) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($customer['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['customer_id']; ?>" />
                <?php } ?></td>
                <!-- start LMT -->
                <td class="left"><?php echo $customer['student_id']; ?></td>
                <td class="left"><?php echo $customer['name']; ?></td>
                <td class="left"><?php echo $customer['date_of_birth']; ?></td>
                <td class="left"><?php echo $customer['university']; ?></td>
                <td class="left"><?php echo $customer['faculty']; ?></td>
                <td class="left"><?php echo $customer['floor']; ?></td>
                <td class="left"><?php echo $customer['customer_group']; ?></td>
                <td class="left"><?php echo $customer['bed']; ?></td>
                <td class="left"><?php echo $customer['ethnic']; ?></td>
                <td class="left"><?php echo $customer['address_1']; ?></td>
                <!-- end LMT -->
              <td class="right"><?php foreach ($customer['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
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
           
function filter() {
	url = 'index.php?route=sale/customer&token=<?php echo $token; ?>';
	
	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name ) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

	// start LMT
  var filter_date_of_birth = $('input[name=\'filter_date_of_birth\']').attr('value');
  
  if (filter_date_of_birth ) {
    url += '&filter_date_of_birth=' + encodeURIComponent(filter_date_of_birth); 
  } 

  var filter_university = $('select[name=\'filter_university\']').attr('value');
  
  if (filter_university != '' ) {
    url += '&filter_university=' + encodeURIComponent(filter_university);
  }

  var filter_faculty = $('select[name=\'filter_faculty\']').attr('value');
  
  if (filter_faculty != '') {
    url += '&filter_faculty=' + encodeURIComponent(filter_faculty);
  }
  
  var filter_bed = $('select[name=\'filter_bed\']').attr('value');
  
  if (filter_bed != '') {
    url += '&filter_bed=' + encodeURIComponent(filter_bed); 
  } 
  var filter_ethnic = $('input[name=\'filter_ethnic\']').attr('value');
  
  if (filter_ethnic ) {
    url += '&filter_ethnic=' + encodeURIComponent(filter_ethnic); 
  } 
  var filter_address_1 = $('select[name=\'filter_address_1\']').attr('value');
  
  if (filter_address_1 != '') {
    url += '&filter_address_1=' + encodeURIComponent(filter_address_1); 
  } 

  var filter_floor_id = $('select[name=\'filter_floor_id\']').attr('value');
  
  if (filter_floor_id != '') {
    url += '&filter_floor_id=' + encodeURIComponent(filter_floor_id);
  }
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').attr('value');
	
	if (filter_customer_group_id != '') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}	
  // end LMT
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'dd-mm-yy'});
});
//--></script>
<?php echo $footer; ?> 