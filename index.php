<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>

<div id="main" class="cf">
	<div id="content" role="main">
        <?php $pid = get_option( 'page_for_posts' ); ?>
        <?php if ($pid) : ?>
		<div class="page-title">
			<h1><?php echo get_the_title($pid); ?></h1>
		</div>
        <?php endif; ?>
		<?php include("loop.php"); ?>
	</div>
	<?php get_sidebar('news'); ?>
</div>

<?php get_footer(); ?>
