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
             <a href="<?php echo $boss_settings; ?>" style="display: inline;"><?php echo $text_boss_settings; ?></a>
         </div>
         
    <div class="box">
        <div class="heading"><h1>HELP</h1></div>
        <div class="content">
            <div class="feature">
            <h3>Features</h3>
                <ul>
                    <li><a href="<?php echo $boss_category; ?>" style="display: inline;"><?php echo $text_boss_category ; ?></a></li>
                    <li><a href="<?php echo $boss_articles; ?>" style="display: inline;"><?php echo $text_boss_articles; ?></a></li>
                    <li><a href="<?php echo $boss_comments; ?>" style="display: inline;"><?php echo $text_boss_comments; ?></a></li>
                    <li><a href="<?php echo $boss_settings; ?>" style="display: inline;"><?php echo $text_boss_settings; ?></a></li>
                </ul>
            
            </div>
            
            <div class="about-bossblog">
            <h3>ABOUT BOSS BLOG MODULE</h3>
            <ul>
                <li>Author                                              	 : CodeSpot</li>
                <li>Version                                            	:  1.0</li>
                <li>Opencart Compatibility             	 : v1.5.x</li>
                <li>Email                                                 	: support@bossthemes.com</li>
            </ul>
            </div>
            <div class="about-bossthemes">
            <h3>ABOUT BOSSTHEMES.COM</h3>
            <p>BossThemes.com is a Premium OpenCart Themes & OpenCart Templates Provider. We have been implementing eCommerce solutions for over 10 years and our talented team has more than 50 developers and consultants passionate about eCommerce. Our deep understanding of ecommerce, user experience design and online marketing makes us the perfect choice to help you with your new Opencart ecommerce website. </p>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>