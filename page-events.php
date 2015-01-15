<?php
/*
 * @package WordPress
 * Template Name: Races & Events Page
*/
?>
<?php get_header(); ?>
<div id="main" class="main-events cf">
	<div id="content" class="left">
        <?php if ( tribe_is_upcoming() ) : ?>
            <div class="page-title">
        		<h1>Race &amp; Events</h1>
        	</div>
        <?php endif; ?>
        <?php if(have_posts()): the_post(); ?>		
            <?php the_content();?>
        <?php endif; ?>
		<?php /* ?><div class="events-feed">
			<article class="event">
				<header class="cf">
					<span class="entry-date black">
						<strong>01</strong>
						<span>mar</span>
					</span>
					<div class="row">
						<h1 class="pink">Monster Energy Supercross</h1>
						<h2 class="grey">Indianapolis, IN</h2>
					</div>
					<div class="row">
						<h2>@Lucas Oil Stadium</h2>
					</div>
					<div class="row-more">
						<h2>More Info</h2>
					</div>
					<span class="ico"></span>
				</header>
				<div class="content">
					<p>Diam adipiscing legunt elit clari eu. Euismod vero doming vel nunc dolore. Delenit quinta tincidunt dynamicus delenit consequat. Exerci claram formas gothica ad ullamcorper. Nobis tincidunt congue sed nunc qui. Consequat volutpat et nulla iriure eros. Accumsan commodo hendrerit adipiscing ea dolore. Accumsan legunt euismod lectorum anteposuerit eorum. Possim iusto feugiat claritatem dolore eleifend. Lius sit vero cum typi nostrud.</p>
				</div>
			</article>
			<article class="event">
				<header class="cf">
					<span class="entry-date black">
						<strong>01</strong>
						<span>mar</span>
					</span>
					<div class="row">
						<h1 class="pink">Monster Energy Supercross</h1>
						<h2 class="grey">Indianapolis, IN</h2>
					</div>
					<div class="row">
						<h2>@Lucas Oil Stadium</h2>
					</div>
					<div class="row-more">
						<h2>More Info</h2>
					</div>
					<span class="ico"></span>
				</header>
				<div class="content">
					<p>Diam adipiscing legunt elit clari eu. Euismod vero doming vel nunc dolore. Delenit quinta tincidunt dynamicus delenit consequat. Exerci claram formas gothica ad ullamcorper. Nobis tincidunt congue sed nunc qui. Consequat volutpat et nulla iriure eros. Accumsan commodo hendrerit adipiscing ea dolore. Accumsan legunt euismod lectorum anteposuerit eorum. Possim iusto feugiat claritatem dolore eleifend. Lius sit vero cum typi nostrud.</p>
				</div>
			</article>
			<article class="event">
				<header class="cf">
					<span class="entry-date black">
						<strong>01</strong>
						<span>mar</span>
					</span>
					<div class="row">
						<h1 class="pink">Monster Energy Supercross</h1>
						<h2 class="grey">Indianapolis, IN</h2>
					</div>
					<div class="row">
						<h2>@Lucas Oil Stadium</h2>
					</div>
					<div class="row-more">
						<h2>More Info</h2>
					</div>
					<span class="ico"></span>
				</header>
				<div class="content">
					<p>Diam adipiscing legunt elit clari eu. Euismod vero doming vel nunc dolore. Delenit quinta tincidunt dynamicus delenit consequat. Exerci claram formas gothica ad ullamcorper. Nobis tincidunt congue sed nunc qui. Consequat volutpat et nulla iriure eros. Accumsan commodo hendrerit adipiscing ea dolore. Accumsan legunt euismod lectorum anteposuerit eorum. Possim iusto feugiat claritatem dolore eleifend. Lius sit vero cum typi nostrud.</p>
				</div>
			</article>
			<article class="event">
				<header class="cf">
					<span class="entry-date black">
						<strong>01</strong>
						<span>mar</span>
					</span>
					<div class="row">
						<h1 class="pink">Monster Energy Supercross</h1>
						<h2 class="grey">Indianapolis, IN</h2>
					</div>
					<div class="row">
						<h2>@Lucas Oil Stadium</h2>
					</div>
					<div class="row-more">
						<h2>More Info</h2>
					</div>
					<span class="ico"></span>
				</header>
				<div class="content">
					<p>Diam adipiscing legunt elit clari eu. Euismod vero doming vel nunc dolore. Delenit quinta tincidunt dynamicus delenit consequat. Exerci claram formas gothica ad ullamcorper. Nobis tincidunt congue sed nunc qui. Consequat volutpat et nulla iriure eros. Accumsan commodo hendrerit adipiscing ea dolore. Accumsan legunt euismod lectorum anteposuerit eorum. Possim iusto feugiat claritatem dolore eleifend. Lius sit vero cum typi nostrud.</p>
				</div>
			</article>
			<article class="event">
				<header class="cf">
					<span class="entry-date black">
						<strong>01</strong>
						<span>mar</span>
					</span>
					<div class="row">
						<h1 class="pink">Monster Energy Supercross</h1>
						<h2 class="grey">Indianapolis, IN</h2>
					</div>
					<div class="row">
						<h2>@Lucas Oil Stadium</h2>
					</div>
					<div class="row-more">
						<h2>More Info</h2>
					</div>
					<span class="ico"></span>
				</header>
				<div class="content">
					<p>Diam adipiscing legunt elit clari eu. Euismod vero doming vel nunc dolore. Delenit quinta tincidunt dynamicus delenit consequat. Exerci claram formas gothica ad ullamcorper. Nobis tincidunt congue sed nunc qui. Consequat volutpat et nulla iriure eros. Accumsan commodo hendrerit adipiscing ea dolore. Accumsan legunt euismod lectorum anteposuerit eorum. Possim iusto feugiat claritatem dolore eleifend. Lius sit vero cum typi nostrud.</p>
				</div>
			</article>
			<article class="event">
				<header class="cf">
					<span class="entry-date black">
						<strong>01</strong>
						<span>mar</span>
					</span>
					<div class="row">
						<h1 class="pink">Monster Energy Supercross</h1>
						<h2 class="grey">Indianapolis, IN</h2>
					</div>
					<div class="row">
						<h2>@Lucas Oil Stadium</h2>
					</div>
					<div class="row-more">
						<h2>More Info</h2>
					</div>
					<span class="ico"></span>
				</header>
				<div class="content">
					<p>Diam adipiscing legunt elit clari eu. Euismod vero doming vel nunc dolore. Delenit quinta tincidunt dynamicus delenit consequat. Exerci claram formas gothica ad ullamcorper. Nobis tincidunt congue sed nunc qui. Consequat volutpat et nulla iriure eros. Accumsan commodo hendrerit adipiscing ea dolore. Accumsan legunt euismod lectorum anteposuerit eorum. Possim iusto feugiat claritatem dolore eleifend. Lius sit vero cum typi nostrud.</p>
				</div>
			</article>
		</div><?php */ ?>
		<script>
			jQuery(function(){
				jQuery('.events-feed .event.open').find('.row-more h2').text('Close');
				jQuery('.events-feed .event:not(".open")').find('.row-more h2').text('More Info')
				jQuery('.events-feed .event header').click(function(){
					jQuery(this).parent().toggleClass('open');
					jQuery(this).parents('.event.open').find('.row-more h2').text('Close');
					jQuery(this).parents('.event:not(".open")').find('.row-more h2').text('More Info')
				});
			});
		</script>
	</div>
	<div id="sidebar" class="right">		
		<?php dynamic_sidebar('sidebar-races-events'); ?>
	</div>
</div>
<?php get_footer(); ?>