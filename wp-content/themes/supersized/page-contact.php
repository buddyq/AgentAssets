<?php get_header(); global $post; ?>
<div class="slider" id="supersized-slider">

</div>
<div class="content col-sm-12">
    <h1 class="page-title"><?php echo get_the_title($post->ID); ?></h1>
    <div class="row property-details">
        <div class="col-sm-12">
            <div class="col-sm-6">
                <?php
            		// Start the loop.
            		while ( have_posts() ) : the_post();

            			// Include the page content template.
            			get_template_part( 'content', 'page' );

            			// If comments are open or we have at least one comment, load up the comment template.
            			if ( comments_open() || get_comments_number() ) :
            				comments_template();
            			endif;

            		// End the loop.
            		endwhile;
            		?>
            </div>
            <div class="col-sm-6">
                <?php the_post_thumbnail(array(400,600)); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
