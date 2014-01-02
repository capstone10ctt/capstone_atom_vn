<?php 
/////////////////////// Modification//////////////////////
    // ID: 1051011
    // Name: Dinh Hai Nguyen
    // Class:  10CTT
    // Date created: 26/12/2013
    // Description: Add block, floor, room manage to page
    // Date modified: 1/1/2014
    //////////////////////////////////////////////////////////////
if(isset($_GET["block"]))
{
    if ($floors) {
      echo '<table style="background-color:#333;width:600px;color:#fff;border-collapse: collapse;">'."\n";
      foreach ($floors as $floor) {?>

  <tr>
    <td class="fl" style="color:#fff;padding:30px;border-width: 1px;border-style: solid;border-color: #666666;">
    <div class="id" style="visibility: hidden"><?php echo $floor['id']; ?></div>
    <?php echo $floor['name']; ?></td>
  </tr>
      <?php
      }
      echo '</table>';
    }
    return;
}
if(isset($_GET["floor"]))
{
    ?>
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
            <?php if ($customer_groups) { ?>
            <?php foreach ($customer_groups as $customer_group) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($customer_group['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $customer_group['customer_group_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $customer_group['name']; ?></td>
              <td class="right"><?php echo $customer_group['sort_order']; ?></td>
              <td class="right"><?php foreach ($customer_group['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="4"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      
    <?php
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
  <div class="box" style="overflow:hidden;position:relative;height:500px;">
  <div id="block" style="height:200px;position:relative;top:0;color:#fff;text-alignment:center">
      <?php if ($blocks) { ?>
            <?php foreach ($blocks as $block) { ?>
          <div class="bl" style="width:200px;height:300px;background-color:#333;float:left;margin-right:10px;">
          <div class="id" style="visibility: hidden"><?php echo $block['id']; ?></div>
          <?php echo $block['name']; ?></div>
          <?php } }?>

    </div>
  <div id="floor" style=" height:200px;position:relative;color:#fff;">
  
  </div>
    <div id="room" style="position:relative">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons" id="add_room"><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      
    </div>
    </div>
  </div>
  <script type="text/javascript">
    $(document).ready(function(){
      var block_offset = $("#block").offset();
      var distance = $(".box").width()+30;
      $('#floor').offset({ top: block_offset.top, left: distance})
      $('#room').offset({ top: block_offset.top, left:distance})
      
    $('.bl').click(function(){
        $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "<?php echo html_entity_decode($link) ?>"+"&block="+$(this).children('.id').text(),             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#floor").html(response); 
            $('.fl').click(function(){
        $('#room').stop().animate({
            left: 0    
        }, 400);
        $('#floor').stop().animate({
            left: -distance
        }, 400);
        $("#add_room a").attr('href', '<?php echo html_entity_decode($insert) ?>&floor='+$(this).children('.id').text());
        $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "<?php echo html_entity_decode($link) ?>"+"&floor="+$(this).children('.id').text(),             
        dataType: "html",   //expect html to be returned                
        success: function(response){                    
            $("#room").children('.content').html(response); 
            
          }});

    });
            //alert(response);
        }
        });
        $('#floor').stop().animate({
            left: 0    
        }, 400);
        $('#block').stop().animate({
            left: -distance    
        }, 400);                           
    });
    
});
    </script>
</div>
<?php echo $footer; ?> 