<?php
/*
 * @package WordPress
 * Template Name: Profile Page
*/
?>
<?php get_header(); ?>
<div id="main">
	<?php if(have_posts()): the_post(); ?>
	<div class="page-title">
		<h1><?php the_title(); ?></h1>
	</div>
	<?php the_post_thumbnail(array(862,9999), array('class'=> 'profile-image')); ?>
	<article class="page-content">
        <?php if ( get_field("achievements" )) : ?>		
		<ul class="star-list right">
            <?php while ( has_sub_field("achievements") ) : ?>
                <li>
                    <?php if (get_sub_field("link")) : ?>
                        <a href="<?php the_sub_field("link"); ?>" target="_blank">
                    <?php else : ?>
                        <strong>
                    <?php endif; ?>
                    <?php the_sub_field("title"); ?>
                    <?php if ( get_sub_field("date") ) : ?>
                        <span class="date"><?php the_sub_field("date"); ?></span>
                    <?php endif; ?> 
                    <?php if (get_sub_field("link")) : ?>
                        </a>
                    <?php else : ?>
                        </strong>
                    <?php endif; ?>
                </li>    			
            <?php endwhile; ?>
		</ul>
        <?php endif; ?>
	<?php the_content(); ?>
	</article>
	<?php endif; ?>
</div>
<?php get_footer(); ?>