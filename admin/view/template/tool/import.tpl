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
    echo '<table class="list">';
    echo '<thead>';
    echo '<tr>';
    if($col_id!='')
      echo '<td>'.$entry_studentid.'</td>';
    if($col_name!='')
      echo '<td>'.$entry_name.'</td>';
    if($col_birthday!='')
      echo '<td>'.$entry_birthday.'</td>';
    if($col_faculty!='')
      echo '<td>'.$entry_faculty.'</td>';
    if($col_room!='')
      echo '<td>'.$entry_room.'</td>';
    if($col_bed!='')
      echo '<td>'.$entry_bed.'</td>';
    if($col_ethnic!='')
      echo '<td>'.$entry_ethnic.'</td>';
    if($col_address!='')
        echo '<td>'.$entry_address.'</td>';
    echo '<td>'.$entry_comment.'</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for ($i = 2; $i <= count($sheetData); $i++)
    {
      echo '<tr>';
      if($col_id!='')
        echo '<td>'.$sheetData[$i][$col_id].'</td>';
      
      if($col_name!='')
        echo '<td>'.$sheetData[$i][$col_name].'</td>';
      
      if($col_birthday!='')
        echo '<td>'.$sheetData[$i][$col_birthday].'</td>';
      
      if($col_faculty!='')
        echo '<td>'.$sheetData[$i][$col_faculty].'</td>';
      
      if($col_room!='')
        echo '<td>'.$sheetData[$i][$col_room].'</td>';
      
      if($col_bed!='')
        echo '<td>'.$sheetData[$i][$col_bed].'</td>';
      
      if($col_ethnic!='')
        echo '<td>'.$sheetData[$i][$col_ethnic].'</td>';
      
      if($col_address!='')
        echo '<td>'.$sheetData[$i][$col_address].'</td>';
      
      if (in_array($sheetData[$i][$col_room], $roomList))
        echo '<td></td>';
      else
        echo '<td>'.$error_roomnotfound.'</td>';

      echo '</tr>';

    }
    echo '</tbody>';
    echo '</table>';
    }
    else if($file_type=="watere")
    {
      
      date_default_timezone_set('Asia/Saigon');
      $currentdate = date('m/d/Y h:i:s a', time());
    echo '<table class="list">';
    echo '<thead>';
    echo '<tr>';
    if($col_room!='')
      echo '<td>'.$entry_room.'</td>';
    if($col_estart!='')
      echo '<td>'.$entry_estart.'</td>';
    if($col_eend!='')
      echo '<td>'.$entry_eend.'</td>';
    if($col_wstart!='')
      echo '<td>'.$entry_wstart.'</td>';
    if($col_wend!='')
      echo '<td>'.$entry_wend.'</td>';
    echo '<td>'.$entry_dateadded.'</td>';
    echo '<td>'.$entry_comment.'</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for ($i = 2; $i <= count($sheetData); $i++)
    {
      echo '<tr>';
      if($col_room!='')
        echo '<td>'.$sheetData[$i][$col_room].'</td>';
      
      if($col_estart!='')
        echo '<td>'.$sheetData[$i][$col_estart].'</td>';
      
      if($col_eend!='')
        echo '<td>'.$sheetData[$i][$col_eend].'</td>';
      
      if($col_wstart!='')
        echo '<td>'.$sheetData[$i][$col_wstart].'</td>';
      
      if($col_wend!='')
        echo '<td>'.$sheetData[$i][$col_wend].'</td>';
      
      if($col_addeddate!='' && trim($sheetData[$i][$col_addeddate])!='')
        echo '<td>'.$sheetData[$i][$col_addeddate].'</td>';
      else
        echo '<td>'.$currentdate.'</td>';
      
      if (in_array($sheetData[$i][$col_room], $roomList))
        echo '<td></td>';
      else
        echo '<td>'.$error_roomnotfound.'</td>';
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