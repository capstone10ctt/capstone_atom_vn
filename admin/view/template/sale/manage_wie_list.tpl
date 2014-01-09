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
      <div class="buttons"></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'cgd.name') { ?>
                <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'cg.sort_order') { ?>
                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_sort_order; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_sort_order; ?></a>
                <?php } ?></td>                
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($manage_wies) { ?>
            <?php foreach ($manage_wies as $manage_wie) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($manage_wie['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $manage_wie['customer_group_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $manage_wie['customer_group_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $manage_wie['name']; ?></td>
              <td class="right"><?php echo $manage_wie['sort_order']; ?></td>
              <td class="right"><!--<?php foreach ($manage_wie['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?>-->[ <a onclick="newsToggle(true, <?php echo $manage_wie['customer_group_id'] ?>);"><?php echo $text_add; ?></a> ] [ <a onclick=""><?php echo $text_edit; ?></a> ] [ <a onclick="viewRoomWieDetail(<?php echo $manage_wie['customer_group_id']?>);"><?php echo $text_view; ?></a> ]</td>
               <!-- <?php echo "<pre>" ?>
                <?php echo print_r($billing_wie)?>
                <?php echo "</pre>" ?>-->

                <?php if(isset($billing_wie[$manage_wie['customer_group_id']])) {?>
                <tr id="detail_wie_<?php echo $manage_wie['customer_group_id']?>" style="display:none;">
                	<td colspan="5">
                        <table class="tblWieDetail">
                        	<?php foreach($billing_wie[$manage_wie['customer_group_id']] as $key =>$month) { ?>
                            <tr id="detail_wie_month_<?php echo $manage_wie['customer_group_id'].$key?>" class="header">
                                <td colspan="5"><?php echo $text_header.$key?></td>
                            </tr>
                           
                            <tr id="detail_wie_rows_<?php echo $manage_wie['customer_group_id'].$key?>" style="display:none;">
                                <td>
                                	<table class="tblWieDetailRows">
                                        <tr class="header">
                                        	<td><?php echo $text_month?></td>
                                            <td><?php echo $text_title?></td>
                                            <td><?php echo $text_start_num?></td>
                                            <td><?php echo $text_end_num?></td>
                                            <td><?php echo $text_usage?></td>
                                            <td><?php echo $text_cost?></td>
                                        </tr>
                                        <?php foreach($month as $type => $bill) { ?>
                                        	<?php if($type != "totalmoney" && $type != "inword") { ?>
                                            <?php foreach($bill as $child) { ?>
                                            <tr class="body">
                                                <td><?php echo $text_month.' '.$key?></td>
                                                <td><?php echo (($type == 'elec') ? $text_electric: $text_water)?></td>
                                                <td><?php echo $child['Start']?></td>
                                                <td><?php echo $child['End']?></td>
                                                <td><?php echo $child['Usage']?></td>
                                                <td><?php echo $child['Money'].' đ'?></td>
                                            </tr>
                                            <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </table>
                                    <?php echo '<h1 style="font-size:16px;float:left;margin: 0px 0px 0px 965px;">'.$text_totalmoney.': '. $month['totalmoney'].' đ</h1><br /><h2 style="float:right;font-size:13px;margin:5px 0px 0px 0px;padding:0px;">('.$month['inword'].')</h2>' ?>
                                </td>
                            </tr>
                           
                            <?php } ?>
                        </table>
                        
                    </td>
                </tr>
            </tr>
            <?php } ?>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<div id="news-form-back" class="news-form-back"></div>
<div id="news-form" class="news-form">
    <div class="header">
        <p id='lblpopupheader'><?php echo $text_popup_header ?></p>
        <img src="../admin/view/image/remove-small.png" alt="Close" title="Close" onclick="newsToggle(false, 0);">
    </div>
    <div class="body">
       <p><?php echo $text_greeting ?></p><br/>
        
       <table class="tblWieDetailRows">
        <tr class="header colorwhite">
            <td><?php echo $text_month?></td>
            <td><?php echo $text_year?></td>
            <td><?php echo $text_title?></td>
            <td><?php echo $text_start_num?></td>
            <td><?php echo $text_end_num?></td>
        </tr>
        <tr>
        	 <td><select id="sel_month">
            	 <option value=""><?php echo $text_select; ?></option>
            		<?php foreach($allmonths as $eachmonth) { ?> 
                    	<option value="<?php echo $eachmonth ?>" ><?php echo $eachmonth; ?></option>
            		<?php } ?>
            	</select></td>
             <td><select id="sel_year">
             <option value=""><?php echo $text_select; ?></option>
                <?php foreach($allyears as $eachyear) { ?> 
                    <option value="<?php echo $eachyear ?>" ><?php echo $eachyear; ?></option>
                <?php } ?>
            </select></td>
            <td><select id="sel_type">
            	 <option value="-1"><?php echo $text_select; ?></option>
            		<?php foreach($billing_types as $type) { ?> 
                    	<option value="<?php echo $type['value'] ?>" ><?php echo $type['text']; ?></option>
            		<?php } ?>
            	</select></td>
            <td><input type="text" id="start_num"/></td>
            <td><input type="text" id="end_num"/></td>
            
        </tr>
       </table>
    <a onclick="inputHistory();" class="button"/><?php echo $text_submit ?></a>
    </div>
</div>
<script type="text/javascript"><!--
	function viewRoomWieDetail(id) {
		$('tr[id^=\'detail_wie_' + id + '\']').slideToggle(500);
	}
	
	$('tr[id^=\'detail_wie_month_\']').click(function() {
		$('tr[id^=\'detail_wie_rows_\']').fadeOut(100);
		var trid = $(this).attr('id').replace('detail_wie_month_','');
		$('tr[id=\'detail_wie_rows_' + trid + '\']').slideToggle(500);
	});
	
	var cur_room = 0;
	function inputHistory() {
		var month = $('#sel_month').val();
		var year = $('#sel_year').val();
		var type = $('#sel_type').val();
		var start_num = $('#start_num').val();
		var end_num = $('#end_num').val();
		
		if(month == "" || year == "" || type == "-1" || start_num == "" || end_num == "") {
			alert("<?php echo $error_input ?>");
			return;
		}
		
		$.ajax({
				url: 'index.php?route=sale/manage_wie/inputHistory&token=<?php echo $token; ?>',
				type: 'post',
				data: 'month=' + month + '&year=' + year + '&type=' + type + '&start_num=' + start_num + '&end_num=' + end_num + '&room_id=' + cur_room,
				dataType: 'json',
				success: function(json) {
					if(json['success']) {
						newsToggle(false,0);
						alert('<?php echo $text_success?>')
					}
				},
				error : function(error) {
					console.log(error);
				}
			});
	}
	
	function newsToggle(show, roomid) {
		cur_room = roomid;
		//toggle show
		if(show)
		{
			//shhow box
			document.getElementById('lblpopupheader').innerHTML = document.getElementById('lblpopupheader').innerHTML + ' <?php echo $heading_title?> ' + roomid;
			var left = ($(window).width() - 610) / 2;
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
//--></script> 

<?php echo $footer; ?> 