<?php

/* 
 * Photo Gallery Page Template
 * 
 */
get_header();
global $post;
$args = array(
    'post_type' => 'gallery',
    'post_status' => 'publish',
    'posts_per_page' => '-1',
    'orderby' => 'ID',
    'order' => 'ASC'
);
$gallery_list = get_posts($args);
if(count($gallery_list) > 0){
?>
<div id="primary" class="gallery">
    <h1 class="entry-title"><?php echo $post->post_title;?></h1>
    <div id="slider" class="flexslider">
        <ul class="slides">
            <?php foreach($gallery_list AS $gallery_item){ ?>

                <li>
                    <?php echo get_the_post_thumbnail($gallery_item->ID,'full'); ?>
                </li>

            <?php } ?>

        </ul>
    </div>
    <div id="carousel" class="flexslider">
        <ul class="slides">

            <?php foreach($gallery_list AS $gallery_item){ ?>

                <li>
                    <?php echo get_the_post_thumbnail($gallery_item->ID,array(100,100)); ?>
                </li>

            <?php } ?>

        </ul>
    </div>
<?php 
}
else
{
    echo '<h2 class="text-uppercase">No images found in Gallery.</h2>';
}
?>
</div>
<?php get_footer(); ?>