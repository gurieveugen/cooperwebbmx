
<?php get_header(); ?>

<div id="main" class="cf">
	<article class="content">
	<?php if ( have_posts() ) : the_post(); ?>
		
		<div class="page-title">
			<h1 class="entry-title"><?php the_title(); ?></h1>
		</div>

		<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
		<div class="page-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>

		<div class="page-content cf">
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
		</div><!-- .entry-content -->
		
	<?php endif; ?>
	</article>
</div>

<?php get_footer(); ?>
