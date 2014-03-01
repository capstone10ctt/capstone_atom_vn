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
      <div class="buttons"><a onclick="newsToggle(true);" class="button"><?php echo $text_add; ?></a><a href="<?php echo $import_data; ?>" class="button"><?php echo $text_import_from_file; ?></a><a onclick="mailForm(true);" class="button"><?php echo $text_mail; ?></a><a onclick="sendMailToMinistry();" class="button"><?php echo $text_mail_monthly; ?></a><!--<a onclick="location.reload();" class="button"><?php echo $text_refresh; ?></a>--></div>
      <div class="buttons"></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
      	<table class="tbTinyRows">
                <tr>
                	<td><?php echo $text_floor?></td>
                     <td><select id="sel_floor_wie" onchange="filterRoomByFloorView()">
                     <option value="-1"><?php echo $text_select; ?></option>
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
                     	<option value="-1"><?php echo $text_select; ?></option>
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
            
            <table style="float:left;width:600px; margin-left:40px;">
                <tr>
                	<td><?php echo $text_deadline?></td>
                     <td><select name="default_deadline_wie">
                  <option value=""><?php echo $text_select; ?></option>
            		<?php foreach($alldays as $eachday) { ?> 
                    	<?php if($eachday == $default_deadline_wie) {?>
                    		<option value="<?php echo $eachday ?>" selected="selected"><?php echo $eachday; ?></option>
                        <? } else { ?>
                        	<option value="<?php echo $eachday ?>"><?php echo $eachday; ?></option>
                        <?php }?>
            		<?php } ?>
            	</select></td>
                <td>/<?php echo $cur_month; ?>/<?php echo $cur_year; ?></td>
                <td>Ministry e-Mail Address: </td>
                <td><input id="ministryMail" name="ministryMail" value="<?php echo $ministryMail ?>" type="text"/></td>
                <td><input type="submit" value="<?php echo $text_save ?>"/></td>            
                </tr>
            </table>
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
<div id="news-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header ?></p>
        <img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="newsToggle(false);">
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
                	 <td><?php echo $text_month?></td>
                     <td><select id="sel_month">
            	 <option value=""><?php echo $text_select; ?></option>
            		<?php foreach($allmonths as $eachmonth) { ?> 
                    	<?php if($eachmonth == $cur_month) {?>
                    		<option value="<?php echo $eachmonth ?>" selected="selected"><?php echo $eachmonth; ?></option>
                        <? } else { ?>
                        	<option value="<?php echo $eachmonth ?>"><?php echo $eachmonth; ?></option>
                        <?php }?>
            		<?php } ?>
            	</select></td>
                </tr>
                <tr>
                	<td><?php echo $text_year?></td>
                     <td><select id="sel_year">
                     <option value=""><?php echo $text_select; ?></option>
                        <?php foreach($allyears as $eachyear) { ?> 
                        	<?php if($eachyear == $cur_year) {?>
                            	<option value="<?php echo $eachyear ?>" selected="selected"><?php echo $eachyear; ?></option>
                            <? } else { ?>
                            	<option value="<?php echo $eachyear ?>" ><?php echo $eachyear; ?></option>
                            <?php }?>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                	<td><?php echo $text_floor?></td>
                     <td><select id="sel_floor" onchange="filterRoomByFloorInput()">
                     <option value="-1"><?php echo $text_select; ?></option>
                        <?php foreach($floors_input as $floor) { ?> 
                            <option value="<?php echo $floor['floor_id'] ?>" ><?php echo $floor['floor_name']; ?></option>
                        <?php } ?>
                    </select></td>
                </tr>
                <tr>
                	<td><?php echo $text_room?></td>
                     <td><select id="sel_room" onchange="filterRoomByRoomIDInput()">
                     	<option value="-1"><?php echo $text_select; ?></option>
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
    <a onclick="inputHistory();" class="button"/><?php echo $text_submit ?></a>
    </div>
</div>

<div id="editwie-form-back" class="news-form-back"></div>
<div id="editwie-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header ?></p>
        <img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="editWieToggle(false);">
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody id="tbEditWie">
          	
          </tbody>
        </table>
    <a onclick="saveEditWie();" class="button"/><?php echo $text_submit ?></a>
    </div>
</div>

<div id="mail-form-back" class="mail-form-back"></div>
<div id="mail-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header ?></p>
        <img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="mailForm(false);">
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody id="tbEditWie">
            <fieldset style="border:0;">
    <input id="ra_all" type="radio" name="print" checked value="1">Gửi tất cả các phòng<br/>

    <input id="ra_partial" type="radio" name="print" value="2">Tùy chọn<br/>
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
    <a onclick="sendMailToEachRoom();" class="button"/>Gửi mail</a>
  </div>
  </fieldset>
          </tbody>
        </table>
    </div>
</div>

<div id="confirmbox-form" class="confirmbox-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_warning ?></p>
        <img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="confirmBoxToggle(false);">
    </div>
    <div class="fbody">
       <table class="editWie">
          <tbody>
          	<tr><td><p><?php echo $text_reason; ?></p></td></tr>
            <tr><td><textarea id="logContent" cols="80" rows="20" ></textarea></td></tr>
          </tbody>
        </table>
    <a id="confirmBoxSubmit" class="button"/><?php echo $text_submit ?></a>
    </div>
</div>

<script type="text/javascript"><!--

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
				console.log(json['floors_filtered']);
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
							'<td><?php echo $text_paid?></td>' +
							((flag == 1) ? '<td><?php echo $text_usage_water?></td>' : '<td><?php echo $text_start_num_water?></td>') +
							 ((flag == 1) ? '<td><?php echo $text_cost?></td>' : '')+
							'<td><?php echo $text_paid?></td>' +
							((flag == 1) ? '<td><?php echo $text_tool?></td>' : '') +
						'</tr>';
						
				for(var j=0; j < input[i]['rooms'].length; j++) {
					strHTML += '<tr class="body" >' +
								'<td>' + input[i]['rooms'][j]['name'] + '</td>' +
								'<td>' + input[i]['rooms'][j]['pay_month'] + '</td>' +
								'<td style="text-align:center;">' + ((flag == 1) ?  input[i]['rooms'][j]['room_data']['elec']['Usage']: '<input type="text" id="end_num_elec_edit_' + input[i]['rooms'][j]['customer_group_id'] + '" value ="' + input[i]['rooms'][j]['room_data']['elec']['End'] + '" />') + '</td>' +
								((flag == 1) ? '<td>' + input[i]['rooms'][j]['room_data']['elec']['Money'] + '</td>' : '') +
								'<td align="center" id="checkpaid_elec_td_' + input[i]['rooms'][j]['customer_group_id'] + '" style="' + ((input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'yes') ? "background:#FFF;" : ((input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no') ? "background:#ff0433;" : "background:#ff7a04;" )) + '">' + ((flag == 1) ? ((input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'yes') ? '<?php echo $text_paid; ?>' : ((input[i]['rooms'][j]['room_data']['elec']['Charged'] == 'no') ? ((input[i]['rooms'][j]['room_data']['elec']['ok'] == 'yes') ? '<input type="checkbox" name="checkpaid_elec_' + input[i]['rooms'][j]['customer_group_id'] + '" />' : '') : '<?php echo $text_late; ?>' )) : '<input type="checkbox" ' + ((input[i]['rooms'][j]['room_data']['elec']['Charged'] != 'no') ? 'checked' : '') + ' id="checkpaid_elec_edit_' + input[i]['rooms'][j]['customer_group_id'] + '" />') + '</td>' +
								'<td style="text-align:center;">' + ((flag == 1) ? input[i]['rooms'][j]['room_data']['water']['Usage'] : '<input type="text" id="end_num_water_edit_' + input[i]['rooms'][j]['customer_group_id'] + '" value ="' + input[i]['rooms'][j]['room_data']['water']['End'] + '" />') + '</td>'  +
								((flag == 1) ? '<td>' + input[i]['rooms'][j]['room_data']['water']['Money'] + '</td>' : '') +
								'<td align="center" id="checkpaid_water_td_' + input[i]['rooms'][j]['customer_group_id'] + '" style="' + ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'yes') ? "background:#FFF;" : ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'no') ? "background:#ff0433;" : "background:#ff7a04;" )) + '">' + ((flag == 1) ? ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'yes') ? '<?php echo $text_paid; ?>' : ((input[i]['rooms'][j]['room_data']['water']['Charged'] == 'no') ? ((input[i]['rooms'][j]['room_data']['water']['ok'] == 'yes') ? '<input type="checkbox" name="checkpaid_water_' + input[i]['rooms'][j]['customer_group_id'] + '" />' : '') : '<?php echo $text_late; ?>' )) : '<input type="checkbox" ' + ((input[i]['rooms'][j]['room_data']['water']['Charged'] != 'no') ? 'checked' : '') + ' id="checkpaid_water_edit_' + input[i]['rooms'][j]['customer_group_id'] + '" />') + '</td>' +
								((flag == 1) ? '<td><a style="float:right;color:blue;" onclick="editElecWater(' + input[i]['rooms'][j]['customer_group_id']  +');"><?php echo $text_edit; ?></a></td>' : '') +
							'</tr>';
				}
			}
		}
		
		if(flag == 1) {
			$("#viewWie").html(strHTML);
		
			$("input[name^='checkpaid_elec_']").click(function () {
				var id = $(this).attr('name').replace('checkpaid_elec_','');
				//update charged data
				$.ajax({
					url: 'index.php?route=sale/manage_wie/elec_charged&token=<?php echo $token; ?>',
					type: 'post',
					data: {'room_id' : id},
					dataType: 'json',
					success: function(json) {
						if(json['success']) {
							filterRoomByFloorView();
							//disabled the checkbox
							//$("#checkpaid_elec_td_" + id).html('<?php echo $text_paid;?>');
						}
					},
					error : function(error) {
						console.log(error);
					}
				});
			});
			
			$("input[name^='checkpaid_water_']").click(function () {
				var id = $(this).attr('name').replace('checkpaid_water_','');
				//update charged data
				$.ajax({
					url: 'index.php?route=sale/manage_wie/water_charged&token=<?php echo $token; ?>',
					type: 'post',
					data: {'room_id' : id},
					dataType: 'json',
					success: function(json) {
						if(json['success']) {
							filterRoomByFloorView();
							//disabled the checkbox
							//$("#checkpaid_water_td_" + id).html('<?php echo $text_paid;?>');
						}
					},
					error : function(error) {
						console.log(error);
					}
				});
			});
		}
		else {
			$("#tbEditWie").html(strHTML);
		}
	}
	
	var cur_room=0;
	function editElecWater(room_id) {
		$.ajax({
			url: 'index.php?route=sale/manage_wie/filterRoomByFloorView&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + room_id,
			dataType: 'json',
			success: function(json) {
				console.log(json['floors_filtered']);
				if(json['floors_filtered']) {
					cur_room = room_id;
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
		
		var end_elec = $("#end_num_elec_edit_" + cur_room).val();
		var end_water = $("#end_num_water_edit_" + cur_room).val();
		var sel_elec = $("#checkpaid_elec_edit_" + cur_room).attr("checked") ? 1 : 0;
		var sel_water = $("#checkpaid_water_edit_" + cur_room).attr("checked") ? 1 : 0;
		
		if(!confirmResult)
		{
			if($('#confirmbox-form').css('display') == 'none')
				confirmBoxToggle(true,'Sửa điện nước phòng ' + cur_room,saveEditWie);
			return;
		}
		
		/*alert(end_elec);
		alert(end_water);
		alert(sel_elec);
		alert(sel_water);*/
		
		$.ajax({
			url: 'index.php?route=sale/manage_wie/saveEditWie&token=<?php echo $token; ?>',
			type: 'post',
			data: 'room_id=' + cur_room + '&end_elec=' + end_elec + '&end_water=' + end_water + '&sel_elec=' + sel_elec + '&sel_water=' + sel_water,
			dataType: 'json',
			success: function(json) {
				//console.log(json['floors_filtered']);
				if(json['success']) {
					filterRoomByFloorView();
					alert('<?php echo $text_success?>');
					editWieToggle(false);
				}
				if(json['error']) {
					
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
		confirmResult = false;
	}
	
	function renderRoomsSelectBox(input) {
		strHTML = '<option value="-1"><?php echo $text_select; ?></option>';
		for(var i=0; i < input.length; i++) {
			strHTML += '<option value="' + input[i]['customer_group_id'] + '">' + input[i]['name'] + '</option>';
		}
		$("#sel_room").html(strHTML);
	}
	
	function renderRoomsSelectBoxView(input) {
		strHTML = '<option value="-1"><?php echo $text_select; ?></option>';
		for(var i=0; i < input.length; i++) {
			strHTML += '<option value="' + input[i]['customer_group_id'] + '">' + input[i]['name'] + '</option>';
		}
		$("#sel_room_wie").html(strHTML);
	}
	var confirmResult = false;
	function inputHistory() {
		
		if(!confirmResult)
		{
			if($('#confirmbox-form').css('display') == 'none')
				confirmBoxToggle(true,'Nhập điện nước',inputHistory);
			return;
		}
		
		clearAllStyles();
		var month = $('#sel_month').val();
		var year = $('#sel_year').val();
		
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
			data: {'month' : month , 'year' : year , 'electric_usage' : electric_usage, 'water_usage' : water_usage},
			dataType: 'json',
			success: function(json) {
				if(json['success']) {
					//console.log(json['success']);
					//newsToggle(false);
					checkOutputAndHighlight(json['success']);
					alert('<?php echo $text_success?>');
					filterRoomByFloorView();					
				}
			},
			error : function(error) {
				console.log(error);
			}
		});
		
		confirmResult = false;
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
				}
			}
			else {
				$("#usage_water_" + water_usage[i]['room_id']).parent().html($("#usage_water_" + water_usage[i]['room_id']).val());
			}
		}
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
			$("#confirmBoxSubmit").val('');
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
				
				if(content.length < 20) {
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
	
	function sendMailToEachRoom() {
		var selected_rooms = Array();
		var ra_all = $("#ra_all:checked").val();
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
				  console.log(json);
				  if(json['success']) {
					alert("Mail đã được chuyển tới các phòng !");
				  }
				},
				error : function(error) {
				  console.log(error);
				}
			  });
  }
  function sendMailToMinistry() {
    var ministryMail = $("#ministryMail").val();

    $.ajax({
            url: 'index.php?route=sale/manage_wie/sendMailMinistry&token=<?php echo $token; ?>',
            type: 'post',
            data: 'mail_to=' + ministryMail,
            dataType: 'json',
            success: function(json) {
              if(json['success']) {
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
      document.getElementById('lblpopupheader').innerHTML = "<?php echo $text_popup_header ?>";
      $('#mail-form-back').fadeOut(400);
      $('#mail-form').fadeOut(400);
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
});
</script> 

<?php echo $footer; ?> 

<?php 
// function works like String.Format in C#

?>