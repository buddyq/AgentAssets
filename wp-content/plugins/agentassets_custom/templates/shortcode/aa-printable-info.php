<?php //$model = PrintableInfoModel::model(); ?>

<div class="printable-information row">
    <div class="col-sm-12">
        <div class="title">
            <h3>Printables</h3>
        </div>
        <div class="col-sm-4">
            <div class="intro-text">
                <?php echo $model->printable_text;?>
            </div>
            <div class="attachments"><!-- Item attachments -->
                <h2>Available Downloads</h2>
                <ul class="itemAttachments">
                    <?php
                    // The Query
                    $the_query = new WP_Query( array(
                        'post_type' => 'printable_info',   /* edit this line */
                        'posts_per_page' => 1 ) );

                    // The Loop
                    if ( $the_query->have_posts() ) {

                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            ?>

                            <li>
                                <h3><?php echo get_the_title();  ?></h3>

                                <h5><?php echo get_the_content(); ?></h5>

                                <div style="border:none" class="button medium white download">
                                    <?php $Printable_info_pdf = get_post_meta(get_the_ID(), 'wpcf-select-file-here', true );
                                    //echo "<prE>";print_r($Printable_info_pdf);echo "</pre>";
                                    //$pdf_file = $Printable_info_pdf['file'];
                                    if(!empty($Printable_info_pdf)) { ?>
                                        <a class="btn btn-primary" target="_new" href="<?php echo $Printable_info_pdf; ?>">Download</a>
                                    <?php }


                                    ?>
                                    <div class="pdf-size-details">
                                        <!--                                            <span class="pdf-dowmload-size">Size: 0.37 MB </span><br>-->
                                    </div>
                                </div>
                            </li>
                            <?php
                        }

                    }
                    /* Restore original Post Data */
                    wp_reset_postdata();

                    ?>
                </ul>
            </div>

        </div>
        <div class="col-sm-8 info-picture">
            <?php echo aa_media_image_shortcode(array(
                'style' => 'height:100%;width:100%;',
                'alt' => 'image',
            ), $model->printable_image);?>
        </div>
    </div>
</div>