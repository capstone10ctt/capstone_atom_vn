<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
     
    </div>
    <div class="content">
        <form method="post"
          enctype="multipart/form-data">
          <label for="file"><?php echo $text_filedata ?>:</label>
          <input type="file" name="file" id="file" value="<?php echo $text_browse ?>">
          <input type="submit" name="submit" value="<?php echo $text_upload ?>">
        </form>
        <?php if($file_type=="student")
    {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<td>MSSV</td>';
    echo '<td>Tên</td>';
    echo '<td>Ngày Sinh</td>';
    echo '<td>Ngành</td>';
    echo '<td>Phòng</td>';
    echo '<td>Giường</td>';
    echo '<td>Dân tộc</td>';
    echo '<td>Địa chỉ</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for ($i = 2; $i <= count($sheetData); $i++)
    {
      echo '<tr>';
      if($col_id!='')
        echo '<td>'.$sheetData[$i][$col_id].'</td>';
      else
        echo '<td></td>';
      if($col_name!='')
        echo '<td>'.$sheetData[$i][$col_name].'</td>';
      else
        echo '<td></td>';
      if($col_birthday!='')
        echo '<td>'.$sheetData[$i][$col_birthday].'</td>';
      else
        echo '<td></td>';
      if($col_faculty!='')
        echo '<td>'.$sheetData[$i][$col_faculty].'</td>';
      else
        echo '<td></td>';
      if($col_room!='')
        echo '<td>'.$sheetData[$i][$col_room].'</td>';
      else
        echo '<td></td>';
      if($col_bed!='')
        echo '<td>'.$sheetData[$i][$col_bed].'</td>';
      else
        echo '<td></td>';
      if($col_race!='')
        echo '<td>'.$sheetData[$i][$col_race].'</td>';
      else
        echo '<td></td>';
      if($col_address!='')
        echo '<td>'.$sheetData[$i][$col_address].'</td>';
      else
        echo '<td></td>';
      echo '</tr>';

    }
    echo '</tbody>';
    echo '</table>';
    }
    else if($file_type=="watere")
    {
      date_default_timezone_set('Asia/Saigon');
      $currentdate = date('m/d/Y h:i:s a', time());
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<td>Phòng</td>';
    echo '<td>Điện cũ</td>';
    echo '<td>Điện mới</td>';
    echo '<td>Nước cũ</td>';
    echo '<td>Nước mới</td>';
    echo '<td>Ngày nhập</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for ($i = 2; $i <= count($sheetData); $i++)
    {
      echo '<tr>';
      if($col_room!='')
        echo '<td>'.$sheetData[$i][$col_room].'</td>';
      else
        echo '<td></td>';
      if($col_estart!='')
        echo '<td>'.$sheetData[$i][$col_estart].'</td>';
      else
        echo '<td></td>';
      if($col_eend!='')
        echo '<td>'.$sheetData[$i][$col_eend].'</td>';
      else
        echo '<td></td>';
      if($col_wstart!='')
        echo '<td>'.$sheetData[$i][$col_wstart].'</td>';
      else
        echo '<td></td>';
      if($col_wend!='')
        echo '<td>'.$sheetData[$i][$col_wend].'</td>';
      else
        echo '<td></td>';
      if($col_inputdate!='' && trim($sheetData[$i][$col_inputdate])!='')
        echo '<td>'.$sheetData[$i][$col_inputdate].'</td>';
      else
        echo '<td>'.$currentdate.'</td>';
      
      echo '</tr>';

    }
    echo '</tbody>';
    echo '</table>';
    }
    ?>
    </div>
  </div>
</div>
<?php echo $footer; ?>