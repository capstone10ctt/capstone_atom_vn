<?php echo $header; ?>
<?php $floor=0;
if(isset($_GET['floor']))
  {
    $floor =$_GET['floor'];
  }?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <input type="hidden" name="floor" value="<?php echo $floor; ?>">
        <table class="form">
          <tr>
            <td><span class="required">*</span> <?php echo $entry_name; ?></td>
            <td><?php foreach ($languages as $language) { ?>
              <input type="text" name="customer_group_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['name'] : ''; ?>" />
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /><br />
              <?php if (isset($error_name[$language['language_id']])) { ?>
              <span class="error"><?php echo $error_name[$language['language_id']]; ?></span><br />
              <?php } ?>
              <?php } ?></td>
          </tr>
          <tr>
            <td><?php echo $column_total; ?></td>
            <td><input type="number" name="max_student" value="<?php echo isset($customer_group['max_student']) ? $customer_group['max_student'] : ''; ?>"/></td>
          </tr>
         <?php if(isset($students) && !is_null($students) && !empty($students)) 
         { ?>
          <tr>
            <td><?php echo $text_roomleader; ?></td>
            <td>
              <select name="room_leader" >
                <option value="0"></option>
              <?php foreach ($students as $student)  {
                  echo '<option value="'.$student['customer_id'].'" ';
                  echo (isset($customer_group['room_leader']) && $customer_group['room_leader']==$student['customer_id']) ? 'selected' : '';
                  echo '>'.$student['student_id'].' - '.$student['firstname'].' '.$student['lastname'].'</option>';
              }?>
              </select>
            </td>
          </tr>
        <?php } ?>
          <tr>
            <td><?php echo $column_type; ?></td>
            <td>
              <select name="type_id" >
              <?php foreach ($room_types as $room_type)  {
                  echo '<option value="'.$room_type['type_id'].'" ';
                  echo (isset($customer_group['type_id']) && $customer_group['type_id']==$room_type['type_id']) ? 'selected' : '';
                  echo '>'.$room_type['type_name'].'</option>';
              }?>
              </select>
            </td>
          </tr>
          <?php foreach ($languages as $language) { ?>
          <tr>
            <td><?php echo $entry_description; ?></td>
            <td><textarea name="customer_group_description[<?php echo $language['language_id']; ?>][description]" cols="40" rows="5"><?php echo isset($customer_group_description[$language['language_id']]) ? $customer_group_description[$language['language_id']]['description'] : ''; ?></textarea>
              <img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" align="top" /></td>
          </tr>
          <?php } ?>
        </table>
      </form>
    </div>
  </div>
</div>
<?php echo $footer; ?>