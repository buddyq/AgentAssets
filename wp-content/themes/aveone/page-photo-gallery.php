<?php

/*
 * Photo Gallery Page Template
 *
 */
get_header();
// global $post;
// $args = array(
//     'post_type' => 'gallery',
//     'post_status' => 'publish',
//     'posts_per_page' => '-1',
//     'orderby' => 'ID',
//     'order' => 'ASC'
// );
// $gallery_list = get_posts($args);
// if(count($gallery_list) > 0){
$gallery_id = 109;
$gallery_data = get_post_meta( $gallery_id, '_eg_gallery_data', true );


// ?>

<div id="primary" class="gallery">
    <h1 class="entry-title"><?php echo $post->post_title;?></h1>
    <div id="slider" class="flexslider">
        <ul class="slides">
            <?php foreach($gallery_data['gallery'] as $attachment_id => $image) { ?>

                <li>
                    <!-- <img src="<?php //echo $image['src']; ?>"> -->
                    <?php echo wp_get_attachment_image( $attachment_id, $gallery_data['config']['image_size'] );  ?>
                </li>

            <?php } ?>

        </ul>
    </div>
    <div id="carousel" class="flexslider">
        <ul class="slides">

            <?php foreach($gallery_data['gallery'] as $attachment_id => $image) { ?>

                <li>
                    <?php echo wp_get_attachment_image($attachment_id, "thumbnail"); ?>
                </li>

            <?php } ?>

        </ul>
    </div>
<?php


?>
<!-- </div> -->
<?php get_footer(); ?>
