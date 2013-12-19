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
    <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
    <div class="buttons"><a onclick="window.close()" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td><a href="<?php echo $sort_module; ?>"><?php echo $column_module; ?></a>
              <td><a href="<?php echo $sort_folder; ?>"><?php echo $column_folder; ?></a>
              <td><a href="<?php echo $sort_file; ?>"><?php echo $column_file; ?></a>
              <td><a href="<?php echo $sort_variable; ?>"><?php echo $column_variable; ?></a>
              <td><a href="<?php echo $sort_translation_source; ?>"><?php echo $column_translation_source; ?></a>
              <td><a href="<?php echo $sort_translation_destination; ?>"><?php echo $column_translation_destination; ?></a>
              <td><?php echo $column_message; ?></a>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($messages) { ?>
            <?php foreach ($messages as $message) { ?>
            <tr>
              <td><?php echo $message['module']; ?></td>
              <td><?php echo $message['folder']; ?></td>
              <td><?php echo $message['file']; ?></td>
              <td><?php echo $message['variable']; ?></td>
              <td><?php echo $message['translation_source']; ?></td>
              <td><?php echo $message['translation_destination']; ?></td>
              <td><?php echo $message['message']; ?></td>
              <td class="right"><?php foreach ($message['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>" target="_blank"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="8"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>