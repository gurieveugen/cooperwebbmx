<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>

<?php if ( have_posts() ) : ?>
<div class="posts-content">
	<div class="posts-holder">
	<?php while ( have_posts() ) : the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<a href="<?php the_permalink(); ?>">
				<header class="entry-header cf">
					<span class="entry-date">
						<strong><?php the_date('d'); ?></strong>
						<span><?php the_time('M'); ?></span>
					</span>
					<div class="holder">
						<h1><?php the_title(); ?></h1>
						<strong class="category"><?php echo implode( ', ', get_post_cats( get_the_ID() ) ) ; ?></strong>
					</div>
				</header>
				<div class="content">
					<?php 
					$cont = short_content(strip_shortcodes(get_the_content()), 175); 
					echo $cont;
					?>
				</div>
			</a>
		</article><!-- #post -->
	<?php endwhile; ?>
	</div> <!-- .posts-holder -->
	<?php if(function_exists('wp_pagenavi')) wp_pagenavi(); ?>
</div> <!-- .posts-content -->

<?php else: ?>
	
	<h1 class="page-title"><?php _e( 'Nothing Found', 'theme' ); ?></h1>
	
	<div class="page-content">

		<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'theme' ); ?></p>
		<?php get_search_form(); ?>

	</div><!-- .page-content -->
	
<?php endif; ?>