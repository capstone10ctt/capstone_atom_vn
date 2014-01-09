<div id="comments-header">
    <h3 class="form-title"><?php echo $view_comment.' ('.$comment_total.')';?></h3>
</div>
<?php if ($comments) { ?>
<div id="allcomments">
    <?php foreach($comments as $comment){?>
        <div class="comment-item">
            <div class="comment-item-header">
                <span class="comment-by"><?php echo $text_comment_by;?>
                <span><?php echo $comment['author'];?></span></span>
				<span class="line">|</span>
                <small class="time-stamp">
                        <?php $date = new DateTime($comment['date_added']);?>
                        <?php echo $date-> format('l, M j Y, h:iA');?>
                </small>
            </div>
            <div class="comment-body">
                <?php echo $comment['text'];?>
            </div>
        </div>
    <?php } ?>
</div>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="allcomments"><?php echo $text_no_comments; ?></div>
<?php } ?>