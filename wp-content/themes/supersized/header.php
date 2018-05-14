<!DOCTYPE html>
<?php $alloptions = get_option('supersized-theme'); ?>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php
   $meta_keywords = get_option('meta_keywords',true);
   $meta_description = get_option('meta_description',true);
  ?>
  <meta name="keywords" content="<?php echo $meta_keywords;?>" />
  <meta name="description" content="<?php echo $meta_description;?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css?family=<?php echo $alloptions['evl_title_font']['face']; ?>" rel='stylesheet' type='text/css'>

	<?php wp_head(); ?>
	<?php // $model = ThemeSettingsModel::model(); ?>
	<style media="screen">
		h1{ font-size: <?php echo $alloptions['evl_title_font']['size'] ?>}
		.site-title a{
			color: <?php echo $alloptions['evl_title_font']['color'] ?>;
			font-family: "<?php echo $alloptions['evl_title_font']['face'] ?>";
			font-style: <?php echo $alloptions['evl_title_font']['style']; ?>
		}
		.navbar-default .navbar-nav>li>a{
			/*color: <?php echo $alloptions['evl_menu_font']['color'] ?>;*/
			font-size: <?php echo $alloptions['evl_menu_font']['size'] ?>;
			font-family: <?php echo $alloptions['evl_menu_font']['face'] ?>
		}
		.nav-container{
			position: absolute;
			bottom: 0;
			width: 100%;
		}
		.nav-container > .navbar{
			/*position: absolute;*/
			/*width: 100%;*/
			text-align: center;
		}
		.button.medium.white.download a,
		#aa_google_map_focus{
			border: 1px solid <?php // echo $alloptions['evl_accent_text_color_font']['color'] ?>
		}
		<?php
		// echo ".itemAttachments li, ul.details, .btn-primary{ background-color: lighten(".$model->highlighted_accent_color .", 80%)};";
		//echo ".btn-primary{ border-color: ".$model->highlighted_accent_color . "};";
		?>
	</style>
</head>
<body>
	<?php include_once("analyticstracking.php") ?>
    <div id="wrapper" <?php if(is_home() || is_front_page()){ echo ' class="home" '; } ?>>
        <div class="container-fluid">
            <header class="header-wrapper">
                <h1 class="site-title">
                    <a href="<?php echo get_bloginfo('url'); ?>"><?php echo get_bloginfo('name');?></a>
                </h1>
								<div class="nav-container">
									<nav class="navbar navbar-default container">
	                    <?php
	                    $defaults = array(
	                        'menu'            => '3',
	                        'container'       => 'div',
	                        'container_class' => 'collapse navbar-collapse',
	                        'container_id'    => 'supersized-navbar-collapse',
	                        'menu_class'      => 'nav navbar-nav',
	                    );

	                    wp_nav_menu( $defaults );
	                    ?>

	                    <?php /*<div class="container-fluid">
	                        <!-- Brand and toggle get grouped for better mobile display -->
	                        <div class="navbar-header">
	                          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	                            <span class="sr-only">Toggle navigation</span>
	                            <span class="icon-bar"></span>
	                            <span class="icon-bar"></span>
	                            <span class="icon-bar"></span>
	                          </button>

	                        </div>

	                        <!-- Collect the nav links, forms, and other content for toggling -->
	                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	                          <ul class="nav navbar-nav">
	                            <li class="active">
	                                <a href="<?php echo site_url();?>">Home <span class="sr-only">(current)</span></a>
	                            </li>
	                            <li><a href="<?php echo site_url();?>/property-details/">Details</a></li>
	                            <li><a href="<?php echo site_url();?>/gallery/">Gallery</a></li>
	                            <li><a href="<?php echo site_url();?>/location/">Location</a></li>
	                            <li><a href="<?php echo site_url();?>/printable-info/">Printables</a></li>

	                          </ul>

	                        </div><!-- /.navbar-collapse -->
	                      </div><!-- /.container-fluid --> */?>
	                </nav>
								</div>
            </header>
        </div>
        <div class="main-content">
            <div class="container">
