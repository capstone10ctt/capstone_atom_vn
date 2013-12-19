<div class="box block boss_block-recent-post">
    <div class="box-heading block-title">
        <span><?php echo $heading_title; ?></span>
    </div>
    <div class="box-content block-content">
        <?php if($articles){?>
        <ol>
            <?php foreach ($articles as $article) { ?>
            <li class="item">
                <a class="article-title" href="<?php echo $article['href']; ?>"><?php echo $article['name']; ?></a>
                <small class="time-stamp">
                    <?php $date = new DateTime($article['date_added']);?>
                    <?php echo $date->format('l, M j, Y');?></small> 
                <div class="recent-comment-content">
                    <?php echo $article['title']; ?>
                </div>
                <span class="post-by">Post by <span><?php echo $article['author']; ?></span></span>         
            </li>
            <?php } ?>
        </ol>
        <?php } else {?>
        <?php echo 'There are no Articles.'; ?>
        <?php } ?>
    </div>

</div>
