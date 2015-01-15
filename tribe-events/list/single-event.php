<?php 
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 * @since  3.0
 * @author Modern Tribe Inc.
 *
 */

if ( !defined('ABSPATH') ) { die('-1'); } ?>

<?php
$event_city = tribe_get_city();
$event_state = tribe_get_state();
$event_venue = tribe_get_venue();
?>

<header class="cf">
    <span class="entry-date black">
    	<strong><?php echo tribe_get_start_date( get_the_ID(), false, 'd'); ?></strong>
    	<span><?php echo tribe_get_start_date( get_the_ID(), false, 'M'); ?></span>
    </span>
    <div class="holder">
        <div class="row">
        	<h1 class="pink"><?php the_title(); ?></h1>
        	<h2 class="grey"><?php echo $event_city; ?><?php if ($event_state) echo ', '.$event_state; ?></h2>
        </div>
        <?php if ( $event_venue ) : ?>
        <div class="row">
        	<h2>@<?php echo $event_venue; ?></h2>
        </div>
    </div>
    <?php endif; ?>
    <div class="row-more">
    	<h2>More Info</h2>
    </div>
    <span class="ico"></span>
</header>
<div class="content">
    <?php the_excerpt() ?>
</div>