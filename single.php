<?php
/**
 *
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php get_header(); ?>
<?php $pid = get_option( 'page_for_posts' ); ?>
<div id="main" class="cf">
	<div id="content">
	<?php if ( have_posts() ) : the_post(); ?>
		<?php if ($pid) : ?>
		<div class="page-title">
			<h1><?php echo get_the_title($pid); ?> </h1>
		</div>
        <?php endif; ?>
		<article class="main-content">
			<header class="entry-header">
				<span class="entry-date">
					<strong><?php the_date('d'); ?></strong>
					<span><?php the_time('M'); ?></span>
				</span>
				<div class="holder">
					<h1><?php the_title(); ?></h1>
                    <?php
                    $categories = get_the_category();
                    $separator = ' ';
                    $cats = array();
                    if($categories){
                    	foreach($categories as $category) {
                    		$cats[] = '<a href="'.get_category_link( $category->term_id ).'" class="category" title="' . esc_attr( sprintf( __( "View all posts in %s" ), $category->name ) ) . '">'.$category->cat_name.'</a>';
                    	}
                    echo implode(', ', $cats);
                    }
                    ?>					
				</div>
			</header>
			<?php the_post_thumbnail('full',array('class'=>'featured-image')); ?>
			<?php the_content(); ?>
			<div class="nav-single cf">
                <?php if ( $pid ) : ?>
                    <a href="<?php echo get_permalink($pid); ?>" class="link-back">&larr; back <?php echo get_the_title($pid); ?></a>
                <?php endif; ?>        						
				<div class="post-navigation">
					<span class="link-prev"><?php next_post_link( '%link', __( 'Prev', 'theme' ) ); ?></span>
					<span class="link-next"><?php previous_post_link( '%link', __( 'Next', 'theme' ) ); ?></span>
				</div>
			</div>
			<div class="socials-area">
				<h3>Share the news</h3>
				<ul class="cf">
                    <li><div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-type="link"></div></li>
                    <li><a href="http://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>" target="_blank"><img src="<?php echo TDU; ?>/images/ico-twitter-1.png" alt=""></a></li>
				</ul>
			</div>
			<div class="comments-area">
				<?php echo do_shortcode('[fbcomments width="496" count="off" num="3" countmsg="wonderful comments!"]'); ?>
                <?php // comments_template( '', true ); ?>
				<!--<img src="<?php echo TDU; ?>/images/temp-comments.png" alt="">-->
			</div>
		</article>
	<?php endif; ?>
	</div>
	<?php get_sidebar('news'); ?>
</div>
	
<?php get_footer(); ?>