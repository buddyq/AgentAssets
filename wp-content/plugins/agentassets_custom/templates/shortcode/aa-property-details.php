<div class="row property-details av-catalogue-container">
  <ul class="av-catalogue-list details">
    <?php

    if ( "fixed" == $model->price_type) {
        $property_price = $model->price;
        $label = "Price:";
        if(isset($property_price) && !empty($property_price)){
          $value = "$" . $property_price;
          print_li($label, $value);
        }
    } elseif ( "range" == $model->price) {
        $label = "Price:";
        $property_min_price = $model->price1;
        $property_max_price = $model->price2;
        if((isset($property_min_price) && !empty($property_min_price)) && (isset($property_max_price) && !empty($property_max_price))){
          $value = "$".$property_min_price.' - $'.$property_max_price;
          print_li($label, $value);
        }
    }

    $property_type = $model->property_type;
    $label = "Type:";
    if(isset($property_type) && !empty($property_type)){
      print_li($label, $property_type);
    }

    $property_mls = $model->property_mls;
    $label = "MLS#:";
    if(isset($property_mls) && !empty($property_mls)){
      print_li($label, $property_mls);
    }

    $property_area = $model->property_area;
    $label = "Area:";
    if(isset($property_area) && !empty($property_area)){
      print_li($label, $property_area);
    }

    $property_bedrooms = $model->property_bedrooms;
    $label = "Bedrooms:";
    if(isset($property_bedrooms) && !empty($property_bedrooms)){
      print_li($label, $property_bedrooms);
    }

    $property_baths = $model->property_baths;
    $label = "Baths:";
    if(isset($property_baths) && !empty($property_baths)){
      print_li($label, $property_baths);
    }

    $property_living = $model->property_living_areas;
    $label = "Living Areas:";
    if(isset($property_living) && !empty($property_living)){
      print_li($label, $property_living);
    }

    $property_sqft = $model->property_square_feet;
    $label = "Square Feet:";
    if(isset($property_sqft) && !empty($property_sqft)){
      print_li($label, $property_sqft);
    }

    $property_school_district= $model->property_school_district;
    $label = "School District:";
    if(isset($property_school_district) && !empty($property_school_district)){
      print_li($label, $property_school_district);
    }

    $property_pool = $model->property_pool;
    $label = "Pool:";
    if(isset($property_pool) && $property_pool>0){
      if($property_pool=="1"){
          $value =  "Yes";
      }elseif($property_pool=="2"){
          $value =  "No";
      }
      print_li($label, $value);
    }

    $property_view = $model->property_view;
    $label = "View:";
    if(isset($property_view) && !empty($property_view)){
      print_li($label, $property_view);
    }

    $property_garages = $model->property_garages;
    $label = "Garages:";
    if(isset($property_garages) && !empty($property_garages)){
      print_li($label, $property_garages);
    }

    $property_year_built = $model->property_year_built;
    $label = "Year Built:";
    if(isset($property_year_built) && !empty($property_year_built)){
      print_li($label, $property_year_built);
    }

    $property_lot_size = $model->property_lot_size;
    $labl = "Lot Size:";
    if(isset($property_lot_size) && !empty($property_lot_size)){
      print_li($label, $property_lot_size);
    }

    $property_acreage = $model->property_acreage;
    $label = "Acres:";
    if(isset($property_acreage) && !empty($property_acreage)){
      print_li($label, $property_acreage);
    }
    ?>
  </ul>
</div>
<?php
function print_li($label, $value){
  echo '<li>
  <div class="av-catalogue-item">
    <div class="av-catalogue-item-inner">
        <div class="av-catalogue-title-container">
            <div class="av-catalogue-title">'.$label.'</div>
            <div class="av-catalogue-price">'.$value.'</div>
        </div>
    </div>
  </div>
  </li>';
}
?>
