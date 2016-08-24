<?php get_header(); global $post; ?>
<div class="slider" id="supersized-slider">

</div>
<div class="content col-sm-12">
    <h1 class="page-title"><?php echo get_the_title($post->ID); ?></h1>
    <?php the_content(); ?>
</div>
<?php include("footer-contact.php"); ?>
