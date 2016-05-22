<header id="header" class="sticky-header">
	<div class="container">

   <?php $aveone_pos_logo = aveone_get_option('evl_pos_logo','left'); if ($aveone_pos_logo == "disable") { ?> 
  
  <?php } else { ?>
  
   <?php $aveone_header_logo = aveone_get_option('evl_header_logo', '');
    if ($aveone_header_logo) {
        echo "<a class='logo-url' href=".home_url()."><img id='logo-image' src=".$aveone_header_logo." /></a>";
    }
      ?>   
     
     <?php } ?> 
     
     
        <?php $aveone_blog_title = aveone_get_option('evl_blog_title','0'); if ($aveone_blog_title == "0") { ?>
     
     <div id="logo"><a class='logo-url-text' href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ) ?></a></div>
     
          
     <?php } ?>	


		<nav id="nav" class="nav-holder">              
 <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'nav-menu' ) ); ?>
 	</nav>
	</div>
</header>