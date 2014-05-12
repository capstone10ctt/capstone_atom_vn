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
      <a onclick="$('form').attr('action', '<?php echo $approve; ?>'); $('form').submit();" class="button"><?php echo $text_approve; ?></a><a onclick="$('form').attr('action', '<?php echo $unapprove; ?>'); $('form').submit();" class="button"><?php echo $text_not_approve; ?></a>
      <a href="<?php echo $report; ?>" class="button"><?php echo $text_report; ?></a></div>
      </div>

    </div>
    <div class="content">
    <div id="leftcol" style="float:left;width:200px;text-alignment:left">
      <div style="margin-bottom:5px;font-size:15px;font-weight:bold;"><?php echo $text_search; ?></div>
         <input type="text" id="student_id_input" />
         <input type="button" value="<?php echo $text_do_search; ?>" onclick="searchStudentByMSSV()" style="width:70px;"/>
         <!--<input type="button" value="<?php echo $text_cancel; ?>" style="width:70px;"/>-->
        
        <div style="margin-top:20px;margin-bottom:5px;font-size:15px;font-weight:bold;"><?php echo $text_report; ?></div>
        <div style="margin-bottom:5px;"><?php echo $text_received; ?> <?php echo $total_received.'/'.$total_online;?></div>
        <div style="margin-bottom:5px"><?php echo $text_male; ?><?php echo ': '.$total_received_male;?></div>
    	<div style="margin-bottom:5px"><?php echo $text_female; ?><?php echo ': '.$total_received_female;?></div>
        
        <div id="block_info"></div> 
    </div>
    <div id="rightcol" style="margin-left:200px;text-alignment:left">
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
              <!-- Add column Student field -->
              <td class="left"><?php if ($sort == 'field') { ?>
                <a href="<?php echo $sort_field; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_field; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_field; ?>"><?php echo $column_field; ?></a>
                <?php } ?></td>
              <!-- end LMT -->
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
                <!-- Add column gender -->
              <td class="left"><?php if ($sort == 'gender') { ?>
                <a href="<?php echo $sort_gender; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_gender; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_gender; ?>"><?php echo $column_gender; ?></a>
                <?php } ?></td>
              <!--  Add column telephone -->
              <td class="left"><?php if ($sort == 'telephone') { ?>
                <a href="<?php echo $sort_telephone; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_telephone; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_telephone; ?>"><?php echo $column_telephone; ?></a>
                <?php } ?></td>
                <!-- Add comlumn approve -->
                <td class="left"><?php if ($sort == 'c.resident') { ?>
                <a href="<?php echo $sort_resident; ?>" class="<?php echo strtolower($order); ?>"><?php echo $text_resident; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_resident; ?>"><?php echo $text_resident; ?></a>
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
              <td><select name="filter_field">
                  <option value=""></option>
                  <?php foreach ($fields as $field) { ?>
                  <?php if ($field['field_id'] == $filter_field) { ?>
                  <option value="<?php echo $field['field_id']; ?>" selected="selected"><?php echo $field['field_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $field['field_id']; ?>"><?php echo $field['field_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td><input type="text" name="filter_id" value="<?php echo $filter_id ?>" /></td>
              <!-- end LMT -->
              <td><input type="text" name="filter_name" value="<?php echo $filter_name; ?>" /></td>
              <!-- start LMT -->
             
              <!-- add filter gender --> 
              <td><select name="filter_gender">
                  <option value=""></option>
                  <?php foreach ($genders as $gender) { ?>
                  <?php if ($gender['gender_id'] == $filter_gender) { ?>
                  <option value="<?php echo $gender['gender_id']; ?>" selected="selected"><?php echo $gender['gender_name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $gender['gender_id']; ?>"><?php echo $gender['gender_name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </td>
           
              <td><input type="text" name="filter_telephone" value="<?php echo $filter_telephone; ?>" /></td>

              <td><select name="filter_resident">
                  <option value=""></option>
                  <?php if ($filter_resident) { ?>
                  <option value="1" selected="selected"><?php echo $text_resident; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_resident; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_resident) && !$filter_vresident) { ?>
                  <option value="0" selected="selected"><?php echo $text_not_resident; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_not_resident; ?></option>
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
                <input type="checkbox" name="selected[]" value="<?php echo $customer['student_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer['student_id']; ?>" />
                <?php } ?></td>
                <!-- start LMT -->
                <td class="left"><?php echo $customer['field']; ?></td>
                <td class="left"><?php echo $customer['student_id']; ?></td>
                <td class="left"><?php echo $customer['name']; ?></td>
                <td class="left"><?php echo $customer['gender']; ?></td>
                <td class="left"><?php echo $customer['telephone']; ?></td>
                <td class="left"><?php echo $customer['resident']; ?></td>
                
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
    </div>
      
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>

<!--start vlmn modification-->
<div id="studentinfo-form-back" class="news-form-back"></div>
<div id="studentinfo-form" class="studentinfo-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header_student ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="editWieToggle(false);">-->
        <a onclick="popStudentInfo(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
    	<img id="student_portrait" src="../image/no_image.jpg" alt=""/>
    	<p style="margin-top:20px;" id="student_id">MSSV: 1051025</p>
       <p id="student_name">Họ và tên: Võ Lý Minh Nhân</p>
       <p id="student_field">Diện:</p>
       <span id="student_gender">Giới tính: Nam</span>
       <span id="student_dob">Ngày sinh: 16/03/1992</span>
        <span id="student_ethnic">Dân tộc: Bình thuận</span>
        <span id="student_email">Email: Bình thuận</span>
        <span id="student_address1">Địa chi thường trú: Bình thuận</span>
        <span id="student_address2">Địa chỉ tạm trú: Bình thuận</span>
       <textarea rows="10" cols="94"></textarea>
       <div class="buttons">
       <a id="confirmPreview" onclick="confirmStudent();" class="button" /><?php echo $text_confirm ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="previewWieToggle(false);" class="button"/><?php echo $text_exit; ?></a></div>
    </div>
    
    </div>
</div>

<div id="studentinfo2-form-back" class="news-form-back"></div>
<div id="studentinfo2-form" class="studentinfo-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header_student ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="editWieToggle(false);">-->
        <a onclick="popStudentInfo2(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
    	<img src="../image/no_image.jpg" alt=""/>
    	<p style="margin-top:20px;">MSSV: 1051025</p>
       <p>Họ và tên: Võ Lý Minh Nhân</p>
       <div class="buttons">
       <a id="confirmPreview" onclick="checkpaid();" class="button" /><?php echo $text_confirm ?></a></div>
    
    </div>
</div>
<!--end vlmn modification-->


<script type="text/javascript"><!--
   // popStudentInfo(true);
var mssv = '';
function searchStudentByMSSV() {
    mssv = $("#student_id_input").val();
    if(mssv == '') {
        return;
    }

    loadingForm(true);
    $.ajax({
        url: 'index.php?route=sale/customer_receive/getStudentInfo&token=<?php echo $token; ?>',
        type: 'post',
        data: 'student_id=' + mssv,
        dataType: 'json',
        success: function(json) {
            loadingForm(false);
            //console.log(json);
            if(json['student']) {
                var student = json['student'];
                var address = ((student['address'][0]) ? student['address'][0] : null)

                $("#student_portrait").attr("src", ((student['portrait']) ? ""  : "../image/no-image.jpg"))
                $("#student_id").html("MSSV: " + mssv);
                $("#student_name").html("Họ tên: " + student['firstname'] + '' + student['lastname']);
                $("#student_field").html("Diện: " + student['field']);
                $("#student_gender").html("Giới tính: " + ((student['gender'] == 1 ) ? 'Nam' : 'Nữ'));
                $("#student_dob").html("Ngày sinh: " + student['date_of_birth']);
                $("#student_ethnic").html("Dân tộc: " + student['ethnic']);
                $("#student_email").html("Email: " + student['email']);
                $("#student_address1").html("Địa chỉ thường trú: " + ((address) ? address['sonha1'] + " " + address['duong1'] + " - Phường: " + address['phuongxa1'] + " - Quận: " + address['quanhuyen1']  + " - Thành phố: " + address['thanhpho1'] : ""));
                $("#student_address2").html("Địa chỉ tạm trú: " + ((address) ? address['sonha2'] + " " + address['duong2'] + " - Phường: " + address['phuongxa2'] + " - Quận: " + address['quanhuyen2']  + " - Thành phố: " + address['thanhpho2'] : ""));
               //call popups tudent
                popStudentInfo(true);
            }
        },
        error : function(error) {
            loadingForm(false);
            alert("Không tìm thấy sinh viên này!")
            console.log(error);
        }
    });
}
function confirmStudent() {
    if(mssv == "") {
        return;
    }

    $.ajax({
        url: 'index.php?route=sale/customer_receive/confirmStudent&token=<?php echo $token; ?>',
        type: 'post',
        data: 'student_id=' + mssv,
        dataType: 'json',
        success: function(json) {
            loadingForm(false);
            //console.log(json);
            if(json['success']) {
                location.reload();
            }
        },
        error : function(error) {
            loadingForm(false);
            alert("Có lỗi, xin thử lại sau!")
            console.log(error);
        }
    });
}
function popStudentInfo(show) {
	//toggle show
	if(show)
	{
		//show box
		var left = ($(window).width() - $('#studentinfo-form').width()) / 2;
		var top = ($(window).height() - $('#studentinfo-form').height()) / 2;
		$('#studentinfo-form').css('left',left + 'px');
		$('#studentinfo-form').css('top',top + 'px');
		$('#studentinfo-form-back').fadeIn(400);
		$('#studentinfo-form').fadeIn(400);
	}
	else
	{
		$('#studentinfo-form-back').fadeOut(400);
		$('#studentinfo-form').fadeOut(400);
	}
}

function popStudentInfo2(show) {
	//toggle show
	if(show)
	{
		//show box
		var left = ($(window).width() - $('#studentinfo2-form').width()) / 2;
		var top = ($(window).height() - $('#studentinfo2-form').height()) / 2;
		$('#studentinfo2-form').css('left',left + 'px');
		$('#studentinfo2-form').css('top',top + 'px');
		$('#studentinfo2-form-back').fadeIn(400);
		$('#studentinfo2-form').fadeIn(400);
	}
	else
	{
		$('#studentinfo2-form-back').fadeOut(400);
		$('#studentinfo2-form').fadeOut(400);
	}
}

var card_code = '';
$("body").bind("keyup", function(e){
	e.preventDefault();
	//console.log(String.fromCharCode(e.which));  
	if(e.keyCode != 13) {
		card_code += String.fromCharCode(e.which);
	}
	else {
		// && card_code.match(/^\d*[0-9](\.\d*[0-9])?$/)
		if(card_code.length >= 10) {
			var card_code_ori = card_code.substr(card_code.length - 10, 10);
			//alert(card_code_ori);
			//alert(allDigits(card_code_ori));
			card_code = '';
			if($('#editwiepreview-form').css("display") == 'none' && allDigits(card_code_ori)) {
				previewElecWaterCard(card_code_ori);
			}
			else if($('#editwiepreview-form').css("display") != 'none' && allDigits(card_code_ori)){
				checkpaid();
			}
			//console.log(card_code_ori);
			
		}
	}
});
function allDigits(str) {
	return /^\d*$/.test(str); // consists of only digits from start to end
}
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
	url = 'index.php?route=sale/customer_approval&token=<?php echo $token; ?>';
	
var filter_id = $('input[name=\'filter_id\']').attr('value');
  
  if (filter_id ) {
    url += '&filter_id=' + encodeURIComponent(filter_id);
  }

	var filter_name = $('input[name=\'filter_name\']').attr('value');
	
	if (filter_name ) {
		url += '&filter_name=' + encodeURIComponent(filter_name);
	}

  var filter_telephone = $('input[name=\'filter_telephone\']').attr('value');
  
  if (filter_telephone) {
    url += '&filter_telephone=' + encodeURIComponent(filter_telephone);
  }

  var filter_gender = $('select[name=\'filter_gender\']').attr('value');
  
  if (filter_gender) {
    url += '&filter_gender=' + encodeURIComponent(filter_gender);
  }

  var filter_resident= $('select[name=\'filter_resident\']').attr('value');
  
  if (filter_resident) {
    url += '&filter_resident=' + encodeURIComponent(filter_resident);
  }
   var filter_field = $('select[name=\'filter_field\']').attr('value');
  
  if (filter_field) {
    url += '&filter_field=' + encodeURIComponent(filter_field);
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