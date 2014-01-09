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
if(isset($_GET["floor"]))
{
	if ($customer_groups) {
		$data = new StdClass();
		$rooms = array();
    $numroom=0;
    $numassigned=0;
    $numassignedboy=0;
    $numassignedgirl=0;
    $numunassignedboy=0;
    $numunassignedgirl=0;
		foreach ($customer_groups as $customer_group)
   {
    $room = array();
    $room['id']= $customer_group['customer_group_id'];
    $room['name']=$customer_group['name'];
    $room['type']=$customer_group['type'];
    $room['max_student']=$customer_group['max_student'];
    $room['assigned']=$customer_group['assigned'];
    $room['unassigned']=$customer_group['max_student']-$customer_group['assigned'];
    $room['action']=$customer_group['action'];
    $numroom+=1;
    $numassigned+=$customer_group['assigned'];
    if($customer_group['type']=='Nam' || $customer_group['type']=='Boy')
    {
      $numassignedboy+=$customer_group['assigned'];
      $numunassignedboy+=$customer_group['max_student']-$customer_group['assigned'];
    }
    else
    {
      $numassignedgirl+=$customer_group['assigned'];
      $numunassignedgirl+=$customer_group['max_student']-$customer_group['assigned'];
    }
    $rooms[] = $room;
  }
  $data->rooms = $rooms;
  $data->numroom = $numroom;
  $data->numassigned = $numassigned;
  $data->numassignedboy = $numassignedboy;
  $data->numassignedgirl = $numassignedgirl;
  $data->numunassignedboy = $numunassignedboy;
  $data->numunassignedgirl = $numunassignedgirl;
    	//echo json_encode($customer_groups);
  echo json_encode($data);
}
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
     <select id="block_select" style="margin-bottom:30px">
      <?php if ($blocks) { ?>
      <?php foreach ($blocks as $block) { ?>
      <option value="<?php echo $block['id']; ?>"><?php echo $block['name']; ?></option>
      <?php echo $block['name']; ?></div></div>
      <?php } }?>
    </select> 
    <div style="margin-bottom:5px"><?php echo $text_floor; ?></div>
    <select id="floor_select" style="margin-bottom:5px">
    </select>
    <div id="floor_info"></div> 
  </div>

  <div id="rightcol" style="margin-left:200px;text-alignment:left">
   <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
     <div class="heading">

       <div class="buttons"><a id="add_room" href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a>  <a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
     </div>
     <table class="list" style="margin-top:10px">
      <thead>
        <tr>
          <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
          <td class="left"><?php if ($sort == 'cgd.name') { ?>
            <a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
            <?php } else { ?>
            <a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
            <?php } ?></td>
            <td class="right"><?php if ($sort == 'cg.sort_order') { ?>
              <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_type; ?></a>
              <?php } else { ?>
              <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_type; ?></a>
              <?php } ?></td> 
              <td class="right"><?php if ($sort == 'cg.sort_order') { ?>
                <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_total; ?></a>
                <?php } ?></td>               
                <td class="right"><?php if ($sort == 'cg.sort_order') { ?>
                  <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_assigned; ?></a>
                  <?php } else { ?>
                  <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_assigned; ?></a>
                  <?php } ?></td>               
                  <td class="right"><?php if ($sort == 'cg.sort_order') { ?>
                    <a href="<?php echo $sort_sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_unassigned; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_sort_order; ?>"><?php echo $column_unassigned; ?></a>
                    <?php } ?></td>               
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

            $('#block_select').on('change', function() {

	  			$.ajax({    //create an ajax request to load_page.php
           type: "GET",
           url: "<?php echo html_entity_decode($link) ?>"+"&block="+$(this).val(),             
           dataType: "json",               
           success: function(data){

            $('#floor_select').empty();
            $.each(data, function(key, value) {   
             $('#floor_select')
             .append($('<option>', { value : key })
              .text(value)); 
           });
            $('#floor_select').change();
          }
        })
       });
            $('#floor_select').on('change', function() {
              $("#add_room").attr('href', '<?php echo html_entity_decode($insert) ?>&floor='+$(this).val());
              $('#room_list').empty();
              $('#floor_info').empty()  ;
	  			$.ajax({    //create an ajax request to load_page.php
           type: "GET",
           url: "<?php echo html_entity_decode($link) ?>"+"&floor="+$(this).val(),             
           dataType: "json",               
           success: function(data){	
            
            for (var i in data.rooms) {
              var room = data.rooms[i];
              link = room.action;
              row = '<tr>';
              row += '<td style="text-align: center;"><input type="checkbox" name="selected[]" value="'+room.id+'" /></td>';
              row += '<td class="left"><a href="'+link[0].href+'">'+room.name+'</td>';
              row += '<td class="right">'+room.type+'</td>';
              row += '<td class="right">'+room.max_student+'</td>';
              row += '<td class="right">'+room.assigned+'</td>';
              row += '<td class="right">'+room.unassigned+'</td>';                   
              
              row += '<td class="right"><a href="'+link[1].href+'">'+link[1].text+'</a></td>';
              row += '</tr>'

              $('#room_list:last').append(row);
            }
              //info = '<?php echo $text_info; ?><br />';
              info = '';
              info += '<?php echo $text_numroom; ?>: '+data.numroom+'<br />';
              info += '<?php echo $text_numassigned; ?>: '+data.numassigned+'<br />';
              info += '<?php echo $text_numassignedboy; ?>: '+data.numassignedboy+'<br />';
              info += '<?php echo $text_numunassignedboy; ?>: '+data.numunassignedboy+'<br />';
              info += '<?php echo $text_numassignedgirl; ?>: '+data.numassignedgirl+'<br />';
              info += '<?php echo $text_numunassignedgirl; ?>: '+data.numunassignedgirl+'<br />';
              $('#floor_info').html(info);
          }  
        })

});

$('#block_select').change();
});
</script>

</div>

</div>
<?php echo $footer; ?> 