<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error!='') { ?>
  <div class="warning"><?php echo $error; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/backup.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
      <?php if($uploaded!='') {?>
      <a onclick="$('#import').submit();" class="button"><?php echo $button_import; ?></a>
      <?php } ?>
      <a onclick="$('#upload').submit();" class="button"><?php echo $button_upload; ?></a></div>
    </div>
    <div class="content">

      <form action="<?php echo $upload; ?>" method="post" enctype="multipart/form-data" id="upload">
        <table class="form">
          <tr>
            <td><?php echo $entry_uploaddata; ?></td>
            <td><input type="file" name="file" /></td>
            <input type="hidden" name="upload">
          </tr>
        </table>
      </form>
      <form action="<?php echo $import; ?>" method="post" id="import">
      <input type="hidden" name="import">
        <?php if($this->session->data['file_type']=="student")
    {
    echo '<table class="list" id="studentlist">';
    echo '<thead>';
    echo '<tr>';
    if($this->session->data['col_id']!='')
      echo '<td>'.$entry_studentid.'</td>';
    if($this->session->data['col_name']!='')
      echo '<td>'.$entry_name.'</td>';
    if($this->session->data['col_birthday']!='')
      echo '<td>'.$entry_birthday.'</td>';
    if($this->session->data['col_faculty']!='')
      echo '<td>'.$entry_faculty.'</td>';
    if($this->session->data['col_room']!='')
      echo '<td>'.$entry_room.'</td>';
    if($this->session->data['col_bed']!='')
      echo '<td>'.$entry_bed.'</td>';
    if($this->session->data['col_ethnic']!='')
      echo '<td>'.$entry_ethnic.'</td>';
    if($this->session->data['col_address']!='')
        echo '<td>'.$entry_address.'</td>';
    echo '<td>'.$entry_comment.'</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for ($i = 2; $i <= count($this->session->data['sheetData']); $i++)
    {
      $warning = false;
      if (in_array($this->session->data['sheetData'][$i][$this->session->data['col_room']], $roomList))
        echo '<tr>';
      else
      {
        $warning = true;
        echo '<tr class="warning">';
      }
      if($this->session->data['col_id']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_id']].'</td>';
      
      if($this->session->data['col_name']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_name']].'</td>';
      
      if($this->session->data['col_birthday']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_birthday']].'</td>';
      
      if($this->session->data['col_faculty']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_faculty']].'</td>';
      
      if($this->session->data['col_room']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_room']].'</td>';
      
      if($this->session->data['col_bed']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_bed']].'</td>';
      
      if($this->session->data['col_ethnic']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_ethnic']].'</td>';
      
      if($this->session->data['col_address']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_address']].'</td>';
      
      if (!$warning)
        echo '<td></td>';
      else
        echo '<td>'.$error_roomnotfound.'</td>';

      echo '</tr>';

    }
    echo '</tbody>';
    echo '</table>';
    }
    else if($this->session->data['file_type']=="watere")
    {
      
      date_default_timezone_set('Asia/Saigon');
      $currentdate = date('m/d/Y h:i:s a', time());
    echo '<table class="list" id="waterelist">';
    echo '<thead>';
    echo '<tr>';
    if($this->session->data['col_room']!='')
      echo '<td>'.$entry_room.'</td>';
    if($this->session->data['col_estart']!='')
      echo '<td>'.$entry_estart.'</td>';
    if($this->session->data['col_eend']!='')
      echo '<td>'.$entry_eend.'</td>';
    if($this->session->data['col_wstart']!='')
      echo '<td>'.$entry_wstart.'</td>';
    if($this->session->data['col_wend']!='')
      echo '<td>'.$entry_wend.'</td>';
    echo '<td>'.$entry_dateadded.'</td>';
    echo '<td>'.$entry_comment.'</td>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    for ($i = 2; $i <= count($this->session->data['sheetData']); $i++)
    {
      $warning = false;
      if (in_array($this->session->data['sheetData'][$i][$this->session->data['col_room']], $roomList))
        echo '<tr>';
      else
      {
        echo '<tr class="warning">';
        $warning = true;
      }
      if($this->session->data['col_room']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_room']].'</td>';
      
      if($this->session->data['col_estart']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_estart']].'</td>';
      
      if($this->session->data['col_eend']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_eend']].'</td>';
      
      if($this->session->data['col_wstart']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_wstart']].'</td>';
      
      if($this->session->data['col_wend']!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_wend']].'</td>';
      
      if($this->session->data['col_addeddate']!='' && trim($this->session->data['sheetData'][$i][$this->session->data['col_addeddate']])!='')
        echo '<td>'.$this->session->data['sheetData'][$i][$this->session->data['col_addeddate']].'</td>';
      else
        echo '<td>'.$currentdate.'</td>';
      
      if (!$warning)
        echo '<td></td>';
      else
        echo '<td>'.$error_roomnotfound.'</td>';
      echo '</tr>';

    }
    echo '</tbody>';
    echo '</table>';
    }
    ?>
    </form>
    </div>
  </div>
</div>

<?php echo $footer; ?>