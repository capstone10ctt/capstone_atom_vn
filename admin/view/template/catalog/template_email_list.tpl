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
      <h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><span><?php echo $button_delete; ?></span></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
		<div id="type4">
		<div style="text-align: right; padding-bottom: 15px;"><a href="<?php echo $mail_template_insert; ?>" class="button"><span><?php echo $button_mail; ?></span></a></div>
		<table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'mselected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php echo $column_id; ?></td>
				<td class="left"><?php echo $column_template_email; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($mails) { ?>
            <?php foreach ($mails as $mail) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($mail['selected']) { ?>
                <input type="checkbox" name="mselected[]" value="<?php echo $mail['id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="mselected[]" value="<?php echo $mail['id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $mail['name']; ?></td>
			  <td><?php echo $mail['template_name']; ?></td>
              <td class="right"><?php foreach ($mail['action'] as $action) { ?>
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
		</div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#templates a').tabs();

if ($("input[name='template_email_generate_invoice']").is(":checked")) {
  $("select[name='template_email_generate_invoice_status']").attr('disabled', 'disabled');
}

$("input[name='template_email_generate_invoice']").click(function() {
  if ($(this).is(":checked")) {
    $("select[name='template_email_generate_invoice_status']").attr('disabled', 'disabled');
  } else {
    $("select[name='template_email_generate_invoice_status']").removeAttr('disabled');
  }
});

if ($("input[name='template_email_send_invoice']").is(":checked")) {
  $(".date").removeAttr('disabled');
}

$("input[name='template_email_send_invoice']").click(function() {
  if ($(this).is(":checked")) {
    $(".date").removeAttr('disabled');
  } else {
    $(".date").attr('disabled', 'disabled');
  }
});

$('.date').datepicker({dateFormat: 'yy-mm-dd'});
//--></script> 
<?php echo $footer; ?> 