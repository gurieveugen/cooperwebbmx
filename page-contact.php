<?php
/*
 * @package WordPress
 * Template Name: Contact Page
*/
?>
<?php get_header(); ?>
<div id="main">
	<?php if(have_posts()): the_post(); ?>
	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>
	<article class="page-content content-contact">
		<div class="cf">
			<?php the_post_thumbnail('full', array('class'=> 'image-right')); ?>
			<div class="content">
				<?php the_content(); ?>
			</div>
		</div>
		<div class="form-area">
			<h3>Send Cooper a Message</h3>
			<?php echo do_shortcode('[contact-form-7 id="280" title="Contact Form"]'); ?>
		</div>
	</article>
	<?php endif; ?>
</div>
<?php get_footer(); ?>