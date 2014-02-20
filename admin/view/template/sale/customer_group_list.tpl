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
  <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
  <div class="box" style="padding:30px">
   <div id="leftcol" style="float:left;width:200px;text-alignment:left">
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

  <div id="rightcol" style="margin-left:200px;text-alignment:left">
   <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
     <div class="heading">

       <div class="buttons"><a id="add_room" href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>  <a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
     </div>
     <table class="list" style="margin-top:10px">
      <thead>
        <tr>
          <td width="1" style="text-align: center;"><input type="checkbox" /></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_type; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_total; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_assigned; ?></a></td>
          <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_unassigned; ?></a></td>       
          <td class="right"></td>
        </tr>
      </thead>
      <tbody id="room_list">

      </tbody>
    </table>
  </form>
</div>
<script type="text/javascript">
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
          table += '<thead>';
          table += '<tr>';
          //table += '<td width="1" style="text-align: center;"><input type="checkbox" /></td>';
          table += ' <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a></td>';
          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_type; ?></a></td>';
          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_total; ?></a></td>';
          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_assigned; ?></a></td>';
          table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_unassigned; ?></a></td>';      
          table += '<td class="right"></td>';
          table += '</tr>';
          table += '</thead>';
          table += '<tbody id="room_list">';
          count = 0;
          max_total = 0;
          assigned=0;
          for (var j in data.rooms[i]) {
            var room = data.rooms[i][j];
            if((from>to || (from == '0' && to == '0') || (from <= room.max_student && to >= room.max_student )) && (type=='0' || type==room.type_id) && (status=='0' || (status=='1' && room.max_student==room.assigned) ||(status=='2' && room.max_student>room.assigned) || (status=='3' && room.assigned==0)))
            {
            
            link = room.action;
            table += '<tr>';
            //table += '<td style="text-align: center;"><input type="checkbox" name="selected[]" value="'+room.id+'" /></td>';
            table += '<td class="left"><a href="'+link[0].href+'">'+room.name+'</td>';
            table += '<td class="right">'+room.type+'</td>';
            table += '<td class="right">'+room.max_student+'</td>';
            table += '<td class="right">'+room.assigned+'</td>';
            table += '<td class="right">'+(room.max_student-room.assigned).toString()+'</td>';                   
            table += '<td class="right"><a href="'+link[1].href+'">'+link[1].text+'</a></td>';
            table += '</tr>'
          }
            count++;
            max_total=max_total+parseInt(room.max_student);
            assigned=assigned+parseInt(room.assigned);
          }
          table += '</tbody>';
          table += '</table>';

              info = '<?php echo $text_numroom; ?>: '+count+ ' | <?php echo $column_total; ?>: '+max_total+ ' | <?php echo $text_numassigned; ?>: '+assigned+' | <?php echo $text_numunassigned; ?>: '+(max_total - assigned).toString()+'<br />';
              table = '<div class="heading"><h2>'+data.list_floors[i]+'</h2>' + info + '</div>'+table;
          $('#rightcol').append(table);
        }

              
      }
      else 
      {
        
        
        table = '<table class="list" style="margin-top:10px">';
        table += '<thead>';
        table += '<tr>';
        table += '<td width="1" style="text-align: center;"><input type="checkbox" /></td>';
        table += ' <td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a></td>';
        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_type; ?></a></td>';
        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_total; ?></a></td>';
        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_assigned; ?></a></td>';
        table += '<td class="left"><a href="<?php echo $sort_name; ?>"><?php echo $column_unassigned; ?></a></td>';      
        table += '<td class="right"></td>';
        table += '</tr>';
        table += '</thead>';
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
          table += '<td style="text-align: center;"><input type="checkbox" name="selected[]" value="'+room.id+'" /></td>';
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
        info += '<div class="buttons" style="margin-top:15px"><a id="add_room" href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>  <a onclick="$(\'form\').submit();" class="button"><?php echo $button_delete; ?></a></div>';
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
    $('#typeno_select').on('change', function() {updateList('type')});
    $('#filter_btn').click(function() {updateList('filter')});
    updateList('block');


//$('#block_select').change();
  });
</script>

</div>

</div>
<?php echo $footer; ?> 