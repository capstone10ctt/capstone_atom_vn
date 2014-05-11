<?php

if(isset($_GET["block"]))
{
  if ($floors) {
   $data = array();
   foreach ($floors as $floor)
   {
    $data[$floor['id']] = $floor['name'];
  }
  echo json_encode($data);
}
return;
}
if(isset($_GET["filter_block"]) || isset($_GET["filter_floor"]) || isset($_GET["filter_floor"]))
{
		$data = new StdClass();

		if(isset($block_info))
      $data->block_info=$block_info;
  $data->rooms=$rooms;
  $data->list_floors=$list_floors;
    	//echo json_encode($customer_groups);
  echo json_encode($data);
  return;
}
echo $header; ?>
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
  </div>
  <div class="content">
   <div id="leftcol" style="float:left;width:200px;height: 500px;text-alignment:left;position: relative;">
       <div style="margin-bottom:5px"><?php echo $text_id; ?></div>
       <input type="text" value="1051025" id="student_id_input" style="width: 91%;" />
       <a style="margin: 10px 0px 10px 50px;float:left;" onclick="advanceSearch(true);"><?php echo $text_advance_search; ?></a>
       <input type="button" value="<?php echo $text_do_search; ?>"  onclick="searchStudentByMSSV()" style="width:70px;margin:0px 0px 20px 50px;"/>
        <div id="advance_search" class="advance-search-block">
            <div style="margin-bottom:5px"><?php echo $text_name; ?></div>
            <input type="text" id="student_name" style="width:130px;margin:0px 0px 0px 20px;"/>

            <div style="margin-bottom:5px"><?php echo $text_birthday; ?></div>
            <select id="birthday_day" name="birthday_day">
                <?php foreach($alldays as $eachday) { ?>
                <option value="<?php echo $eachday ?>"><?php echo $eachday; ?></option>
                <?php } ?>
            </select>
            <select id="birthday_month" name="birthday_month">
                <?php foreach($allmonths as $eachmonth) { ?>
                <option value="<?php echo $eachmonth ?>"><?php echo $eachmonth; ?></option>
                <?php } ?>
            </select>
            <select id="birthday_year" name="birthday_year">
                <?php foreach($allyears as $eachyear) { ?>
                <option value="<?php echo $eachyear ?>"><?php echo $eachyear; ?></option>
                <?php } ?>
            </select>

            <div style="margin-bottom:5px"><?php echo $text_university; ?></div>
            <select id="student_university" name="student_university">
                <option value="0"><?php echo $text_select; ?></option>
                <?php foreach($universities as $university) { ?>
                <option value="<?php echo $university['category_id'] ?>"><?php echo $university['name']; ?></option>
                <?php } ?>
            </select>

            <div style="margin-bottom:5px"><?php echo $text_hometown; ?></div>
            <select id="student_hometown" name="student_hometown">
                <option value="0"><?php echo $text_select; ?></option>
                <?php foreach($zones as $zone) { ?>
                <option value="<?php echo $zone['zone_id'] ?>"><?php echo $zone['name']; ?></option>
                <?php } ?>
            </select>

            <input type="button" value="<?php echo $text_do_search; ?>"  onclick="searchStudentByMSSV()" style="width:70px;margin: 10px 0px 0px 10px;"/><input type="button" value="<?php echo $text_cancel_search; ?>"  onclick="advanceSearch(false);" style="width:70px;margin: 10px 0px 0px 10px;"/>

        </div>
       <div id="student_found_mssv" style="margin-bottom:5px;font-size: 15px;font-weight: bold;text-align: center;display: none;"><?php echo $text_hometown; ?></div>
       <img id="student_image" src="" alt="" style="float:left;width:180px;margin-bottom:20px;/*display:none;*/"/>

     <div style="margin-bottom:5px"><?php echo $text_block; ?></div>
     <select id="block_select" style="margin-bottom:5px;width:135px">
      <option value="0"><?php echo $text_all; ?></option>
      <?php if ($blocks) { ?>
      <?php foreach ($blocks as $block) { ?>
      <option value="<?php echo $block['id']; ?>"><?php echo $block['name']; ?></option>
      <?php echo $block['name']; ?>
      <?php } }?>
    </select> 
    <div style="margin-bottom:5px"><?php echo $text_floor; ?></div>
    <select id="floor_select" style="margin-bottom:5px;width:135px">
      <option value="0"><?php echo $text_all; ?></option>
    </select>
    <div style="margin-bottom:5px"><?php echo $text_status; ?></div>
    <select id="status_select" style="margin-bottom:5px;width:135px">
      <option value="0"><?php echo $text_all; ?></option>
      <option value="1"><?php echo $text_full; ?></option>
      <option value="2"><?php echo $text_notfull; ?></option>
      <option value="3"><?php echo $text_empty; ?></option>
    </select>
    <div style="margin-bottom:5px"><?php echo $column_type; ?></div>
    <select id="type_select" style="margin-bottom:10px;width:135px">
    <option value="0"><?php echo $text_all; ?></option>
    <?php foreach ($room_types as $room_type)  {
        echo '<option value="'.$room_type['type_id'].'" ';
        echo (isset($customer_group['type_id']) && $customer_group['type_id']==$room_type['type_id']) ? 'selected' : '';
        echo '>'.$room_type['type_name'].'</option>';
    }?>
    </select>
    <div style="margin-bottom:5px"><?php echo $text_numstudent; ?></div>
    <div style="margin-bottom:5px"><?php echo $text_from; ?>
    <input id="from_text" value="0" size="3"/>
    <?php echo $text_to; ?>
    <input id="to_text" value="0" size="3"/></div>
    <button type="button" style="margin-bottom:5px;width:135px" id="filter_btn"><?php echo $text_filter; ?></button>

    <div id="block_info"></div> 
  </div>

  <div id="rightcol" style="float:left;max-width: 780px;text-alignment:left">
   <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
     <div class="heading">
       <div class="buttons"><a id="add_room" href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>  <a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
     </div>
     <table class="list" style="margin-top:10px">
      <!--<thead>
        <tr>
          <td width="1" style="text-align: center;"><input type="checkbox" /></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_type; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_total; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_assigned; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_unassigned; ?></a></td>       
          <td class="right"></td>
        </tr>
      </thead>-->
      <tbody id="room_list">

      </tbody>
    </table>
  </form>
</div>
   <div id="auto_room_wrapper" style="display: none;">
       <div style="margin-bottom:5px"><?php echo $text_auto_room; ?></div>
       <div class="advance-search-block" style="display: block;">
           <div style="margin-bottom:5px"><?php echo $text_room; ?></div>
           <p id="auto_room"></p>

           <div style="margin-bottom:5px"><?php echo $text_bed; ?></div>
           <p id="auto_bed"></p>

           <input type="button" value="<?php echo $text_confirm; ?>"  onclick="chooseRoom()" style="width:70px;margin: 10px 0px 0px 10px;"/><input type="button" value="<?php echo $text_cancel_search; ?>"  onclick="$('#auto_room_wrapper').hide()" style="width:70px;margin: 10px 0px 0px 10px;"/>
       </div>
   </div>

   <div id="choose-bed-form-back" class="loading-form-back"></div>
   <div id="choose-bed-form" class="choose-bed-form">
       <div class="fbody">
           <div id="room_choose_name" style="margin-bottom:5px"></div>


           <div style="margin-bottom:5px"><?php echo $text_bed; ?>
               <select id="choose_room_bed">
                   <option value=""></option>
                   <option value="1">1</option>
                   <option value="2">2</option>
                   <option value="3">3</option>
                   <option value="4">4</option>
                   <option value="5">5</option>
                   <option value="6">6</option>
                   <option value="7">7</option>
                   <option value="8" selected="selected">8</option>
               </select></div>


           <input type="button" value="<?php echo $text_confirm; ?>"  onclick="searchStudentByMSSV()" style="width:70px;margin: 10px 0px 0px 10px;"/><input type="button" value="<?php echo $text_cancel_search; ?>"  onclick="showPopupChooseBed(false);" style="width:70px;margin: 10px 0px 0px 10px;"/>
       </div>
   </div>
<script type="text/javascript"><!--
//start vlmn modification
var mssv = '';
var selected_room = 0;
var selected_bed = 0;

function chooseRoom() {
    $.ajax({
        url: 'index.php?route=sale/customer_group/chooseRoom&token=<?php echo $token; ?>',
        type: 'POST',
        data: 'student_id=' + mssv + '&selected_room=' + selected_room + '&selected_bed=' + selected_bed,
        dataType: 'json',
        success: function(json) {
            loadingForm(false);
            //console.log(json);
            if(json['success']) {
               updatelist();
            }
        },
        error : function(error) {
            loadingForm(false);
            alert("Co loi!");
            console.log(error);
        }
    });
}
function onClickCellRoom(id) {
    if(selected_room != id) {
        $("td[id^='cell_room_']").each(function () {
            $(this).css("background", $(this).attr('name'));
        });

        $("#cell_room_" + id).css("background", "#33cc00");

        $("#room_choose_name").html('<?php echo $text_room; ?>' + ": " + $("#cell_room_" + id).attr('title'));

        showPopupChooseBed(true);
    }
    else {
        selected_room = 0;
        $("#cell_room_" + id).css("background", $("#cell_room_" + id).attr('name'));
    }
}
function showPopupChooseBed(show) {
    //toggle show
    if(show)
    {
        //show box
        var left = ($(window).width() - $('#choose-bed-form').width()) / 2;
        var top = ($(window).height() - $('#choose-bed-form').height()) / 2;
        $('#choose-bed-form').css('left',left + 'px');
        $('#choose-bed-form').css('top',top + 'px');
        $('#loading-form-back').fadeIn(400);
        $('#choose-bed-form').fadeIn(400);
    }
    else
    {
        $('#loading-form-back').fadeOut(400);
        $('#choose-bed-form').fadeOut(400);
    }
}
function autoSuggestRoom() {
    $.ajax({
        url: 'index.php?route=sale/customer_group/autoSuggestRoom&token=<?php echo $token; ?>',
        type: 'post',
        data: '',
        dataType: 'json',
        success: function(json) {
            loadingForm(false);
            console.log(json);
            if(json['room_info']) {
                var room  = json['room_info'];
                selected_room = parseInt(room['room_id']);
                selected_bed = parseInt(room['bed']);

                $("#cell_room_" + selected_room).css("background", '#33cc00');

                $("#auto_room").html(room['room_name']);
                $("#auto_bed").html(room['bed']);
                $("#auto_room_wrapper").fadeIn();
            }
        },
        error : function(error) {
            loadingForm(false);
            alert("Không tìm thấy sinh viên này!")
            console.log(error);
        }
    });
}
function advanceSearch(flag) {
    if(flag) {
        $("#advance_search").slideDown(200);
    }
    else {
        $("#advance_search").slideUp(200);
    }
}
function searchStudentByMSSV() {
    mssv = $("#student_id_input").val();
    if(mssv == '') {
        return;
    }

    loadingForm(true);
    $.ajax({
        url: 'index.php?route=sale/customer_group/getStudentInfo&token=<?php echo $token; ?>',
        type: 'post',
        data: 'student_id=' + mssv,
        dataType: 'json',
        success: function(json) {
            loadingForm(false);
            //console.log(json);
            if(json['student']) {
                var student = json['student'];

                $("#student_found_mssv").html(mssv);
                $("#student_image").attr("src",'../image/portrait/' + student['portrait']);
                $("#student_found_mssv").fadeIn();
                $("#student_image").fadeIn();

                //suggest room
                autoSuggestRoom();
            }
        },
        error : function(error) {
            loadingForm(false);
            alert("Không tìm thấy sinh viên này!")
            console.log(error);
        }
    });
}
//end vlmn modification
 $(document).ready(function(){
  function updateList(change)
  {
  var blockno = document.getElementById("block_select");
  var block = blockno.options[blockno.selectedIndex].value;
  var floorno = document.getElementById("floor_select");
  var floor = floorno.options[floorno.selectedIndex].value;
  var statusno = document.getElementById("status_select");
  var status = statusno.options[statusno.selectedIndex].value;
  var typeno = document.getElementById("type_select");
  var type = typeno.options[typeno.selectedIndex].value;
  var from = $('#from_text').val();
  var to = $('#to_text').val();
  if(change=='block')
  {
    floor=0;
  }

  $.ajax({    //create an ajax request to load_page.php
    type: "GET",
    url: "<?php echo html_entity_decode($link) ?>"+"&filter_block="+block+"&filter_floor="+floor,             
    dataType: "json",               
    success: function(data){

      
      $('#rightcol').empty();
      
      if(change=='block')
      {
        $('#floor_select').empty();
        $('#floor_select').append($('<option></option').val(0).text('<?php echo $text_all; ?>'));  
        $.each(data.list_floors, function(key, value) {   
          $('#floor_select').append($('<option></option').val(key).text(value));  
        });
      }
      if(floor == 0)
      {
      for(var i in data.rooms)
        {          
              
          table = '<table class="list" style="margin-top:10px">';
//          table += '<thead>';
//          table += '<tr>';
//          //table += '<td width="1" style="text-align: center;"><input type="checkbox" /></td>';
//          table += ' <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a></td>';
//          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_type; ?></a></td>';
//          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_total; ?></a></td>';
//          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_assigned; ?></a></td>';
//          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_unassigned; ?></a></td>';
//          table += '<td class="right"></td>';
//          table += '</tr>';
//          table += '</thead>';
          table += '<tbody id="room_list" style="margin-bottom:20px;">';
          count = 0;
          max_total = 0;
          assigned=0;
          table += '<tr>';
          for (var j in data.rooms[i]) {
            var room = data.rooms[i][j];
            if((from>to || (from == '0' && to == '0') || (from <= room.max_student && to >= room.max_student )) && (type=='0' || type==room.type_id) && (status=='0' || (status=='1' && room.max_student==room.assigned) ||(status=='2' && room.max_student>room.assigned) || (status=='3' && room.assigned==0)))
            {
            
            link = room.action;
            //table += '<td style="text-align: center;"><input type="checkbox" name="selected[]" value="'+room.id+'" /></td>';
            table += '<td title="' + room.name + '"  onclick="onClickCellRoom(' + room.room_id + ')"' + ' name="' + ((room.type == 'Hộ gia đình') ? '#ccc;' : ((parseInt(room.assigned) == 0) ? '#fff;' : ((parseInt(room.assigned) < parseInt(room.max_student)) ? '#ffff00' : ((parseInt(room.assigned) >= parseInt(room.max_student)) ? '#ec0c0c' : ''))))  + '" id="cell_room_' + room.room_id + '" class="room_cell" style="'+ ((room.type == 'Hộ gia đình') ? 'background:#ccc;' : ((parseInt(room.assigned) == 0) ? 'background:#fff;' : ((parseInt(room.assigned) < parseInt(room.max_student)) ? 'background:#ffff00' : ((parseInt(room.assigned) >= parseInt(room.max_student)) ? 'background:#ec0c0c' : '')))) + '">' +
                    '<a class="room_name">'+room.name +((room.type != 'Hộ gia đình') ? ': ' + room.assigned + '/' + room.max_student  : '') + '</a><br /><a class="room_edit" href="'+link[0].href+'">'+link[0].text+'</a>&nbsp;&nbsp;&nbsp;<a class="room_edit" href="'+link[1].href+'">'+link[1].text+'</a></td>';
//            table += '<td class="right">'+room.type+'</td>';
//            table += '<td class="right">'+room.max_student+'</td>';
//            table += '<td class="right">'+room.assigned+'</td>';
//            table += '<td class="right">'+(room.max_student-room.assigned).toString()+'</td>';
//            table += '<td class="right"><a href="'+link[1].href+'">'+link[1].text+'</a></td>';

            }
            count++;
            max_total=max_total+parseInt(room.max_student);
            assigned=assigned+parseInt(room.assigned);
          }
          table += '</tr>'
          table += '</tbody>';
          table += '</table>';

              info = '<?php echo $text_numroom; ?>: '+count+ ' | <?php echo $column_total; ?>: '+max_total+ ' | <?php echo $text_numassigned; ?>: '+assigned+' | <?php echo $text_numunassigned; ?>: '+(max_total - assigned).toString()+'<br />';
              table = '<div class="colorboxOuter" style="margin-bottom:0px;">' +
                      '<div id="errorViewWIE" class="colorboxWrapper2">' +
                       '<div class="colorbox2"><div class="gray"></div><p class="text"><?php echo $text_resident; ?></p></div>' +
                        '<div class="colorbox2"><div class="red"></div><p class="text"><?php echo $text_full; ?></p></div>' +
                        '<div class="colorbox2"><div class="yellow"></div><p class="text"><?php echo $text_almost_full; ?></p></div>' +
                        '<div class="colorbox2"><div class="white"></div><p class="text"><?php echo $text_empty; ?></p></div>' +
                        '<div class="colorbox2"><div class="green"></div><p class="text"><?php echo $text_current; ?></p></div>' +
                        '</div>' +
                        '</div><div class="heading"><h2>'+data.list_floors[i]+'</h2>' + info + '</div>' + table;
          $('#rightcol').append(table);
        }

              
      }
      else 
      {
        
        
        table = '<table class="list" style="margin-top:10px">';
//        table += '<thead>';
//        table += '<tr>';
//        table += '<td width="1" style="text-align: center;"><input type="checkbox" /></td>';
//        table += ' <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a></td>';
//        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_type; ?></a></td>';
//        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_total; ?></a></td>';
//        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_assigned; ?></a></td>';
//        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_unassigned; ?></a></td>';
//        table += '<td class="right"></td>';
//        table += '</tr>';
//        table += '</thead>';
        table += '<tbody id="room_list">';
        count = 0;
          max_total = 0;
          assigned=0;
        for (var j in data.rooms[floor]) {
          var room = data.rooms[floor][j];
              if((from>to || (from == '0' && to == '0') || (from <= room.max_student && to >= room.max_student )) && (type=='0' || type==room.type_id) && (status=='0' || (status=='1' && room.max_student==room.assigned) ||(status=='2' && room.max_student>room.assigned) || (status=='3' && room.assigned==0)))
            {
          
          link = room.action;
          table += '<tr>';
          table += '<td style="text-align: center;"><input type="checkbox" name="selected[]" value="'+room.room_id+'" /></td>';
          table += '<td class="left"><a href="'+link[0].href+'">'+room.name+'</td>';
          table += '<td class="right">'+room.type+'</td>';
          table += '<td class="right">'+room.max_student+'</td>';
          table += '<td class="right">'+room.assigned+'</td>';
          table += '<td class="right">'+(room.max_student-room.assigned).toString()+'</td>';                   
          table += '<td class="right"><a href="'+link[1].href+'">'+link[1].text+'</a></td>';
          table += '</tr>';
        }
          count++;
            max_total=max_total+parseInt(room.max_student);
            assigned=assigned+parseInt(room.assigned);
        }
        table += '</tbody>';
        table += '</table>';
        table += '</form>';
        info = '<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">';
        info += '<div class="heading">';
        info += '<h2>'+data.list_floors[floor]+'</h2>';
        info += '<?php echo $text_numroom; ?>: '+count+ ' | <?php echo $column_total; ?>: '+max_total+ ' | <?php echo $text_numassigned; ?>: '+assigned+' | <?php echo $text_numunassigned; ?>: '+(max_total - assigned).toString()+'<br />';        
        info += '<div class="buttons" style="margin-top:15px"><a id="add_room" href="<?php echo $insert; ?>&floor='+floor+'" class="button"><?php echo $button_insert; ?></a>  <a onclick="$(\'form\').submit();" class="button"><?php echo $button_delete; ?></a></div>';
        info += '</div>';
        table = info+table;
        $('#rightcol').append(table);

      }
      if(change=='block' && block!='0')
      {
          info = '<h2><?php echo $text_info; ?></h2>';
          info += '<?php echo $text_numfloor; ?>: '+data.block_info[0].count+'<br />';
          info += '<?php echo $column_total ?>: '+data.block_info[0].max_total+'<br />';
          info += '<?php echo $text_numassigned; ?>: '+data.block_info[0].assigned+'<br />';
          $('#block_info').html(info);
      }

    }
  });
}

    $('#block_select').on('change', function() {updateList('block')});
    $('#floor_select').on('change', function() {updateList('floor')});
    $('#status_select').on('change', function() {updateList('status')});
    $('#type_select').on('change', function() {updateList('type')});
    $('#filter_btn').click(function() {updateList('filter')});
    updateList('block');


//$('#block_select').change();
  });
--></script>

</div>
</div>

</div>
<?php echo $footer; ?> 