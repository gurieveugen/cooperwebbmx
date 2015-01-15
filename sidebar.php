<?php
/**
 * @package WordPress
 * @subpackage Base_theme
 */
?>
<?php if ( is_active_sidebar('Right Sidebar') ) : ?>
<div id="sidebar">
	<?php dynamic_sidebar( 'Right Sidebar' ); ?>
</div>
<?php endif; ?>
