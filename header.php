<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main" class="cf">
 *
 * @package WordPress
 * @subpackage Cooperweb 
 */
?>
<?php global $cooperwebb_theme_options; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	 <title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css' />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <?php if ( is_front_page() ) : ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo TDU; ?>/css/colorbox.css" />        
    <?php endif; ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); 
		wp_head(); ?>
	<script src="<?php echo TDU; ?>/js/jquery.cycle.all.js"></script>
	<script src="<?php echo TDU; ?>/js/jquery.flexslider.js"></script>
	<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.main.js" ></script>
    <?php if ( is_front_page() || is_page_template('page-videos.php')) : ?>
        <script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.colorbox-min.js" ></script>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery(".item > .link").colorbox({inline:true});
                jQuery(".youtube").colorbox({iframe:true, innerWidth:640, innerHeight:390});
            });
        </script>    
    <?php endif; ?>
	<!--[if lt IE 9]>
		<script type="text/javascript" src="<?php echo TDU; ?>/js/html5.js"></script>
	<![endif]-->
	<!--[if lte IE 9]>
		<script type="text/javascript" src="<?php echo TDU; ?>/js/jquery.placeholder.min.js"></script>
		<script type="text/javascript">
			jQuery(function(){
				jQuery('input, textarea').placeholder();
			});
		</script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
    <div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
	<div id="wrapper">
		<header id="header">
			<?php if(is_front_page()): ?>
				<h1 class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo TDU; ?>/images/logo.png" alt="<?php bloginfo('name'); ?>"></a></h1>
			<?php else: ?>
				<strong class="logo"><a href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home"><img src="<?php echo TDU; ?>/images/logo.png" alt="<?php bloginfo('name'); ?>"></a></strong>
			<?php endif; ?>
			<div class="navbar cf">
				<?php wp_nav_menu( array(
				'container' => 'nav',
				'theme_location' => 'primary_nav',
				'menu_id' => 'nav'
				)); ?>
				<ul class="socials">
                    <?php if ( $cooperwebb_theme_options['cooperwebb_header_facebook'] ) : ?>
                        <li><a href="<?php echo $cooperwebb_theme_options['cooperwebb_header_facebook']; ?>" title="Facebook" target="_blank">
                            <img src="<?php echo TDU; ?>/images/ico-facebook.png" alt="" />
                        </a></li>
                    <?php endif; ?>
                    <?php if ( $cooperwebb_theme_options['cooperwebb_header_twitter'] ) : ?>
                        <li><a href="<?php echo $cooperwebb_theme_options['cooperwebb_header_twitter']; ?>" title="Twitter" target="_blank">
                            <img src="<?php echo TDU; ?>/images/ico-twitter.png" alt="" />
                        </a></li>
                    <?php endif; ?>
                    <?php if ($cooperwebb_theme_options['cooperwebb_header_instagram']) : ?>
                        <li><a href="<?php echo $cooperwebb_theme_options['cooperwebb_header_instagram']; ?>" title="Instagram" target="_blank">
                            <img src="<?php echo TDU; ?>/images/ico-instagram.png" alt="" />
                        </a></li>
                    <?php endif; ?>
				</ul>
			</div>
		</header>