<?php
/**
 * @package WordPress
 * @subpackage Base_Theme
 */
?>

<?php global $cooperwebb_theme_options; ?>

<?php get_header(); ?>

<?php if (get_field("videos")) : ?>
<section class="slider-video cf">
	<ul class="slides">
        <?php $i = 0; ?>
        <?php while( has_sub_field('videos') ): ?>
            <?php if ($i == 0) : ?>
                <li id="yt-video-<?php echo $i;?>" class="active">
            <?php else : ?>
                <li id="yt-video-<?php echo $i;?>">
            <?php endif; ?>
            <iframe width="707" height="333" src="//www.youtube.com/embed/<?php the_sub_field('video_id'); ?>?wmode=transparent&rel=0" frameborder="0" ></iframe>
            </li>
            <?php $i++; ?>
        <?php endwhile; ?>
	</ul>
	<ul class="thumbnails">
        <?php $i = 0; ?>
        <?php while( has_sub_field('videos') ): ?>
    		<li id="yt-video-thumb-<?php echo $i;?>" class="active">
                <?php if ( get_sub_field("video_thumb_image") ) : ?>
                    <img class="image" src="<?php echo get_thumb( get_sub_field("video_thumb_image"), 185, 104, 1 ); ?>" alt="<?php the_sub_field('video_title'); ?>" />
                <?php endif; ?>            
    			<div class="text">
    				<div class="holder">
    					<p><?php the_sub_field('video_title'); ?></p>
    				</div>
    			</div>
    			<img src="<?php echo TDU; ?>/images/ico-play.png" class="ico-play" alt="">
    		</li>
            <?php $i++; ?>
        <?php endwhile; ?>		
	</ul>
</section>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.slider-video .slides').cycle({
		activePagerClass: 'active',
		fx:     'fade', 
		speed:  600, 
		timeout: 0, 
		pager:  '.slider-video .thumbnails', 
		pagerAnchorBuilder: function(idx, slide) { 
			return '.slider-video .thumbnails li:eq(' + idx + ')'; 
		} 
	});
});
</script>
<?php endif; ?>

<?php
//facebook
$cfbun = $cooperwebb_theme_options['cooperwebb_facebook_user_name'];
if ($cfbun) :
    $likes = 0;
    $json_url = 'https://graph.facebook.com/'.$cfbun;
    $json = file_get_contents($json_url);
    $json_output = json_decode($json);
    if ( $json_output->likes )
        $likes = $json_output->likes;
    if ( $likes && $likes >= 1000 ) :
        $likes = round( $likes/1000, 1 ).'k';
    endif; 
endif;

$social_posts = array();

//twitter
$cons_key = $cooperwebb_theme_options['cooperwebb_twitter_consumer_key'];
$cons_secret = $cooperwebb_theme_options['cooperwebb_twitter_consumer_secret'];
$oauth_token = $cooperwebb_theme_options['cooperwebb_twitter_access_token'];
$oauth_token_secret = $cooperwebb_theme_options['cooperwebb_twitter_access_token_secret'];

if ( $cons_key != '' && $cons_secret != '' && $oauth_token != '' && $oauth_token_secret != '' ) :
        
    $notweets = 7;
    $tweets = cooperwebb_get_tweets($notweets);
    if ($tweets) :
        $i = 0;
        foreach ($tweets as $tweet) :                
            if ( $i == 0) :
                $twitter_screen_name = $tweet['user']['screen_name'];        
                $twitter_follows = $tweet['user']['followers_count'];
                if ( $twitter_follows >= 1000 )
                    $twitter_follows = round( $twitter_follows/1000, 1 ).'k';                                        
            endif;
            $social_posts[strtotime($tweet['created_at'])] = array(
                "type" => 'twitter',
                "tweet" => $tweet['text'],
                "created" => strtotime($tweet['created_at']),
                "id_str" => $tweet['id_str'],
                "total_retweet" => $tweet['retweet_count'],
                "total_favorite" => $tweet['favorite_count']
            );
            $i++;                
        endforeach;
    endif;
        
endif; 

//instagram
$ciun = $cooperwebb_theme_options['cooperwebb_instagram_user_name'];
$ciui = $cooperwebb_theme_options['cooperwebb_instagram_user_id'];
$ciat = $cooperwebb_theme_options['cooperwebb_instagram_access_token'];
if ( $ciui && $ciat ) :
    $instagram_follows = 0;
    $json_url = 'https://api.instagram.com/v1/users/'. $ciui .'/?access_token='. $ciat;
    $json = file_get_contents($json_url);
    $json_output = json_decode($json);
        
    if ( $json_output->data->counts->followed_by )
        $instagram_follows = $json_output->data->counts->followed_by;

    if ( $instagram_follows && $instagram_follows >= 1000 ) :
        $instagram_follows = round( $instagram_follows/1000, 1 ).'k';
    endif;
    
    $json_url = 'https://api.instagram.com/v1/users/'. $ciui .'/media/recent/?access_token='. $ciat .'&count=7';    
    $json = file_get_contents($json_url);
    $json_output = json_decode($json, true);
        
    foreach ($json_output['data'] as $key => $value) :        
        $social_posts[$value['created_time']] = array(
            "type" => 'instagram',
            "created" => $value['created_time'],
            "text" => $value['caption']['text'],
            "image" => $value["images"]["low_resolution"],
            "full_img" => $value["images"]["standard_resolution"],
            "link" => $value['link'],
            "total_comments" => $value['comments']['count'],
            "total_likes" => $value['likes']['count']            
        );                        
    endforeach;
    
endif;
?>

<div id="main">
	<section class="socials-section">
		<div class="title-row cf">
			<div class="facebook">
				<div class="fb-like" data-href="<?php echo home_url('/'); ?>" data-layout="standard" data-action="like" data-show-faces="true" data-width="170"></div>
			</div>
			<h2 class="section-title">Connect with cooper webb</h2>
		</div>
		<div class="socials-list cf">
            <?php if ( count($social_posts) > 0 ) : ?>
                <?php
                krsort($social_posts);
                $social_posts = array_slice($social_posts, 0, 7);
                $i = 0;
                ?>
                <?php foreach ($social_posts as $soc_post) : ?>
                    <?php if ( $i == 3 ) : ?>
                        <div class="item socials-item">
            				<ul class="socials-square">                               
                                <?php if ( $twitter_screen_name ) : ?>
            					<li class="twitter">
                                    <?php if ($twitter_follows) : ?>
            						<a href="https://twitter.com/<?php echo $twitter_screen_name; ?>"><?php echo $twitter_follows; ?></a>
                                    <?php endif; ?>
            					</li>
                                <?php endif; ?>
                                <?php if ( $cfbun ) : ?>
            					<li class="facebook">
                                    <?php if ($likes) : ?>
            						<a href="https://www.facebook.com/<?php echo $cfbun; ?>" target="_blank"><?php echo $likes; ?></a>
                                    <?php endif; ?>
            					</li>
                                <?php endif; ?>
                                <?php if ( $ciun ) : ?>
            					<li class="instagram">
                                    <?php if ( $instagram_follows ) : ?>
            						<a href="http://instagram.com/<?php echo $ciun; ?>"><?php echo $instagram_follows; ?></a>
                                    <?php endif; ?>
            					</li>
                                <?php endif; ?>
                                <?php if ( $cooperwebb_theme_options['cooperwebb_email'] ) : ?>
            					<li class="email">
            						<a href="mailto:<?php echo $cooperwebb_theme_options['cooperwebb_email']; ?>">EMAIL</a>
            					</li>
                                <?php endif; ?>
            				</ul>
            			</div>
                    <?php endif; ?>
                    <?php if ( $soc_post['type'] == 'instagram' ) : ?>
                        <div class="item">
            				<a href="#<?php echo $soc_post['created']; ?>" class="link">
                                <img class="image" src="<?php echo $soc_post["image"]['url']; ?>" alt=" " />
                            </a>
            				<img src="<?php echo TDU; ?>/images/icon-instagram.png" alt="" class="ico">
            			</div>
                        <div style="display: none;">
                            <div id="<?php echo $soc_post['created']; ?>" class="popup-s">
                        		<div class="holder">
                                    <img src="<?php echo $soc_post["full_img"]["url"]; ?>" width="640" height="640" alt=" "/>
                        			<div class="header cf">
                        				<a href="<?php echo $soc_post['link']; ?>" class="link" target="_blank"><?php echo date ('F j, Y', $soc_post['created']); ?> via Instagram</a>
                        				<div class="right">
                        					<span class="i-comments"><?php echo $soc_post['total_comments']; ?></span>
                        					<span class="i-likes"><?php echo $soc_post['total_likes']; ?></span>
                        				</div>
                        			</div>
                        			<div class="content">
                                        <?php                                        
                                        $text = $soc_post['text'];
                                        $text = social_link_make_clickable($text);
                                        $pattern = '/(@([_a-z0-9\-]+))/i';
                    					$replace = '<a href="http://instagram.com/$2" rel="nofollow" target="_blank">$1</a>';
                    					$text = preg_replace($pattern,$replace,$text);
                                        ?>
                        				<p><?php echo $text; ?></p>
                        			</div>
                        		</div>
                        	</div>
                        </div>
                    <?php else : ?>
                        <div class="item twitter">
                            <?php
                            $twt = social_link_make_clickable($soc_post['tweet']);
                            $pattern = '/(\s\#([_a-z0-9\-]+))/i';
                            $replace = '<a href="https://twitter.com/search?q=%23$2&src=hash" target="_blank">$1</a>';
                            $twt = preg_replace($pattern,$replace,$twt);
                            $pattern = '/(@([_a-z0-9\-]+))/i';
        					$replace = '<a href="http://twitter.com/$2" title="Follow $2" target="_blank">$1</a>';
        					$twt = preg_replace($pattern,$replace,$twt);
                            ?>
            				<p><?php echo $twt; ?></p>                             
            				<span class="date"><?php echo social_time_span($soc_post['created']); ?></span>
            				<img src="<?php echo TDU; ?>/images/icon-twitter.png" alt="" class="ico">
            				<a href="#<?php echo $soc_post['created']; ?>" class="link"></a>
            			</div>
                        <div style="display: none;">
                            <div id="<?php echo $soc_post['created']; ?>" class="popup-s">
                        		<div class="holder">
                        			<div class="header cf">
                        				<a href="http://www.twitter.com/<?php echo $twitter_screen_name; ?>/status/<?php echo $soc_post['id_str']; ?>" class="link" target="_blank"><?php echo date ('F j, Y', $soc_post['created']); ?> via Twitter</a>
                        				<div class="right">
                        					<span class="i-comments"><?php echo $soc_post['total_retweet']; ?></span>
                        					<span class="i-likes"><?php echo $soc_post['total_favorite']; ?></span>
                        				</div>
                        			</div>
                        			<div class="content">                                        
                        				<p><?php echo $twt; ?></p>
                        			</div>
                        		</div>
                        	</div>
                        </div>                                                
                    <?php endif; ?>
                    <?php $i++; ?>
                <?php endforeach; ?>
            <?php endif; ?>            
		</div>
	</section>
    
	<section class="data-section cf">
    
        <?php // Begin Latest Posts ?>
           
		<aside class="news-area">
            <?php if ( get_field("recent_posts_title") ) : ?>
			<h2 class="section-title"><?php the_field("recent_posts_title"); ?></h2>
            <?php endif; ?>
            <?php
            $ppp = get_field("recent_posts_count") ? get_field("recent_posts_count") : 3;            
            $rposts = new WP_Query("post_type=post&posts_per_page=".$ppp);
            ?>
            <?php if ( $rposts->have_posts() ) : ?>
                <ul class="news-list">
                <?php while ( $rposts->have_posts() ) : $rposts->the_post(); ?>
                    <li>
    					<a href="<?php the_permalink(); ?>" class="cf">
    						<span class="entry-date">
    							<strong><?php echo get_the_date('d'); ?></strong>
    							<span><?php echo get_the_date('M'); ?></span>
    						</span>
    						<h5><?php the_title(); ?></h5>
    					</a>
    				</li>
                <?php endwhile; ?>
                </ul>
            <?php endif; ?>
            <?php wp_reset_postdata(); 	?>			
		</aside>
        
        <?php // End Latest Posts ?>
        
        <?php // Begin Upcoming Events ?>
        
        <?php
        $upcoming_events_count = get_field("upcoming_events_count") ? get_field("upcoming_events_count") : 6;   
        $upcoming_events = cooperwebb_get_upcoming_events($upcoming_events_count);
        ?>
        <?php if ($upcoming_events) : ?>
            <?php $events_page = $cooperwebb_theme_options['cooperwebb_events_page']; ?>
    		<aside class="events-area">
                <?php if ( get_field("upcoming_events_title") ) : ?>
    			<h2 class="section-title"><?php the_field("upcoming_events_title"); ?></h2>
                <?php endif; ?>            
                <?php if ( count($upcoming_events) > 2 ) : ?>
    			<div class="events-control">
    				<a href="#" class="link-prev">Prev</a>
    				<a href="#" class="link-next">Next</a>
    			</div>
                <?php endif; ?>
    			<div class="list-events-holder">
    				<ul class="list-events cf">
                        <?php $i = 1; ?>
                        <?php foreach ($upcoming_events as $key => $value) :
                			$ID = $value['ID'];			
                			$day = date("d", strtotime($value["datetime_start"]));
                			$month = date("M", strtotime($value["datetime_start"]));
                			$title = $value['title'];
                            $city = $value['city'];
                            $state = $value['state'];
                			$venue = $value['venue'];
                            if ($i%2 != 0) echo '<li>';
                        ?>
                            <a href="<?php echo get_permalink($ID); ?>">
    							<span class="entry-date">
    								<strong><?php echo $day; ?></strong>
    								<span><?php echo $month; ?></span>
    							</span>
    							<div class="text">
    								<strong class="pink"><?php echo $title; ?></strong>
    								<strong class="grey">
                                        <?php echo $city; ?>
                                        <?php if ( !empty($state) ) echo ', ' . $state; ?>
                                    </strong>
    								<strong>@<?php echo $venue; ?></strong>
    							</div>
    							<img src="<?php echo TDU; ?>/images/icon-plus.png" alt="" class="ico-plus">
    						</a>
                        <?php
                            if ($i%2 == 0 || count($latest_events) == $i) echo '</li>';
                            $i++;
                        ?>
                		<?php endforeach; ?>
    				</ul>
    			</div>
    		</aside>
            <?php if ( count($upcoming_events) > 2 ) : ?>
                <script type="text/javascript">
                jQuery(document).ready(function(){
                    jQuery('.list-events').cycle({
            			activePagerClass: 'active',
            			fx:     'scrollHorz', 
            			speed:  300, 
            			timeout: 0,                                                
            			prev: '.events-control .link-prev',
            			next: '.events-control .link-next'
            		});
                });
                </script>
            <?php endif; ?>
        <?php endif; ?>
        
        <?php // End Upcoming Events ?>
        
	</section>
</div>

<?php get_footer(); ?>