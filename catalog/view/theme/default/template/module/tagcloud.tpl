<div class="box tagcloud">
    <div class="box-heading">
	   <span><?php echo $heading_title; ?></span>
    </div>
		
    <div class="box-content" style="text-align:left;"> 
		<?php if($tagcloud) { ?>
		  <?php echo $tagcloud; ?>
		<?php } else { ?>
		  <?php echo $text_notags; ?>
		<?php } ?>
    </div>
</div>
