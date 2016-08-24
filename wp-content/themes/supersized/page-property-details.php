<?php get_header(); global $post; ?>
<div class="slider" id="supersized-slider">
	
</div>
<div class="content col-sm-12">
    <h1 class="page-title"><?php echo get_the_title($post->ID); ?></h1>
    <div class="row property-details">
        <div class="col-sm-12">
            <div class="col-sm-4">
                <h3 class="heading">Facts & Figures</h3>
                <ul class="details">
                    <?php 
                    if ( "fixed" == get_option('property_price_type')) {
                        $property_price = get_option('property_price');
                        if(isset($property_price) && !empty($property_price)){
                            ?>
                            <li>
                                <label for="price">Price:</label>
                                <span>$<?php echo $property_price; ?></span>
                            </li>
                            <?php 
                        } 
                    }elseif ( "range" == get_option('property_price_type')) {
                        $property_min_price = get_option('property_price1');
                        $property_max_price = get_option('property_price2');
                        if((isset($property_min_price) && !empty($property_min_price)) && (isset($property_max_price) && !empty($property_max_price))){
                            ?>
                            <li>
                                <label for="price">Price:</label>
                                <span><?php echo "$".$property_min_price.' - $'.$property_max_price; ?></span>
                            </li>
                            <?php
                        }
                    }
                    $property_type = get_option('property_type');
                    if(isset($property_type) && !empty($property_type)){
                    ?>
                    <li>
                        <label>Type:</label>
                        <span><?php echo $property_type; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_mls = get_option('property_mls');
                    if(isset($property_mls) && !empty($property_mls)){
                    ?>
                    <li>
                        <label>MLS#:</label>
                        <span><?php echo $property_mls; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_area = get_option('property_area');
                    if(isset($property_area) && !empty($property_area)){
                    ?>
                    <li>
                        <label>Area:</label>
                        <span><?php echo $property_area; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_bedrooms = get_option('property_bedrooms');
                    if(isset($property_bedrooms) && !empty($property_bedrooms)){
                    ?>
                    <li>
                        <label>Bedrooms:</label>
                        <span><?php echo $property_bedrooms; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_baths = get_option('property_baths');
                    if(isset($property_baths) && !empty($property_baths)){
                    ?>
                    <li>
                        <label>Baths:</label>
                        <span><?php echo $property_baths; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_living = get_option('property_living_areas');
                    if(isset($property_living) && !empty($property_living)){
                    ?>
                    <li>
                        <label>Living Areas:</label>
                        <span><?php echo $property_living; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_sqft = get_option('property_square_feet');
                    if(isset($property_sqft) && !empty($property_sqft)){
                    ?>
                    <li>
                        <label>Square Feet:</label>
                        <span><?php echo $property_sqft; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_school_district= get_option('property_school_district');
                    if(isset($property_school_district) && !empty($property_school_district)){
                    ?>
                    <li>
                        <label>School District:</label>
                        <span><?php echo $property_school_district; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_pool = get_option('property_pool');
                    if(isset($property_pool) && $property_pool>0){
                    ?>
                    <li>
                        <label>Pool:</label>
                        <span>
                        <?php 
                        if($property_pool=="1"){
                            echo "Yes";
                        }elseif($property_pool=="2"){
                            echo "No";
                        } 
                        ?>
                        </span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_view = get_option('property_view');
                    if(isset($property_view) && !empty($property_view)){
                    ?>
                    <li>
                        <label>View:</label>
                        <span><?php echo $property_view; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_garages = get_option('property_garages');
                    if(isset($property_garages) && !empty($property_garages)){
                    ?>
                    <li>
                        <label>Garages:</label>
                        <span><?php echo $property_garages; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_year_built = get_option('property_year_built');
                    if(isset($property_year_built) && !empty($property_year_built)){
                    ?>
                    <li>
                        <label>Year Built:</label>
                        <span><?php echo $property_year_built; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_lot_size = get_option('property_lot_size');
                    if(isset($property_lot_size) && !empty($property_lot_size)){
                    ?>
                    <li>
                        <label>Lot Size:</label>
                        <span><?php echo $property_lot_size; ?></span>
                    </li>
                    <?php } ?>
                    <?php 
                    $property_acreage = get_option('property_acreage');
                    if(isset($property_acreage) && !empty($property_acreage)){
                    ?>
                    <li>
                        <label>Acreage:</label>
                        <span><?php echo $property_acreage; ?></span>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="col-sm-8">
                <h3 class="heading">Property Description</h3>
                <?php echo apply_filters('the_content',stripslashes(get_option('property_description')));?>
                <?php
                $tour_link_1 = get_option('property_tour_link1');
                $tour_link_2 = get_option('property_tour_link2');
                if((isset($tour_link_1) && !empty($tour_link_1)) && (isset($tour_link_2) && !empty($tour_link_2))){
                ?>
                <div class="property-tour-links">
                    <h3>Tour</h3>
                    <ul class="tour-links">
                        <?php 
                        if(!empty($tour_link_1))
                        {
                            ?>
                            <li><a href="<?php echo get_option('property_tour_link1');?>"><?php echo get_option('property_tour_link1');?></a></li>
                            <?php
                        }
                        if(!empty($tour_link_2))
                        {
                            ?>
                            <li><a href="<?php echo get_option('property_tour_link2');?>"><?php echo get_option('property_tour_link2');?></a></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>