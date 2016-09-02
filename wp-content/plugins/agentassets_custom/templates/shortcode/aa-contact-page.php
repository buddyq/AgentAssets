<?php $model = ContactInfoModel::model(); ?>
<div class="row property-details">
    <div class="col-sm-12">
        <div class="col-sm-6">
            <?php echo do_shortcode(empty($content) ? $model->contact_form_shortcode : $content) ?>
        </div>
        <div class="col-sm-6">
            <?php the_post_thumbnail(array(400,600)); ?>
        </div>
    </div>
</div>