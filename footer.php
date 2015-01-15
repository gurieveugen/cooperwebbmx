<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>
<?php global $cooperwebb_theme_options; ?>
        
        <?php $sponsors = new WP_Query( 'post_type=sponsor&orderby=menu_order&order=ASC&posts_per_page=-1' ); ?>
        <?php if ( $sponsors->have_posts() ) : ?>
            <section class="logo-area">
                <div class="logos-holder">
                    <ul class="logos-list cf">
                        <?php while ( $sponsors->have_posts() ) : $sponsors->the_post(); ?>
                            <?php if (has_post_thumbnail()) : ?>
                                <li>
                                    <?php $sponsor_site = get_post_meta($post->ID, 'sponsor_site', true); ?>
                                    <?php if ( $sponsor_site ) : ?>
                                        <a href="<?php echo $sponsor_site; ?>" target="_blank" title="<?php the_title(); ?>">
                                    <?php endif; ?>
                                        <?php the_post_thumbnail("full"); ?>
                                    <?php if ( $sponsor_site ) : ?>
                                        </a>
                                    <?php endif; ?>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </section>
        <?php endif; ?>		
		<footer id="footer">
			<div class="cf">
                <?php if ( $cooperwebb_theme_options['cooperwebb_footer_copyright'] ) : ?>
				    <p class="left"><?php echo $cooperwebb_theme_options['cooperwebb_footer_copyright']; ?></p>
                <?php endif; ?>
                <?php wp_nav_menu( array(
    				'container' => '',
    				'theme_location' => 'footer_nav'				
				)); ?>				
			</div>
			<div class="design cf">
                <?php if (is_front_page()) : ?>
				    <p>website design by <a href="http://www.inkhaus.com" title="Myrtle Beach Web Design - South Carolina Graphic Design Studio" target="_blank">INKHAUS</a></p>
                <?php else : ?>
                    <p>website design by <a href="http://www.inkhaus.com" title="Myrtle Beach Web Design - South Carolina Graphic Design Studio" target="_blank" rel="nofollow">INKHAUS</a></p>
                <?php endif; ?>
			</div>
		</footer>
	</div>
	<?php wp_footer(); ?>
</body>
</html>