<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
        <h1><?php echo $text_boss_catalog; ?></h1>
        <div class="htabs">
             <a href="<?php echo $boss_category; ?>" style="display: inline;"><?php echo $text_boss_category ; ?></a>
             <a href="<?php echo $boss_articles; ?>" style="display: inline;"><?php echo $text_boss_articles; ?></a>
             <a href="<?php echo $boss_comments; ?>" style="display: inline;"><?php echo $text_boss_comments; ?></a>
             <a class="selected" href="<?php echo $boss_settings; ?>" style="display: inline;"><?php echo $text_boss_settings; ?></a>
         </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
   <div class="box">
        <div class="heading">
          <h1><img src="view/image/setting.png" alt="" /> <?php echo $heading_title; ?></h1>
          <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a></div>
        </div>
        
        <div class="content">
            <div id="tabs" class="htabs">
                <a href="#tab-general"><?php echo $tab_general; ?></a>
                <a href="#tab-option"><?php echo $tab_option; ?></a>
                <a href="#tab-image"><?php echo $tab_image; ?></a>
            </div>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
            <div id="tab-general">
                <table class="form">
                    <tr>
                      <td><span class="required">*</span> <?php echo $entry_name; ?></td>
                      <td>
                      <input type="text" name="config_blog_name" value="<?php echo $config_blog_name; ?>" size="40" />
                        <?php if ($error_blog_name) { ?>
                        <span class="error"><?php echo $error_blog_name; ?></span>
                        <?php } ?></td>
                    </tr> 
                    <tr>
                      <td><?php echo $entry_keyword; ?></td>
                      <td><input type="text" name="keyword" value="<?php echo $keyword; ?>" /></td>
                    </tr>               
                  </table>
            </div>
            
            <div id="tab-option">
                 <h2><?php echo $text_items; ?></h2>
                  <table class="form">
                    <tr>
                      <td><span class="required">*</span> <?php echo $entry_bossblog_limit; ?></td>
                      <td><input type="text" name="config_bossblog_limit" value="<?php echo $config_bossblog_limit; ?>" size="3" />
                        <?php if ($error_bossblog_limit) { ?>
                        <span class="error"><?php echo $error_bossblog_limit; ?></span>
                        <?php } ?></td>
                    </tr>
                    <tr>
                      <td><span class="required">*</span> <?php echo $entry_blog_admin_limit; ?></td>
                      <td><input type="text" name="config_blog_admin_limit" value="<?php echo $config_blog_admin_limit; ?>" size="3" />
                        <?php if ($error_blog_admin_limit) { ?>
                        <span class="error"><?php echo $error_blog_admin_limit; ?></span>
                        <?php } ?></td>
                    </tr>
                  </table>
                 <h2><?php echo $text_article; ?></h2>
                  <table class="form">
                    <tr>
                      <td><?php echo $entry_comment; ?></td>
                      <td><?php if ($config_comment_status) { ?>
                        <input type="radio" name="config_comment_status" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <input type="radio" name="config_comment_status" value="0" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="config_comment_status" value="1" />
                        <?php echo $text_yes; ?>
                        <input type="radio" name="config_comment_status" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } ?></td>
                    </tr>
                    <tr>
                      <td><?php echo $entry_approval; ?></td>
                      <td><?php if ($config_approval_status) { ?>
                        <input type="radio" name="config_approval_status" value="1" checked="checked" />
                        <?php echo $text_yes; ?>
                        <input type="radio" name="config_approval_status" value="0" />
                        <?php echo $text_no; ?>
                        <?php } else { ?>
                        <input type="radio" name="config_approval_status" value="1" />
                        <?php echo $text_yes; ?>
                        <input type="radio" name="config_approval_status" value="0" checked="checked" />
                        <?php echo $text_no; ?>
                        <?php } ?></td>
                    </tr>
                  </table>
            </div>
            
            <div id="tab-image">
              <table class="form">
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_image_category; ?></td>
                  <td><input type="text" name="config_blog_image_category_width" value="<?php echo $config_blog_image_category_width; ?>" size="3" />
                    x
                    <input type="text" name="config_blog_image_category_height" value="<?php echo $config_blog_image_category_height; ?>" size="3" />
                    <?php if ($error_blog_image_category) { ?>
                    <span class="error"><?php echo $error_blog_image_category; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_image_article; ?></td>
                  <td><input type="text" name="config_blog_image_article_width" value="<?php echo $config_blog_image_article_width; ?>" size="3" />
                    x
                    <input type="text" name="config_blog_image_article_height" value="<?php echo $config_blog_image_article_height; ?>" size="3" />
                    <?php if ($error_blog_image_article) { ?>
                    <span class="error"><?php echo $error_blog_image_article; ?></span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td><span class="required">*</span> <?php echo $entry_image_related; ?></td>
                  <td><input type="text" name="config_blog_image_related_width" value="<?php echo $config_blog_image_related_width; ?>" size="3" />
                    x
                    <input type="text" name="config_blog_image_related_height" value="<?php echo $config_blog_image_related_height; ?>" size="3" />
                    <?php if ($error_blog_image_related) { ?>
                    <span class="error"><?php echo $error_blog_image_related; ?></span>
                    <?php } ?></td>
                </tr>
              </table>
            </div>
        
        </form>
        </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#tabs a').tabs();
//--></script> 
<?php echo $footer; ?>