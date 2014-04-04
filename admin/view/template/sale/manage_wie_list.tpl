<?php echo $header; ?>
<script type="text/javascript" src="view/javascript/jquery.printElement.min.js"></script>
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
      <?php if($this->user->getUserGroup() == ADMIN_IDX) { ?>
      <div class="buttons">
      <!--<input id="temp_id" value="123456789" /><a onclick="previewElecWaterCard();" class="button">test card</a>-->
      <a onclick="deadlineForm(true);" class="button"><?php echo $text_set_deadline; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="newsToggle(true);" class="button"><?php echo $text_add; ?></a><a href="<?php echo $import_data; ?>" class="button"><?php echo $text_import_from_file; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="mailForm(true);" class="button"><?php echo $text_mail; ?></a><a onclick="sendMailToMinistry();" class="button"><?php echo $text_mail_monthly; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="printForm(true);" class="button"><?php echo $text_print; ?></a><!--<a onclick="location.reload();" class="button"><?php echo $text_refresh; ?></a>--></div>
      <?php }?>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      	<table class="tbTinyRows">
                <tr>
                	<td><?php echo $text_floor?></td>
                     <td><select id="sel_floor_wie" onchange="filterRoomByFloorView()">
                     <option value="-1"><?php echo $text_all; ?></option>
                        <?php foreach($floors_input as $floor) { ?> 
                        	<?php if($floor['floor_id'] == $filter_floor) {?>
                            	<option value="<?php echo $floor['floor_id'] ?>" selected="selected"><?php echo $floor['floor_name']; ?></option>
                            <?php } else { ?>
                            	<option value="<?php echo $floor['floor_id'] ?>" ><?php echo $floor['floor_name']; ?></option>
                            <?php }?>
                        <?php } ?>
                    </select></td>

                </tr>
                <tr>
                	<td><?php echo $text_room?></td>
                     <td><select id="sel_room_wie" onchange="filterRoomByFloorView()">
                     	<option value="-1"><?php echo $text_all; ?></option>
                        <?php foreach($rooms_input as $room) { ?> 
                        	<?php if($room['customer_group_id'] == $filter_room) {?>
                            	<option value="<?php echo $room['customer_group_id'] ?>" selected="selected"><?php echo $room['name']; ?></option>
                            <?php } else { ?>
                            	<option value="<?php echo $room['customer_group_id'] ?>" ><?php echo $room['name']; ?></option>
                            <?php }?>
                        <?php } ?>
                    </select></td>
                </tr>
            </table>
            
            <?php if($this->user->getUserGroup() == ADMIN_IDX) { ?>
            <table style="float:left;width:800px; margin-left:40px;">
                <tr>
                <td>eMail Phòng công tác sinh viên: </td>
                <td><input id="ministryMail" name="ministryMail" value="<?php echo $ministryMail ?>" type="text"/></td>
                <td><input type="submit" value="<?php echo $text_save ?>"/></td>
                <td>
                	<div class="colorboxOuter" style="margin-bottom:0px;">
                   <div class="colorboxWrapper">
                    <div class='colorbox'><div class="red"></div><p class="text"><?php echo $text_red_not_charged; ?></p></div>
                    <div class='colorbox'><div class="orange"></div><p class="text" style="line-height:13px;"><?php echo $text_red_stop_service; ?></p></div>
                   </div>
               </div>
                </td>  
                </tr>
            </table>
            <?php } ?>
            
            <table class="viewWie">
              <tbody id="viewWie">
                
              </tbody>
            </table>
      </form>
      <!--<div class="pagination"><?php echo $pagination; ?></div>-->
    </div>
  </div>
</div>
<div id="news-form-back" class="news-form-back"></div>
<div id="news-form" class="news-form" style="max-height:400px;overflow-y:auto;">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="newsToggle(false);">-->
        <a onclick="newsToggle(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
    	<div class="colorboxOuter">
           <div class="colorboxWrapper">
            <div class='colorbox'><div class="red"></div><p class="text"><?php echo $text_red; ?></p></div>
            <!--<div class='colorbox'><div class="green"></div><p class="text"><?php echo $text_green; ?></p></div>-->
           </div>
       </div>
        	<table class="tbTinyRows">
                <tr>
                	<td><?php echo $text_floor?></td>
                     <td><select id="sel_floor" onchange="filterRoomByFloorInput()">
                     <option value="-1"><?php echo $text_all; ?></option>
                        <?php foreach($floors_input as $floor) { ?> 
                            <option value="<?php echo $floor['floor_id'] ?>" ><?php echo $floor['floor_name']; ?></option>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                	<td><?php echo $text_room?></td>
                     <td><select id="sel_room" onchange="filterRoomByRoomIDInput()">
                     	<option value="-1"><?php echo $text_all; ?></option>
                        <?php foreach($rooms_input as $room) { ?> 
                            <option value="<?php echo $room['customer_group_id'] ?>" ><?php echo $room['name']; ?></option>
                        <?php } ?>
                    </select></td>
                </tr>
            </table>
       <table class="tblWieInputRows">
        <tr class="header colorwhite">
            <td><?php echo $text_title?></td>
            <td><?php echo $text_electric_start?></td>
            <td><?php echo $text_start_num_electric?></td>
          	<td><?php echo $text_water_start?></td>
            <td><?php echo $text_start_num_water?></td>
        </tr>
        <tbody id="room_list">
        
        </tbody>
       </table>
    <a onclick="inputHistory();" class="button"/><?php echo $text_submit ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="newsToggle(false);" class="button"/><?php echo $text_cancel ?></a>
    </div>
</div>
<div id="printDiv"></div>

<div id="editwie-form-back" class="news-form-back"></div>
<div id="editwie-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="editWieToggle(false);">-->
        <a onclick="editWieToggle(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody id="tbEditWie">
          	
          </tbody>
        </table>
    <a onclick="saveEditWie();" class="button"/><?php echo $text_submit ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="editWieToggle(false);" class="button"/><?php echo $text_cancel ?></a>
    </div>
</div>
<style type="text/css">
	.student_info {
		position:relative;
		width:300px;
		margin:0px auto 0px;
		border:solid 1px #CCC;
		display:none;
	}
	.student_info div{
		position:relative;
		width:100%;
	}
	.student_info div p{
		position:relative;
		display:inline-block;
		width:35%;
		margin:7px 0px 0px 10px;
		text-align:left;
	}
	.student_info div span{
		position:relative;
		display:inline-block;
		margin-left:5px;
		width:60%;
		text-align:left;
	}
</style>
<div id="editwiepreview-form-back" class="news-form-back"></div>
<div id="editwiepreview-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_preview_header ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="editWieToggle(false);">-->
        <a onclick="previewWieToggle(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
    	<div id="student_info" class="student_info">
        	<div><p id="txtHeaderMSSV"></p><span id="txtMSSV"></span></div>
            <div><p id="txtHeaderSName"></p><span id="txtSName"></span></div>
            <div style="margin-bottom:7px;"><p id="txtHeaderRoomLead"></p><span id="txtRoomLead"></span></div>
        </div>
       <div id="tbpreviewWie" align="center">
       </div>
       <a id="confirmPreview" onclick="checkpaid();" class="button" style="display:none;margin:0px auto 0px;"/><?php echo $text_confirm ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="previewWieToggle(false);" class="button"/><?php echo $text_exit; ?></a>
    </div>
    
    </div>
</div>

<div id="loading-form-back" class="loading-form-back"></div>
<div id="loading-form" class="loading-form">
    <div class="fbody">
    	<img src="view/image/loading.gif" alt=""/>
       <p><?php echo $text_loading; ?></p>
    </div>
    </div>
</div>


<div id="mail-form-back" class="mail-form-back"></div>
<div id="mail-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_mail_header ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="mailForm(false);">-->
        <a onclick="mailForm(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody>
            <fieldset id="mail_elements" style="border:0;">
    <input id="ra_all_mail" type="radio" name="mail" checked value="1">Gửi tất cả các phòng<br/>

    <input id="ra_partial_mail" type="radio" name="mail" value="2">Tùy chọn<br/>
    <br/>
    <select id="mailFloor" onchange="filterFloorMailInput();">
    <option value="-1"><?php echo $text_select; ?></option>
                        <?php foreach($floors_input as $floor) { ?> 
                            <option value="<?php echo $floor['floor_id'] ?>" ><?php echo $floor['floor_name']; ?></option>
                        <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Phòng được chọn</label>
    <br/><br/>
    <div class="selectBlock">
    <div>
        <select id="leftValues" size="8" multiple>
        </select>
    </div>
    <div>
        <input type="button" id="btnLeft" value="&lt;" /><br/>
        <input type="button" id="btnLeftAll" value="&lt;&lt;" /><br/>
        <input type="button" id="btnRight" value="&gt;" /><br/>
        <input type="button" id="btnRightAll" value="&gt;&gt;" /><br/>
    </div>
    <div>
        <select id="rightValues" size="8" multiple>
        </select>

    </div>
  </div>
  <br/>
  <div class="bottomButton">
    <a onclick="sendMailToEachRoom();" class="button"/><?php echo $text_mail; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="mailForm(false);" class="button"/><?php echo $text_cancel ?></a>
  </div>
  </fieldset>
          </tbody>
        </table>
    </div>
</div>

<div id="print-form-back" class="mail-form-back"></div>
<div id="print-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_print_header ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="mailForm(false);">-->
        <a onclick="printForm(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody>
            <fieldset id="print_elements" style="border:0;">
    <input id="ra_all_print" type="radio" name="print" checked value="1">In tất cả các phòng<br/>

    <input id="ra_partial_print" type="radio" name="print" value="2">Tùy chọn<br/>
    <br/>
    <select id="printFloor" onchange="filterFloorPrintInput();">
    <option value="-1"><?php echo $text_select; ?></option>
                        <?php foreach($floors_input as $floor) { ?> 
                            <option value="<?php echo $floor['floor_id'] ?>" ><?php echo $floor['floor_name']; ?></option>
                        <?php } ?>
    </select>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label>Phòng được chọn</label>
    <br/><br/>
    <div class="selectBlock">
    <div>
        <select id="leftValuesPrint" size="8" multiple>
        </select>
    </div>
    <div>
        <input type="button" id="btnLeftPrint" value="&lt;" /><br/>
        <input type="button" id="btnLeftAllPrint" value="&lt;&lt;" /><br/>
        <input type="button" id="btnRightPrint" value="&gt;" /><br/>
        <input type="button" id="btnRightAllPrint" value="&gt;&gt;" /><br/>
    </div>
    <div>
        <select id="rightValuesPrint" size="8" multiple>
        </select>

    </div>
  </div>
  <br/>
  <div class="bottomButton">
    <a onclick="printEachRoom();" class="button"/><?php echo $text_print; ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="printForm(false);" class="button"/><?php echo $text_cancel ?></a>
  </div>
  </fieldset>
          </tbody>
        </table>
    </div>
</div>

<div id="confirmbox-form" class="confirmbox-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_warning ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="confirmBoxToggle(false);">-->
        <a onclick="confirmBoxToggle(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody>
          	<tr><td><p><?php echo $text_reason; ?></p></td></tr>
            <tr><td><textarea id="logContent" cols="80" rows="20" ></textarea></td></tr>
          </tbody>
        </table>
    <a id="confirmBoxSubmit" class="button"/><?php echo $text_submit ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="confirmBoxToggle(false);" class="button"/><?php echo $text_cancel ?></a>
    </div>
</div>

<div id="deadline-form-back" class="news-form-back"></div>
<div id="deadline-form" class="confirmbox-form" style="z-index:9995!important;">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_set_deadline ?></p>
        <!--<img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="confirmBoxToggle(false);">-->
        <a onclick="deadlineForm(false);" style="float:right;margin:8px 10px 0px 0px;font-weight:bold;color:#fff;text-decoration:none;">Thoát</a>
    </div>
    <div class="fbody">
    	<div style="float:left;width:100%;height:40px;" align="left">
        	<p style="float:left;margin:0px 0px 0px 20px;padding:0px;line-height:40px;">Lịch sử </p>
        	<select id="period" style="float:left;width:100px;height:40px;margin: 11px 0px 0px 15px;" onchange="getDeadlineByPeriod();">
              <option value=""><?php echo $text_select; ?></option>
                <?php foreach($alldeadlineperiod as $period) { ?>
                   <?php if($period == $cur_period) {?>
                        <option value="<?php echo $period ?>" selected="selected"><?php echo $period; ?></option>
                    <?php } else { ?>
                        <option value="<?php echo $period ?>"><?php echo $period; ?></option>
                    <?php }?>
                <?php } ?>
            </select>
        </div>
       <table style="float:left;width:290px;margin-right:10px;">
          <tbody>
          	<tr>
                <td><p><?php echo $text_deadline_charge; ?></p></td>
                <td>
                	<select id="deadline_charge" name="deadline_charge">
                      <option value=""><?php echo $text_select; ?></option>
                        <?php foreach($alldays as $eachday) { ?> 
                            <?php if($eachday == $deadline_charge) {?>
                                <option value="<?php echo $eachday ?>" selected="selected"><?php echo $eachday; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $eachday ?>"><?php echo $eachday; ?></option>
                            <?php }?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><p><?php echo $text_deadline_edit; ?></p></td>
                <td>
                	<select id="deadline_edit" name="deadline_edit">
                      <option value=""><?php echo $text_select; ?></option>
                        <?php foreach($alldays as $eachday) { ?> 
                            <?php if($eachday == $deadline_edit) {?>
                                <option value="<?php echo $eachday ?>" selected="selected"><?php echo $eachday; ?></option>
                            <?php } else { ?>
                                <option value="<?php echo $eachday ?>"><?php echo $eachday; ?></option>
                            <?php }?>
                        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr><td><p><?php echo $text_deadline_supply; ?></p></td>
            <td>
                <select id="deadline_supply" name="deadline_supply">
                  <option value=""><?php echo $text_select; ?></option>
                    <?php foreach($alldays as $eachday) { ?> 
                        <?php if($eachday == $deadline_supply) {?>
                            <option value="<?php echo $eachday ?>" selected="selected"><?php echo $eachday; ?></option>
                        <?php } else { ?>
                            <option value="<?php echo $eachday ?>"><?php echo $eachday; ?></option>
                        <?php }?>
                    <?php } ?>
                </select>
            </td>
            </tr>
          </tbody>
        </table>
        <table style="float:left;width:290px;margin-right:10px;">
          <tbody>
          	<tr>
                <td><p><?php echo $text_total_elec; ?></p></td>
                <td><input type="text" id="total_elec" value="<?php echo $total_elec ;?>" /></td>
            </tr>
            <tr>
                <td><p><?php echo $text_total_water; ?></p></td>
                <td><input type="text" id="total_water" value="<?php echo $total_elec ;?>" /></td>
            </tr>
            <tr><td colspan="2" style="height:40px;"></td></tr>
          </tbody>
        </table>
        <div style="float:left;width:100%;"><a onclick="saveDeadline()" class="button"/><?php echo $text_confirm ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="deadlineForm(false);" class="button"/><?php echo $text_cancel ?></a></div>
    </div>
</div>

<script type="text/javascript"><!--
	var card_code = '';
	var temp_room = 0;
    $( document ).ready(function() {
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
	  //mail
	  $("input[name^='mail']").click(function () {
		  if($(this).attr("id") == "ra_all_mail") {
			$("#mail_elements *").each(function(index, element) {
				if(!$(element).is(':radio')) {
					$(element).attr("disabled","disabled");
				}
			});
		  }
		  else if($(this).attr("id") == "ra_partial_mail"){
			$("#mail_elements *").each(function(index, element) {
				$(element).removeAttr("disabled");
			});
		  }
		});
		//disable at load
		$("#mail_elements *").each(function(index, element) {
			if(!$(element).is(':radio')) {
				$(element).attr("disabled","disabled");
			}
		});
		
		
		//print
		$("input[name^='print']").click(function () {
		  if($(this).attr("id") == "ra_all_print") {
			$("#print_elements *").each(function(index, element) {
				if(!$(element).is(':radio')) {
					$(element).attr("disabled","disabled");
				}
			});
		  }
		  else if($(this).attr("id") == "ra_partial_print"){
			$("#print_elements *").each(function(index, element) {
				$(element).removeAttr("disabled");
			});
		  }
		});
		//disable at load
		$("#print_elements *").each(function(index, element) {
			if(!$(element).is(':radio')) {
				$(element).attr("disabled","disabled");
			}
		});
    });
	
	filterRoomByFloorView();
	
	function viewRoomWieDetail(id) {
		$('tr[id^=\'detail_wie_' + id + '\']').slideToggle(500);
	}
	
	$('tr[id^=\'detail_wie_month_\']').click(function() {
		$('tr[id^=\'detail_wie_rows_\']').fadeOut(100);
		var trid = $(this).attr('id').replace('detail_wie_month_','');
		$('tr[id=\'detail_wie_rows_' + trid + '\']').slideToggle(500);
	});
	
	function filterRoomByFloorView() {
		var floor_id = $('#sel_floor_wie').val();
		var room_id = $('#sel_room_wie').val();
		
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByFloorView&token=<?php echo $token; ?>',
			type: 'post',
			data: 'floor_id=' + floor_id + '&room_id=' + room_id,
			dataType: 'json',
			success: function(json) {
				//console.log(json['floors_filtered']);
				if(json['floors_filtered']) {
					renderRoomsView(json['floors_filtered'],1);
					filterRoomByFloorSelView();
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}
	function filterRoomByFloorSelView() {
		var floor_id = $('#sel_floor_wie').val();
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByFloorSelView&token=<?php echo $token; ?>',
			type: 'post',
			data: 'floor_id=' + floor_id,
			dataType: 'json',
			success: function(json) {
				if(json['rooms']) {
					renderRoomsSelectBoxView(json['rooms']);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}
	function refreshInputFilter(){
		var floor_id = $('#sel_floor').val();
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByFloorInput&token=<?php echo $token; ?>',
			type: 'post',
			data: 'floor_id=' + floor_id,
			dataType: 'json',
			success: function(json) {
				if(json['rooms']) {
					//renderRooms(json['rooms']);
					renderRoomsSelectBox(json['rooms']);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}
	function filterRoomByFloorInput() {
		var floor_id = $('#sel_floor').val();
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByFloorInput&token=<?php echo $token; ?>',
			type: 'post',
			data: 'floor_id=' + floor_id,
			dataType: 'json',
			success: function(json) {
				if(json['rooms']) {
					renderRooms(json['rooms']);
					renderRoomsSelectBox(json['rooms']);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}

  function filterFloorMailInput() {
    var floor_id = $('#mailFloor').val();
    $.ajax({
      url: 'index.php?route=sale/manage_wie/filterRoomByFloorView&token=<?php echo $token; ?>',
      type: 'post',
      data: 'floor_id=' + floor_id,
      dataType: 'json',
      success: function(json) {
		//console.log(json['floors_filtered']);
		input = $.map(json['floors_filtered'], function(value, index) {
			return [value];
		});		
		if(json['floors_filtered']) {
			renderOptionRooms(input[0]['rooms']);
		}
      },
      error : function(error) {
        console.log(error);
      }
    });
  }
  
  function filterFloorPrintInput() {
    var floor_id = $('#printFloor').val();
    $.ajax({
      url: 'index.php?route=sale/manage_wie/filterRoomByFloorView&token=<?php echo $token; ?>',
      type: 'post',
      data: 'floor_id=' + floor_id,
      dataType: 'json',
      success: function(json) {
		//console.log(json['floors_filtered']);
		input = $.map(json['floors_filtered'], function(value, index) {
			return [value];
		});		
		if(json['floors_filtered']) {
			renderOptionRoomsPrint(input[0]['rooms']);
		}
      },
      error : function(error) {
        console.log(error);
      }
    });
  }
  
  function saveDeadline() {
	  var total_elec = $("#total_elec").val();
	  var total_water = $("#total_water").val();
	  
	  if(total_elec == '' || total_water == '' || !total_elec.match(/^\d*[0-9](\.\d*[0-9])?$/) || !total_water.match(/^\d*[0-9](\.\d*[0-9])?$/)) {
	  	alert('<?php echo $text_error_total; ?>');
		return;
	  }
	  
	  if(!confirmResult)
		{
			if($('#confirmbox-form').css('display') == 'none')
				confirmBoxToggle(true,'Sửa hạn chót & tổng tiền ', saveDeadline);
			return;
		}
	  
		$.ajax({
			url: 'index.php?route=sale/manage_wie/saveDeadline&token=<?php echo $token; ?>',
			type: 'post',
			data: 'deadline_charge=' + $("#deadline_charge").val() + '&deadline_edit=' + $("#deadline_edit").val() + '&deadline_supply=' + $("#deadline_supply").val() + '&total_elec=' + total_elec + '&total_water=' + total_water,
			dataType: 'json',
			success: function(json) {
				if(json['success']) {
					filterRoomByFloorView();
					$("#period").val(json['period']);
					alert('<?php echo $text_update_deadline; ?>');
					deadlineForm(false);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
		
		confirmResult = false;
  }
  

	function loadOldValues() {
		var floor_id = $('#sel_floor').val();
		var room_id = $('#sel_room').val();
		$.ajax({
			url: 'index.php?route=sale/manage_wie/loadOldValues&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + room_id,
			dataType: 'json',
			success: function(json) {
				if(json['rooms']) {
					renderRooms(json['rooms']);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
	}
	function filterRoomByRoomIDInput() {
		var room_id = $('#sel_room').val();
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByRoomIDInput&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + room_id,
			dataType: 'json',
			success: function(json) {
				if(json['rooms']) {
					renderRooms(json['rooms']);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
	}
 function renderOptionRooms(input) {
    $('#leftValues').empty();
    for(var i=0; i < input.length; i++) {
      $('#leftValues')
          .append($('<option>', { value : input[i]['customer_group_id'] })
          .text(input[i]['name']));
    } 
  }
  
  function renderOptionRoomsPrint(input) {
    $('#leftValuesPrint').empty();
    for(var i=0; i < input.length; i++) {
      $('#leftValuesPrint')
          .append($('<option>', { value : input[i]['customer_group_id'] })
          .text(input[i]['name']));
    } 
  }
  
	function renderRooms(input) {
		strHTML = "";
		for(var i=0; i < input.length; i++) {
			strHTML += '<tr>' +
						'<td>' + input[i]['name'] + '<input type="hidden" id="room_id_' + input[i]['customer_group_id'] + '"/></td>'+
						'<td>' + input[i]['last_elec'] + '</td>' +
						((parseInt(input[i]['cur_elec'])) > 0 ? '<td>' + input[i]['cur_elec'] + '</td>' : '<td id="room_electric_holder_' + input[i]['customer_group_id'] + '"><input type="text" id="usage_electric_' + input[i]['customer_group_id'] + '"/></td>' ) +
						'<td>' + input[i]['last_water'] + '</td>' +
						((parseInt(input[i]['cur_water'])) > 0 ? '<td>' + input[i]['cur_water'] + '</td>' :'<td id="room_water_holder_' + input[i]['customer_group_id'] + '"><input type="text" id="usage_water_' + input[i]['customer_group_id'] + '"/></td>') +
					   '</tr>';
		}
		$("#room_list").html(strHTML);
	}
	
	
	var editstate = "";
	function renderRoomsView(input, flag) {
		strHTML = "";
		
		//convert object to array
		input = $.map(input, function(value, index) {
			return [value];
		});
		
		for(var i=0; i < input.length; i++) {
			if(input[i]['rooms']) { 
				strHTML += '<tr>' +
						  '<td style="text-align: left;height:30px;line-height:30px;font-size:16px;font-weight:bold;" colspan="7">' + input[i]['floor_name'] + '</td>'+
						'</tr>'+
						'<tr class="tblheader">'+
							'<td><?php echo $text_room?></td>' +
							'<td><?php echo $text_month?></td>' +
							((flag == 1) ? '<td><?php echo $text_usage_elec?></td>' : '<td><?php echo $text_start_num_electric?></td>') +
							((flag == 1) ? '<td><?php echo $text_cost?></td>' : '') +
							//'<td><?php echo $text_paid?></td>' +
							((flag == 1) ? '<td><?php echo $text_usage_water?></td>' : '<td><?php echo $text_start_num_water?></td>') +
							 ((flag == 1) ? '<td><?php echo $text_cost?></td>' : '')+
							'<td><?php echo $text_garbage?></td>' +
							'<td><?php echo $text_paid?></td>' +
							((flag == 1) ? '<?php if($this->user->getUserGroup() == ADMIN_IDX) { ?>' + '<td><?php echo $text_tool?></td>' + '<?php } ?>' : '') +
						'</tr>';
						
				for(var j=0; j < input[i]['rooms'].length; j++) {
					strHTML += '<tr class="body" >' +
								'<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;"' : "") + '>' + input[i]['rooms'][j]['name'] + '</td>' +
								'<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;"' : "") + '>' + input[i]['rooms'][j]['pay_month'] + '</td>' +
								'<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;text-align:center;"' : 'style="text-align:center;"') + '>' + ((flag == 1 || flag == 2) ?  input[i]['rooms'][j]['room_data']['elec']['Usage']: '<input type="text" id="end_num_elec_edit_' + input[i]['rooms'][j]['customer_group_id'] + '" value ="' + input[i]['rooms'][j]['room_data']['elec']['End'] + '" />') + '</td>' +
								((flag == 1) ? '<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;"' : "") + '>' + input[i]['rooms'][j]['room_data']['elec']['Money'] + '</td>' : '') +
								'<td  ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;text-align:center;"' : 'style="text-align:center;"') + '>' + ((flag == 1 || flag == 2) ? input[i]['rooms'][j]['room_data']['water']['Usage'] : '<input type="text" id="end_num_water_edit_' + input[i]['rooms'][j]['customer_group_id'] + '" value ="' + input[i]['rooms'][j]['room_data']['water']['End'] + '" />') + '</td>'  +
								((flag == 1) ? '<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;"' : "") + '>' + input[i]['rooms'][j]['room_data']['water']['Money'] + '</td>' : '') +
								'<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;"' : "") + '>' + ((input[i]['rooms'][j]['room_data']['garbage']) ? input[i]['rooms'][j]['room_data']['garbage'] : '') + '</td>' +
								'<td align="center" id="checkpaid_water_td_' + input[i]['rooms'][j]['customer_group_id'] + '" style="' + ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'yes') ? "background:#FFF;" : ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'no') ? "background:#ff0433;" : "background:#ff7a04;" )) + '">' + ((flag == 2) ? ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'yes') ? '<?php echo $text_paid; ?>' : ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'no') ? ((input[i]['rooms'][j]['room_data']['water']['ok'] == 'yes') ? '' : '') : '<?php echo $text_late; ?>' )) : ((flag == 1) ? ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'yes') ? '<?php echo $text_paid; ?>' : ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'no') ? ((input[i]['rooms'][j]['room_data']['is_supply'] == "no") ? '' : ((input[i]['rooms'][j]['room_data']['water']['ok'] == 'yes') ? '<input type="checkbox" id="checkpaid_' + input[i]['rooms'][j]['customer_group_id'] + '" name="checkpaid_' + input[i]['rooms'][j]['customer_group_id'] + '" />' : '')) : '<?php echo $text_late; ?>' )) : '<input type="checkbox" ' + ((input[i]['rooms'][j]['room_data']['water']['Charged'] != 'no') ? 'checked' : '') + ' id="checkpaidedit_2' + input[i]['rooms'][j]['customer_group_id'] + '" />')) + '</td>' +
								((flag == 1) ? '<?php if($this->user->getUserGroup() == ADMIN_IDX) { ?>' + '<td ' + ((input[i]['rooms'][j]['room_data']['late_times'] >= 3 || (input[i]['rooms'][j]['room_data']['is_supply'] == "no" && input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no')) ? 'style="background:#ff7a04;"' : "") + '>' + ((input[i]['rooms'][j]['room_data']['can_edit'] == 'yes') ? '<a style="float:right;color:blue;" onclick="editElecWater(' + input[i]['rooms'][j]['customer_group_id']  +');"><?php echo $text_edit; ?></a>' : '') + '</td>' + '<?php } ?>' : '') +
							'</tr>';
				}
			}
		}
		
		if(flag == 1) {
			$("#viewWie").html(strHTML);
		
			$("input[name^='checkpaid_']").click(function() {
				var checked = $(this).attr("checked") ? 1 : 0;
				if(checked) {
					var id = $(this).attr('name').replace('checkpaid_','');
					temp_room = id;
					$("#confirmPreview").show();
					previewElecWater(id);
				}
				//checkpaid_elec(id);	
			});
			
			//$("input[name^='checkpaid_water_']").click(function() {
//				var id = $(this).attr('name').replace('checkpaid_water_','');
//				temp_room = id;
//				editstate = "water";
//				previewElecWater(id);
//				//checkpaid_water();	
//			});
		}
		else {
			$("#tbEditWie").html(strHTML);
		}
	}
	
	var txtidx = 0;
	var ref_typewritter = null;
	function typeWritter(field, value, callback){
		if(txtidx < value.length) {
			$("#" + field).html($("#" + field).html() + value[txtidx]);
			txtidx ++;
		}
		else {
			txtidx = 0;
			clearInterval(ref_typewritter);
			ref_typewritter = null;
			
			//execute next function after done
			callback();
		}
	}
	
	function previewElecWaterCard(card_id) {
		//var card_id = $("#temp_id").val();
		loadingForm(true);
		$.ajax({
			url: 'index.php?route=sale/manage_wie/getStudentIDFromCardID&token=<?php echo $token; ?>',
			type: 'post',
			data: 'card_id=' + card_id,
			dataType: 'json',
			success: function(json) {
				//console.log(json);
				//console.log(json['student_info']);
				//clear data first
				$("#txtHeaderMSSV").html('');
				$("#txtHeaderSName").html('');
				$("#txtHeaderRoomLead").html('');
				$("#txtMSSV").html('');
				$("#txtSName").html('');
				$("#txtRoomLead").html('');
				$("#tbpreviewWie").html('');
				
				//previewWieToggle(true);
				
				if(json['student_info']) {
					loadingForm(false);
					previewWieToggle(true);
					$("#student_info").show();
					var student = json['student_info'];
					
					var student_id = student['student_id'];
					var name = student['firstname'] + ' ' + student['lastname'];
					var roomname = 'Phòng ' + student['room_lead']['name'];
					
					ref_typewritter = setInterval(typeWritter, 5, "txtHeaderMSSV",'<?php echo $text_mssv; ?>', function () { ref_typewritter = setInterval(typeWritter, 5, "txtHeaderSName",'<?php echo $text_sname; ?>',function () { ref_typewritter = setInterval(typeWritter, 5, "txtHeaderRoomLead",'<?php echo $text_roomlead; ?>',function () { ref_typewritter = setInterval(typeWritter, 5, "txtMSSV",student_id,function () { ref_typewritter = setInterval(typeWritter, 5, "txtSName",name,function () { ref_typewritter = setInterval(typeWritter, 5, "txtRoomLead",roomname, function() { $("#student_info").append('<div id="checkOkImg" style="display:none;margin:5px 0px 5px 0px;"><img src="view/image/check_ok.png" style="width:32px;height:32px;" alt =""/><p style="top:-10px;"><?php echo $text_confirm_student; ?></p></div><div id="loadingData" style="display:none;margin:5px 0px 5px 0px;"><img src="view/image/loading.gif" style="width:10px;height:10px;" alt =""/><p style="with:60%!important;"><?php echo $text_loading_info; ?></p></div>');$("#checkOkImg").fadeIn(300, function() {$("#loadingData").fadeIn(300, function(){
							$.ajax({
								url: 'index.php?route=sale/manage_wie/getBillInfo&token=<?php echo $token; ?>',
								type: 'post',
								data: 'room_id=' + student['room_lead']['customer_group_id'],
								dataType: 'json',
								success: function(json) {
									//console.log(json);
									if(json['bill']) {
										//console.log(json['bill']);
										if(json['bill']['charged'] == 'no') {
											temp_room = student['room_lead']['customer_group_id'];
											$("#tbpreviewWie").hide();
											$("#tbpreviewWie").html(json['bill']['bill_detail']);
											$("#tbpreviewWie").fadeIn(500);
											$("#confirmPreview").fadeIn(300);
											$("#loadingData").fadeOut();
											
											var left = ($(window).width() - $('#editwiepreview-form').width()) / 2;
											var top = ($(window).height() - $('#editwiepreview-form').height()) / 2;
											$('#editwiepreview-form').css('left',left + 'px');
											$('#editwiepreview-form').css('top',top + 'px');
										}
										else {
											loadingForm(false);
											previewWieToggle(false);
											alert('<?php echo $text_room_charged;?>');
										}
									}
								},
								error : function(error) {
									console.log(error);
								}
							});
							
					 });}); });});});});});});
					
					
					//ref_typewritter = setInterval(typeWritter, 20, "txtHeaderMSSV",'<?php echo $text_mssv; ?>');
//					
//					ref_typewritter = setInterval(typeWritter, 20, "txtHeaderSName",'<?php echo $text_sname; ?>');
//					
//					ref_typewritter = setInterval(typeWritter, 20, "txtHeaderSName",'<?php echo $text_sname; ?>');
//					
//					ref_typewritter = setInterval(typeWritter, 20, "txtHeaderRoomLead",'<?php echo $text_roomlead; ?>');
//					
//					ref_typewritter = setInterval(typeWritter, 20, "txtMSSV",student_id);
//					
//					ref_typewritter = setInterval(typeWritter, 20, "txtSName",name);
//					
//					ref_typewritter = setInterval(typeWritter, 20, "txtRoomLead",roomname);
					
					
					
					
					//alert('student_id: '+ student_id);
//					alert('name: '+ name);
//					alert('roomname: '+ roomname);
				}
				else {
					loadingForm(false);
					alert('<?php echo $text_no_student; ?>');
					//$("#student_info").html('');
					//$("#student_info").append('<div id="checkOkImg" style="display:none;margin:5px 0px 5px 0px;"><img src="view/image/check_fail.png" style="width:32px;height:32px;" alt =""/><p style="top:-10px;width:70%!important"><?php echo $text_no_student; ?></span></p>'); 
					//$("#checkOkImg").fadeIn(1000);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}
	
	function previewElecWater(room_id) {
		$.ajax({
			url: 'index.php?route=sale/manage_wie/getBillInfo&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + room_id,
			dataType: 'json',
			success: function(json) {
				//console.log(json['bill']);
				if(json['bill']) {
					temp_room = room_id;
					if(json['bill']['charged'] == 'no') {
						$("#tbpreviewWie").html(json['bill']['bill_detail']);
					}
					else {
						$("#tbpreviewWie").html('<?php echo $text_room_charged;?>');
					}
					previewWieToggle(true);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}
	
	function checkpaid() {
		loadingForm(true);
		//if(!confirmResult)
//		{
//			if($('#confirmbox-form').css('display') == 'none')
//				confirmBoxToggle(true,'Check đóng tiền điện phòng ' + temp_room,checkpaid);
//			return;
//		}
		
		//update charged data
		$.ajax({
			url: 'index.php?route=sale/manage_wie/charged&token=<?php echo $token; ?>',
			type: 'post',
			data: {'room_id' : temp_room},
			dataType: 'json',
			success: function(json) {
				console.log(json);
				if(json['success']) {
					previewWieToggle(false);
					filterRoomByFloorView();
					loadingForm(false);
					alert('<?php echo $text_success_charged?>');
					//$('#printDiv').html(json['bill'] + '<br /><br /><br /><br /><br /><br />' + json['bill']);
					//$("#printDiv").printElement({ printBodyOptions:{styleToAdd:'padding:10px;margin:10px;display:block'}});
					//disabled the checkbox
					//$("#checkpaid_elec_td_" + id).html('<?php echo $text_paid;?>');
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
		//confirmResult = false;
	}
	
	function editElecWater(room_id) {
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByFloorView&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + room_id,
			dataType: 'json',
			success: function(json) {
				console.log(json['floors_filtered']);
				if(json['floors_filtered']) {
					temp_room = room_id;
					renderRoomsView(json['floors_filtered'],0);
					editWieToggle(true);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
	}
	
	function saveEditWie() {
		
		var end_elec = $("#end_num_elec_edit_" + temp_room).val();
		var end_water = $("#end_num_water_edit_" + temp_room).val();
		var check_paid = $("#checkpaidedit_2" + temp_room).attr("checked") ? 1 : 0;		
		if(!confirmResult)
		{
			if($('#confirmbox-form').css('display') == 'none')
				confirmBoxToggle(true,'Sửa điện nước phòng ' + temp_room,saveEditWie);
			return;
		}
		loadingForm(true);
		$.ajax({
			url: 'index.php?route=sale/manage_wie/saveEditWie&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + temp_room + '&end_elec=' + end_elec + '&end_water=' + end_water + '&check_paid=' + check_paid,
			dataType: 'json',
			success: function(json) {
				//console.log(json['floors_filtered']);
				if(json['success']) {
					filterRoomByFloorView();
					editWieToggle(false);
					loadingForm(false);
					alert('<?php echo $text_success?>');
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
		confirmResult = false;
	}
	
	function renderRoomsSelectBox(input) {
		strHTML = '<option value="-1"><?php echo $text_all; ?></option>';
		for(var i=0; i < input.length; i++) {
			strHTML += '<option value="' + input[i]['customer_group_id'] + '">' + input[i]['name'] + '</option>';
		}
		$("#sel_room").html(strHTML);
	}
	
	function renderRoomsSelectBoxView(input) {
		strHTML = '<option value="-1"><?php echo $text_all; ?></option>';
		for(var i=0; i < input.length; i++) {
			strHTML += '<option value="' + input[i]['customer_group_id'] + '">' + input[i]['name'] + '</option>';
		}
		$("#sel_room_wie").html(strHTML);
	}
	var confirmResult = false;
	function inputHistory() {
		loadingForm(true);
		//if(!confirmResult)
//		{
//			if($('#confirmbox-form').css('display') == 'none')
//				confirmBoxToggle(true,'Nhập điện nước',inputHistory);
//			return;
//		}
		
		clearAllStyles();
		//var month = $('#sel_month').val();
		//var year = $('#sel_year').val();
		
		var electric_sels = $('input[id^=\'usage_electric_\']');
		var water_sels = $('input[id^=\'usage_water_\']');
		
		//console.log(electric_sels);
		
		var electric_usage = Array();
		var water_usage = Array();
		
		for(var i=0; i < electric_sels.length; i++) {
			var item = {'room_id' : $(electric_sels[i]).attr("id").replace('usage_electric_',''), 'usage': $(electric_sels[i]).val(), 'edit': 0, 'error': 0, 'confirm': 0, 'input': 0};
			electric_usage.push(item);
		}
		
		for(var i=0; i < water_sels.length; i++) {
			var item = {'room_id' : $(water_sels[i]).attr("id").replace('usage_water_',''), 'usage': $(water_sels[i]).val(), 'edit': 0, 'error': 0, 'confirm': 0, 'input': 0};
			water_usage.push(item);
		}
		
		$.ajax({
			url: 'index.php?route=sale/manage_wie/inputUsage&token=<?php echo $token; ?>',
			type: 'post',
			data: {'electric_usage' : electric_usage, 'water_usage' : water_usage},
			dataType: 'json',
			success: function(json) {
				if(json['success']) {
					//console.log(json['success']);
					//newsToggle(false);
					refreshInputFilter();
					var have_false = checkOutputAndHighlight(json['success']);
					loadingForm(false);
					if(!have_false) {
						alert('<?php echo $text_success?>');
					}
					else {
						alert('<?php echo $text_error?>');
					}
					filterRoomByFloorView();					
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
		//confirmResult = false;
	}
	function clearAllStyles(){
		$('input[id^=\'usage_electric_\']').css("background-color","#FFFFFF");
		$('input[id^=\'usage_electric_\']').css("color","#000000");
		$('input[id^=\'usage_water_\']').css("background-color","#FFFFFF");
		$('input[id^=\'usage_water_\']').css("color","#000000");
		$('a[id^=\'confirm_electric_\']').remove();
	}
	function checkOutputAndHighlight(ouput) {
		var electric_usage = ouput['electric_usage'];
		var water_usage = ouput['water_usage'];
		var have_false = false;
		
		for(var i=0; i < electric_usage.length; i++) {
			if(!parseInt(electric_usage[i]['input'])) {
				if(parseInt(electric_usage[i]['edit'])) {
					$("#usage_electric_" + electric_usage[i]['room_id']).css("color","#FFFFFF");
					$("#usage_electric_" + electric_usage[i]['room_id']).css("background-color","#05d200");
					if(!document.getElementById("confirm_electric_" + electric_usage[i]['room_id'])) {
						$("#room_electric_holder_" + electric_usage[i]['room_id']).append("<a onclick='confirmRoomElec(" + electric_usage[i]['room_id'] + ");' id='confirm_electric_" + electric_usage[i]['room_id'] + "'><?php echo $text_confirm ?></a>");
					}
				}
				
				if(parseInt(electric_usage[i]['error'])) {
					$("#usage_electric_" + electric_usage[i]['room_id']).css("color","#FFFFFF");
					$("#usage_electric_" + electric_usage[i]['room_id']).css("background-color","#ec0c0c");
					have_false = true;
				}
			}
			else {
				$("#usage_electric_" + electric_usage[i]['room_id']).parent().html($("#usage_electric_" + electric_usage[i]['room_id']).val());
			}
		}
		
		for(var i=0; i < water_usage.length; i++) {
			if(!parseInt(water_usage[i]['input'])) {
				if(parseInt(water_usage[i]['edit'])) {
					$("#usage_water_" + water_usage[i]['room_id']).css("color","#FFFFFF");
					$("#usage_water_" + water_usage[i]['room_id']).css("background-color","#05d200");
					if(!document.getElementById("confirm_water_" + water_usage[i]['room_id'])) {
						$("#room_water_holder_" + water_usage[i]['room_id']).append("<a onclick='confirmRoomWater(" + water_usage[i]['room_id'] + ");' id='confirm_water_" + water_usage[i]['room_id'] + "'><?php echo $text_confirm ?></a>");
					}
				}
				
				if(parseInt(water_usage[i]['error'])) {
					$("#usage_water_" + water_usage[i]['room_id']).css("color","#FFFFFF");
					$("#usage_water_" + water_usage[i]['room_id']).css("background-color","#ec0c0c");
					have_false = true;
				}
			}
			else {
				$("#usage_water_" + water_usage[i]['room_id']).parent().html($("#usage_water_" + water_usage[i]['room_id']).val());
			}
		}
		
		return have_false;
	}
	function confirmRoomElec(id) {
		var month = $('#sel_month').val();
		var year = $('#sel_year').val();
		var elec_val = $('#usage_electric_' + id).val();
		
		$.ajax({
				url: 'index.php?route=sale/manage_wie/confirmRoomElec&token=<?php echo $token; ?>',
				type: 'post',
				data: {'month' : month , 'year' : year , 'room_id': id ,'elec_val' : elec_val},
				dataType: 'json',
				success: function(json) {					
					if(json['success'] == 'yes') {
						$('#usage_electric_' + id).css("color","#000000");
						$('#usage_electric_' + id).css("background-color","#FFFFFF");
						$('#confirm_electric_' + id).remove();
					}
					else if(json['success'] == 'edit') {
						$('#usage_electric_' + id).css("color","#FFFFFF");
						$('#usage_electric_' + id).css("background-color","#05d200");
					}
					else if(json['success'] == 'error') {
						$('#usage_electric_' + id).css("color","#FFFFFF");
						$('#usage_electric_' + id).css("background-color","#ec0c0c");
					}
					else if(json['success'] == 'no') {
						$('#usage_electric_' + id).css("color","#000000");
						$('#usage_electric_' + id).css("background-color","#FFFFFF");
					}
				},
				error : function(error) {
					console.log(error);
				}
			});
	}
	function confirmRoomWater(id) {
		var month = $('#sel_month').val();
		var year = $('#sel_year').val();
		var water_val = $('#usage_water_' + id).val();
		
		$.ajax({
				url: 'index.php?route=sale/manage_wie/confirmRoomWater&token=<?php echo $token; ?>',
				type: 'post',
				data: {'month' : month , 'year' : year , 'room_id': id, 'water_val' : water_val},
				dataType: 'json',
				success: function(json) {
					if(json['success'] == 'yes') {
						$('#usage_water_' + id).css("color","#000000");
						$('#usage_water_' + id).css("background-color","#FFFFFF");
						$('#confirm_water_' + id).remove();
					}
					else if(json['success'] == 'edit') {
						$('#usage_water_' + id).css("color","#FFFFFF");
						$('#usage_water_' + id).css("background-color","#05d200");
					}
					else if(json['success'] == 'error') {
						$('#usage_water_' + id).css("color","#FFFFFF");
						$('#usage_water_' + id).css("background-color","#ec0c0c");
					}
					else if(json['success'] == 'no') {
						$('#usage_water_' + id).css("color","#000000");
						$('#usage_water_' + id).css("background-color","#FFFFFF");
					}
				},
				error : function(error) {
					console.log(error);
				}
			});
	}
	
	function newsToggle(show) {
		//toggle show
		if(show)
		{
			filterRoomByFloorInput();
			//show box
			var left = ($(window).width() - $('#news-form').width()) / 2;
			var top = ($(window).height() - $('#news-form').height()) / 2;
			$('#news-form').css('left',left + 'px');
			$('#news-form').css('top',top + 'px');
			$('#news-form-back').fadeIn(400);
			$('#news-form').fadeIn(400);
		}
		else
		{
			document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_header ?>";
			$('#news-form-back').fadeOut(400);
			$('#news-form').fadeOut(400);
		}
	}
	
	function confirmBoxToggle(show,action,callback) {
		//toggle show
		if(show)
		{
			$("#logContent").val('');
			//show box
			var left = ($(window).width() - $('#confirmbox-form').width()) / 2;
			var top = ($(window).height() - $('#confirmbox-form').height()) / 2;
			$('#confirmbox-form').css('left',left + 'px');
			$('#confirmbox-form').css('top',top + 'px');
			//$('#confirmbox-form-back').fadeIn(400);
			$('#confirmbox-form').fadeIn(400);
			
			$('#confirmBoxSubmit').unbind("click");
			$('#confirmBoxSubmit').click(function () {
				var content = $.trim($("#logContent").val());
				
				if(content.length < 10) {
					alert('<?php echo $text_error_log ?>')
					return;
				}
				else {
					$.ajax({
						url: 'index.php?route=sale/manage_wie/savelog&token=<?php echo $token; ?>',
						type: 'post',
						data: 'action=' + action + '&reason=' + content,
						dataType: 'json',
						success: function(json) {
							if(json['success']) {
								confirmBoxToggle(false);
								confirmResult = true;
								callback();
							}
						},
						error : function(error) {
							console.log(error);
						}
					});
				}
			});
		}
		else
		{
			document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_header ?>";
			$('#confirmbox-form-back').fadeOut(400);
			$('#confirmbox-form').fadeOut(400);
		}
	}
	
	function loadingForm(show) {
		//toggle show
		if(show)
		{
			//show box
			var left = ($(window).width() - $('#loading-form').width()) / 2;
			var top = ($(window).height() - $('#loading-form').height()) / 2;
			$('#loading-form').css('left',left + 'px');
			$('#loading-form').css('top',top + 'px');
			$('#loading-form-back').fadeIn(400);
			$('#loading-form').fadeIn(400);
		}
		else
		{
			$('#loading-form-back').fadeOut(400);
			$('#loading-form').fadeOut(400);
		}
	}
	
	function editWieToggle(show) {
		//toggle show
		if(show)
		{
			//show box
			var left = ($(window).width() - $('#editwie-form').width()) / 2;
			var top = ($(window).height() - $('#editwie-form').height()) / 2;
			$('#editwie-form').css('left',left + 'px');
			$('#editwie-form').css('top',top + 'px');
			$('#editwie-form-back').fadeIn(400);
			$('#editwie-form').fadeIn(400);
		}
		else
		{
			document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_header ?>";
			$('#editwie-form-back').fadeOut(400);
			$('#editwie-form').fadeOut(400);
		}
	}
	
	function previewWieToggle(show) {
		//toggle show
		if(show)
		{
			//show box
			var left = ($(window).width() - $('#editwiepreview-form').width()) / 2;
			var top = ($(window).height() - $('#editwiepreview-form').height()) / 2;
			$('#editwiepreview-form').css('left',left + 'px');
			$('#editwiepreview-form').css('top',top + 'px');
			$('#editwiepreview-form-back').fadeIn(400);
			$('#editwiepreview-form').fadeIn(700);
			
		}
		else
		{
			document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_header ?>";
			//checked false
			$("#checkpaid_" + temp_room).removeAttr('checked');
			$('#editwiepreview-form-back').fadeOut(400);
			$('#editwiepreview-form').fadeOut(400);
		}
	}
	
	function sendMailToEachRoom() {
		loadingForm(true);
		var selected_rooms = Array();
		var ra_all = $("#ra_all_mail:checked").val();
		$("#rightValues option").each(function(){
			//alert($(this).val());
			selected_rooms.push($(this).val());
		  
		});
	
		$.ajax({
			url: 'index.php?route=sale/manage_wie/sendMailSelectedRooms&token=<?php echo $token; ?>',
			type: 'post',
			data: 'rooms=' + selected_rooms + '&all=' + ((ra_all == 1) ? 1: 0),
			dataType: 'json',
			success: function(json) {
			  //console.log(json);
			  if(json['success']) {
				 loadingForm(false);
				alert("Mail đã được chuyển tới các phòng !");
			  }
			},
			error : function(error) {
			  console.log(error);
			}
		});
  }
  
  function printEachRoom() {
	  	loadingForm(true);
		var selected_rooms = Array();
		var ra_all = $("#ra_all_print:checked").val();
		$("#rightValuesPrint option").each(function(){
			//alert($(this).val());
			selected_rooms.push($(this).val());
		  
		});
	
		$.ajax({
			url: 'index.php?route=sale/manage_wie/printSelectedRooms&token=<?php echo $token; ?>',
			type: 'post',
			data: 'rooms=' + selected_rooms + '&all=' + ((ra_all == 1) ? 1: 0),
			dataType: 'json',
			success: function(json) {
			  //console.log(json);
			  if(json['bills']) {
				loadingForm(false);
				$('#printDiv').html(json['bills']);
				$("#printDiv").printElement({ printBodyOptions:{styleToAdd:'padding:10px;margin:10px;display:block'}});
			  }
			},
			error : function(error) {
			  console.log(error);
			}
		});
  }
  
  function sendMailToMinistry() {
	 loadingForm(true);
    var ministryMail = $("#ministryMail").val();

    $.ajax({
            url: 'index.php?route=sale/manage_wie/sendMailMinistry&token=<?php echo $token; ?>',
            type: 'post',
            data: 'mail_to=' + ministryMail,
            dataType: 'json',
            success: function(json) {
              if(json['success']) {
				  loadingForm(false);
                alert("Mail đã được chuyển tới giáo vụ thành công !");
              }
            },
            error : function(error) {
              console.log(error);
            }
          });
  }
  function mailForm(show) {
    //toggle show
    if(show)
    {
      //show box
      var left = ($(window).width() - $('#mail-form').width()) / 2;
      var top = ($(window).height() - $('#mail-form').height()) / 2;
      $('#mail-form').css('left',left + 'px');
      $('#mail-form').css('top',top + 'px');
      $('#mail-form-back').fadeIn(400);
      $('#mail-form').fadeIn(400);
    }
    else
    {
      document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_mail_header ?>";
      $('#mail-form-back').fadeOut(400);
      $('#mail-form').fadeOut(400);
    }
  }
  
  function printForm(show) {
    //toggle show
    if(show)
    {
      //show box
      var left = ($(window).width() - $('#print-form').width()) / 2;
      var top = ($(window).height() - $('#print-form').height()) / 2;
      $('#print-form').css('left',left + 'px');
      $('#print-form').css('top',top + 'px');
      $('#print-form-back').fadeIn(400);
      $('#print-form').fadeIn(400);
    }
    else
    {
      document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_print_header ?>";
      $('#print-form-back').fadeOut(400);
      $('#print-form').fadeOut(400);
    }
  }
  
  function getDeadlineByPeriod() {
  	//get data
	$.ajax({
		url: 'index.php?route=sale/manage_wie/getDeadlineByPeriod&token=<?php echo $token; ?>',
		type: 'post',
		data: 'period=' + $("#period").val(),
		dataType: 'json',
		success: function(json) {
			console.log(json);
			if(json['deadline']) {
				var deadline = json['deadline'];
				
				$("#deadline_charge").val(((deadline['deadline_charge']) ? deadline['deadline_charge'] : 10));
				$("#deadline_edit").val(((deadline['deadline_edit']) ? deadline['deadline_edit'] : 5));
				$("#deadline_supply").val(((deadline['deadline_supply']) ? deadline['deadline_supply'] : 15));
				$("#total_elec").val(((deadline['total_elec']) ? deadline['total_elec'] : 0));
				$("#total_water").val(((deadline['total_water']) ? deadline['total_water'] : 0));
			}
		},
		error : function(error) {
			console.log(error);
		}
	});
  }
  
  function deadlineForm(show) {
    //toggle show
    if(show)
    {
		//get data
		$.ajax({
			url: 'index.php?route=sale/manage_wie/getCurrentDeadline&token=<?php echo $token; ?>',
			type: 'post',
			data: 'period=' + $("#period").val(),
			dataType: 'json',
			success: function(json) {
				if(json['deadline']) {
					var deadline = json['deadline'];
					
					$("#deadline_charge").val(((deadline['deadline_charge']) ? deadline['deadline_charge'] : 10));
					$("#deadline_edit").val(((deadline['deadline_edit']) ? deadline['deadline_edit'] : 5));
					$("#deadline_supply").val(((deadline['deadline_supply']) ? deadline['deadline_supply'] : 15));
					$("#total_elec").val(((deadline['total_elec']) ? deadline['total_elec'] : 0));
					$("#total_water").val(((deadline['total_water']) ? deadline['total_water'] : 0));
					
					$("#period").val(deadline['period']);
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
      //show box
      var left = ($(window).width() - $('#deadline-form').width()) / 2;
      var top = ($(window).height() - $('#deadline-form').height()) / 2;
      $('#deadline-form').css('left',left + 'px');
      $('#deadline-form').css('top',top + 'px');
      $('#deadline-form-back').fadeIn(400);
      $('#deadline-form').fadeIn(400);
    }
    else
    {
      document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_print_header ?>";
      $('#deadline-form-back').fadeOut(400);
      $('#deadline-form').fadeOut(400);
    }
  }

	function formatCurrency(num)
	{
		num = num.toString().replace(/\$|\,/g, '');
		if (isNaN(num))
		{
			num = "0";
		}
	
		sign = (num == (num = Math.abs(num)));
		num = Math.floor(num * 100 + 0.50000000001);
		cents = num % 100;
		num = Math.floor(num / 100).toString();
	
		if (cents < 10)
		{
			cents = "0" + cents;
		}
		for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
		{
			num = num.substring(0, num.length - (4 * i + 3)) + ',' + num.substring(num.length - (4 * i + 3));
		}
	
		return (((sign) ? '' : '-') + '$' + num + '.' + cents);
	}
	
	//function filter() {
//		url = 'index.php?route=sale/manage_wie&token=<?php echo $token; ?>';
//		
//		var filter_floor = $('select[id=\'sel_floor_wie\']').attr('value');
//		
//		if (filter_floor != -1) {
//			url += '&filter_floor=' + encodeURIComponent(filter_floor);
//		}
//		
//		var filter_room = $('select[id=\'sel_room_wie\']').attr('value');
//		
//		if (filter_room != -1) {
//			url += '&filter_room=' + encodeURIComponent(filter_room);
//		}
//	
//		location = url;
//	}
//-->
$(document).ready(function() {
  $("#btnLeft").click(function () {
      var selectedItem = $("#rightValues option:selected");
      $("#leftValues").append(selectedItem);
  });

  $("#btnRight").click(function () {
      var selectedItem = $("#leftValues option:selected");
      $("#rightValues").append(selectedItem);
  });
  $("#btnLeftAll").click(function () {
      var selectedItem = $("#rightValues option");
      $("#leftValues").append(selectedItem);
  });

  $("#btnRightAll").click(function () {
      var selectedItem = $("#leftValues option");
      $("#rightValues").append(selectedItem);
  });
  
  
  $("#btnLeftPrint").click(function () {
      var selectedItem = $("#rightValuesPrint option:selected");
      $("#leftValuesPrint").append(selectedItem);
  });

  $("#btnRightPrint").click(function () {
      var selectedItem = $("#leftValuesPrint option:selected");
      $("#rightValuesPrint").append(selectedItem);
  });
  $("#btnLeftAllPrint").click(function () {
      var selectedItem = $("#rightValuesPrint option");
      $("#leftValuesPrint").append(selectedItem);
  });

  $("#btnRightAllPrint").click(function () {
      var selectedItem = $("#leftValuesPrint option");
      $("#rightValuesPrint").append(selectedItem);
  });
});
</script> 

<?php echo $footer; ?> 

<?php 
// function works like String.Format in C#

?>