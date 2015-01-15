<?php

add_action('widgets_init', create_function('', 'return register_widget("CooperWebb_Twitter_Widget");'));
class CooperWebb_Twitter_Widget extends WP_Widget {
	function __construct() {
		$widget_ops = array('classname' => 'widget_tweets', 'description' => __('Latest tweets widget'));
		$control_ops = array('width' => 250, 'height' => 400);
		$this->WP_Widget('widget_tweets', __('CooperWebb: Twitter Widget'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
        global $cooperwebb_theme_options;
		extract($args);
        
		$title = apply_filters('widget_title', $instance['title']);
		$tweets_count = ($instance['tweets_count']) ? $instance['tweets_count'] : 2;

		echo $before_widget;
        
        if ($title) echo $before_title . $title . $after_title;
        
        $cons_key = $cooperwebb_theme_options['cooperwebb_twitter_consumer_key'];
        $cons_secret = $cooperwebb_theme_options['cooperwebb_twitter_consumer_secret'];
        $oauth_token = $cooperwebb_theme_options['cooperwebb_twitter_access_token'];
        $oauth_token_secret = $cooperwebb_theme_options['cooperwebb_twitter_access_token_secret'];
        
        if ( $cons_key != '' && $cons_secret != '' && $oauth_token != '' && $oauth_token_secret != '' ) :
            
            $tweets = cooperwebb_get_tweets();            
            if ($tweets) :
                $tweets = array_slice($tweets, 0, $tweets_count);
                echo '<ul class="tweets-list">';
                $i = 0;
                foreach ($tweets as $tweet) :                
                    if ( $i == 0) :
                        $twitter_screen_name = $tweet['user']['screen_name'];        
                        $twitter_follows = $tweet['user']['followers_count'];
                        if ( $twitter_follows >= 1000 )
                            $twitter_follows = round( $twitter_follows/1000, 1 ).'k';                                        
                    endif;                                        
                        $twt = social_link_make_clickable($tweet['text']);
                        $pattern = '/(\s\#([_a-z0-9\-]+))/i';
                        $replace = '<a href="https://twitter.com/search?q=%23$2&src=hash" target="_blank">$1</a>';
                        $twt = preg_replace($pattern,$replace,$twt);
                        $pattern = '/(@([_a-z0-9\-]+))/i';
    					$replace = '<a href="http://twitter.com/$2" title="Follow $2" target="_blank">$1</a>';
    					$twt = preg_replace($pattern,$replace,$twt);
                        ?>                        
                        <li>
        				<div class="header">
        					<img src="<?php echo TDU; ?>/images/ico-tweet.png" alt=" ">
        					<strong><a href="https://twitter.com/<?php echo $twitter_screen_name; ?>"><?php echo $twitter_name; ?></a></strong>
        					<span>@<?php echo $twitter_screen_name; ?> - <?php echo social_time_span(strtotime($tweet['created_at']), 1); ?></span>
        				</div>
        				<p><?php echo $twt; ?></p>
                        </li>
                        <?php
                    $i++;                
                endforeach;
                echo '</ul>';
                ?>
                <div class="btn-holder">
        			<a href="https://twitter.com/<?php echo $twitter_screen_name; ?>" class="btn-twitter">
        				<strong>Follow @<?php echo $twitter_screen_name; ?></strong>
        				<i><?php echo $twitter_follows; ?></i>
        			</a>
        		</div>
                <?php
            endif;
        
        
        
        
            /*$connection = getConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
            $user_info = get_twitter_profile_info( $connection );
                
            if ( $user_info ) :
            
                echo '<ul class="tweets-list">';
                
                $twitter_name = $user_info['nme'];
                $twitter_screen_name = $user_info['scr_nme'];
                $twitter_follows = $user_info['tot_flw'];
                if ( $twitter_follows >= 1000 )
                    $twitter_follows = round( $twitter_follows/1000, 1 ).'K';
                    
                $tweets = json_decode($connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=". $twitter_screen_name ."&count=". $tweets_count ."&include_rts=false"));
                if ($tweets) :
                    foreach ($tweets as $tweet) :
                        $twt = social_link_make_clickable($tweet->text);
                        $pattern = '/(\s\#([_a-z0-9\-]+))/i';
                        $replace = '<a href="https://twitter.com/search?q=%23$2&src=hash" target="_blank">$1</a>';
                        $twt = preg_replace($pattern,$replace,$twt);
                        $pattern = '/(@([_a-z0-9\-]+))/i';
    					$replace = '<a href="http://twitter.com/$2" title="Follow $2" target="_blank">$1</a>';
    					$twt = preg_replace($pattern,$replace,$twt);
                        ?>                        
                        <li>
        				<div class="header">
        					<img src="<?php echo TDU; ?>/images/ico-tweet.png" alt=" ">
        					<strong><a href="https://twitter.com/<?php echo $twitter_screen_name; ?>"><?php echo $twitter_name; ?></a></strong>
        					<span>@<?php echo $twitter_screen_name; ?> - <?php echo social_time_span(strtotime($tweet->created_at), 1); ?></span>
        				</div>
        				<p><?php echo $twt; ?></p>
                        </li>
                        <?php
                    endforeach;
                endif;
                
                echo '</ul>';
                ?>
                <div class="btn-holder">
        			<a href="https://twitter.com/<?php echo $twitter_screen_name; ?>" class="btn-twitter">
        				<strong>Follow @<?php echo $twitter_screen_name; ?></strong>
        				<i><?php echo $twitter_follows; ?></i>
        			</a>
        		</div>
                <?php                                
            endif;*/
        
        endif;
		        
		echo $after_widget;
	}
    
	function update( $new_instance, $old_instance ) {
        $instance['title'] = $new_instance['title'];
		$instance['tweets_count'] = $new_instance['tweets_count'];        
		return $instance;
	}

	function form( $instance ) {
        $defaults = array('tweets_count' => 2);
		$instance = wp_parse_args( (array) $instance, $defaults );
    ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tweets_count'); ?>"><?php _e('Tweets Count:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('tweets_count'); ?>" name="<?php echo $this->get_field_name('tweets_count'); ?>" type="text" value="<?php echo $instance['tweets_count']; ?>" style="width: 30px;" />
        </p>
        
	<?php }
}

add_action('widgets_init', create_function('', 'return register_widget("CooperWebb_Latest_Posts_Widget");'));
class CooperWebb_Latest_Posts_Widget extends WP_Widget {
    
	function __construct() {
		$widget_ops = array('classname' => 'news-area', 'description' => __('Your site’s most latest posts.'));
		$control_ops = array('width' => 250, 'height' => 400);
		$this->WP_Widget('news-area', __('CooperWebb: Latest Posts'), $widget_ops, $control_ops);
	}

	function widget( $args, $instance ) {
		extract($args);        
        
		$title = apply_filters('widget_title', $instance['title']);
		$num_posts = ($instance['num_posts']) ? $instance['num_posts'] : 3;        
        $cat = $instance['cat'];
                        

		echo $before_widget;
        
        if ( $title ) echo $before_title . $title . $after_title;
        
        $args = array(
            'posts_per_page' => $num_posts
        );
        if ($cat) $args['cat'] = $cat;
        
        $latests_posts = get_posts( $args );
                
        if ($latests_posts) : ?>
            <ul class="news-list">                
                <?php foreach ($latests_posts as $l_post) : ?>                    
                    <li>
    					<a href="<?php echo get_permalink($l_post->ID); ?>" class="cf">
    						<span class="entry-date">
    							<strong><?php echo get_the_time('d', $l_post->ID); ?></strong>
    							<span><?php echo get_the_time('M', $l_post->ID); ?></span>
    						</span>
    						<h5><?php echo $l_post->post_title; ?></h5>
    					</a>
    				</li>
                <?php endforeach; ?>
            </ul>
        <?php endif;        
		        
		echo $after_widget;
	}
    
	function update( $new_instance, $old_instance ) {
        $instance['title'] = $new_instance['title'];
		$instance['num_posts'] = $new_instance['num_posts'];
        $instance['cat'] = $new_instance['cat'];
		return $instance;
	}

	function form( $instance ) {
        $defaults = array('num_posts' => 3);
		$instance = wp_parse_args( (array) $instance, $defaults );
        $categories = get_categories('hide_empty=0&orderby=name&order=ASC');
    ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('num_posts'); ?>"><?php _e('Number of Posts:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('num_posts'); ?>" name="<?php echo $this->get_field_name('num_posts'); ?>" type="text" value="<?php echo $instance['num_posts']; ?>" />            
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Category:'); ?></label>           
            <select id="<?php echo $this->get_field_id('cat'); ?>" name="<?php echo $this->get_field_name('cat'); ?>" class="widefat" style="width:100%;">
                <option value="">Select category</option>
                <?php foreach(get_terms('category','parent=0&hide_empty=0') as $term) { ?>
                <option <?php selected( $instance['cat'], $term->term_id ); ?> value="<?php echo $term->term_id; ?>"><?php echo $term->name; ?></option>
                <?php } ?>      
            </select>          
        </p>
        
	<?php }
    
}