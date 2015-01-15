<?php
session_start();
define('TDU', get_bloginfo('template_url'));

require_once (dirname (__FILE__) . '/inc/cooperwebb-admin-theme-options.php');
require_once (dirname (__FILE__) . '/inc/sposors.php');
require_once (dirname (__FILE__) . '/inc/twitteroauth/twitteroauth.php');
require_once (dirname (__FILE__) . '/inc/widgets.php');

$cooperwebb_theme_options = get_option( "cooperwebb_theme_options" );

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
add_filter( 'use_default_gallery_style', '__return_false' );

/*register_sidebar(array(
	'id' => 'right-sidebar',
	'name' => 'Right Sidebar',
	'before_widget' => '<div class="widget %2$s" id="%1$s">',
	'after_widget' => '</div>',
	'before_title' => '<h3>',
	'after_title' => '</h3>'
));*/
register_sidebar(array(
	'id' => 'sidebar-races-events',
	'name' => 'Sidebar Races &amp; Events',
	'before_widget' => '<aside class="widget %2$s" id="%1$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="section-title">',
	'after_title' => '</h3>'
));
register_sidebar(array(
	'id' => 'sidebar-news',
	'name' => 'Sidebar News',
	'before_widget' => '<aside class="widget %2$s" id="%1$s">',
	'after_widget' => '</aside>',
	'before_title' => '<h3 class="section-title">',
	'after_title' => '</h3>'
));

add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 604, 270, true );

register_nav_menus(array(
	'primary_nav' => __( 'Primary Navigation' ),
    'footer_nav' => __( 'Footer Navigation' )
));

function change_menu_classes($css_classes){
	$css_classes = str_replace("current-menu-item", "current-menu-item active", $css_classes);
	$css_classes = str_replace("current-menu-parent", "current-menu-parent active", $css_classes);
	return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes');

function filter_template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'filter_template_url');
add_filter('get_the_content', 'filter_template_url');
add_filter('widget_text', 'filter_template_url');

add_action('wp_enqueue_scripts', 'scripts_method');
function scripts_method() {
	wp_deregister_script( 'jquery' );
	wp_register_script( 'jquery', TDU.'/js/jquery-1.11.0.min.js');
	wp_enqueue_script( 'jquery' );
}

// register tag [template-url]
function template_url($text) {
	return str_replace('[template-url]',get_bloginfo('template_url'), $text);
}
add_filter('the_content', 'template_url');
add_filter('get_the_content', 'template_url');
add_filter('widget_text', 'template_url');

/**
 * Get lastest events from "The Events Calendar" plugin
 * @param  integer $count_events how mutch events we need to get
 * @return array
 */
function cooperwebb_get_upcoming_events($count_events = 4)
{
	$upcoming = tribe_get_events( array('eventDisplay'=>'upcoming', 'posts_per_page'=>$count_events) );	
	
	$res = array();
	$i = 0;

	foreach ($upcoming as $key => $value) {
		$res[$i]['ID'] = $value->ID;
		$res[$i]['title'] = $value->post_title;		
		$res[$i]['content'] = $value->post_content;
        $res[$i]['city'] = tribe_get_city($value->ID);
        $res[$i]['state'] = tribe_get_state($value->ID);
		$res[$i]['venue'] = tribe_get_venue($value->ID);
        $res[$i]['datetime_start'] = tribe_get_start_date( $value, false, "c" );
		$res[$i]['datetime_end']   = tribe_get_end_date( $value, false, "c" );        		
		$i++;
	}
    
	return $res;
}

function get_thumb($attach_id, $width, $height, $crop = false) {
	if (is_numeric($attach_id)) {
		$image_src = wp_get_attachment_image_src($attach_id, 'full');
		$file_path = get_attached_file($attach_id);
	} else {
		$imagesize = getimagesize($attach_id);
		$image_src[0] = $attach_id;
		$image_src[1] = $imagesize[0];
		$image_src[2] = $imagesize[1];
		$file_path = $_SERVER["DOCUMENT_ROOT"].str_replace(get_bloginfo('siteurl'), '', $attach_id);
		
	}
	
	$file_info = pathinfo($file_path);
	$extension = '.'. $file_info['extension'];

	// image path without extension
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];

	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;

	// if file size is larger than the target size
	if ($image_src[1] > $width || $image_src[2] > $height) {
		// if resized version already exists
		if (file_exists($cropped_img_path)) {
			return str_replace(basename($image_src[0]), basename($cropped_img_path), $image_src[0]);
		}

		if (!$crop) {
			// calculate size proportionaly
			$proportional_size = wp_constrain_dimensions($image_src[1], $image_src[2], $width, $height);
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;			

			// if file already exists
			if (file_exists($resized_img_path)) {
				return str_replace(basename($image_src[0]), basename($resized_img_path), $image_src[0]);
			}
		}

		// resize image if no such resized file
		$new_img_path = image_resize($file_path, $width, $height, $crop);
		$new_img_size = getimagesize($new_img_path);
		return str_replace(basename($image_src[0]), basename($new_img_path), $image_src[0]);
	}

	// return without resizing
	return $image_src[0];
}

function get_featured_image_id($pid) { 
	return get_post_meta($pid, '_thumbnail_id', true);
}

/* Begin twitter functions */

function getConnectionWithAccessToken( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret ) {
  $connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
  return $connection;
}



function get_twitter_profile_info( $cls ) {	
	     
	$usr = json_decode($cls->get('account/verify_credentials'));    
	if($usr->screen_name != '')
		return array(
			'img_url' => $usr->profile_image_url,
			'nme' => $usr->name,
			'scr_nme' => $usr->screen_name,
			'dtp_crt' => $usr->created_at,
			'tot_frd' => $usr->friends_count,
			'tot_flw' => $usr->followers_count,
			'tot_sts' => $usr->statuses_count
		);
	else
		return false;
}

function cooperwebb_get_tweets( $tweet_count = 10 ) {
    global $cooperwebb_theme_options;
    
    $cons_key = $cooperwebb_theme_options['cooperwebb_twitter_consumer_key'];
    $cons_secret = $cooperwebb_theme_options['cooperwebb_twitter_consumer_secret'];
    $oauth_token = $cooperwebb_theme_options['cooperwebb_twitter_access_token'];
    $oauth_token_secret = $cooperwebb_theme_options['cooperwebb_twitter_access_token_secret'];
    $cache_time = ($cooperwebb_theme_options['cooperwebb_twitter_cache_time']) ? $cooperwebb_theme_options['cooperwebb_twitter_cache_time'] * 60 : 3600;
            
    $upload     = wp_upload_dir();
    $upload_dir = $upload['basedir'] . "/cache";
    
    if ( ! file_exists($upload_dir) ) :    
        if ( ! mkdir($upload_dir)) :        
            $output .= '<span style="color: red;">could not create dir' . $upload_dir . ' please create this directory</span>';
            return $output;
        endif;
    endif;
    
    $cache = false;
    $cFile = "$upload_dir/cooperweb_tweets.txt";
    
    if ( file_exists($cFile) ) :        
        $modtime = filemtime($cFile);
        $timeago = time() - $cache_time;
        
        // Check if length is less than new limit
        $str     = file_get_contents($cFile);
        $content = unserialize($str);
        $length = count($content);
        
        if ( $modtime < $timeago )
            $cache = false;
        else
            $cache = true;
    endif;
    $result = array();
    if ( $cache === false && $cons_key != '' && $cons_secret != '' && $oauth_token != '' && $oauth_token_secret != '' ) :
        $connection = new TwitterOAuth( $cons_key, $cons_secret, $oauth_token, $oauth_token_secret );
        if ( $connection ) :
            $user_info = get_twitter_profile_info( $connection );
            $result['user_info'] = $user_info;
            
            $json = json_decode($connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=". $user_info['scr_nme'] ."&count=". $tweet_count ."&include_rts=false"), true);
            $length = count($json);
            
            for ($i = 0; $i < $length; $i++) :
                $feeds[] = $json[$i];                
                $content[] = $json[$i];
            endfor;
            
            $fp = fopen($cFile, 'w');
            if ( $fp ) :            
                $str = serialize($content);
                fwrite($fp, $str);
            endif;
            fclose($fp);
                
    		$content = null;
        endif;
            
    else :
    
        $str = file_get_contents($cFile);
        $content = unserialize($str);
        $length = count($content);
        for ($i = 0; $i < $length; $i++) :
            $feeds[] = $content[$i];
        endfor;
        
    endif;
    
    return $feeds;
}

function social_time_span($unix_date, $short_val = false){
    
    if ( $short_val )
        $periods = array("sec", "min", "h", "d", "w", "m", "y", "dec");
    else 
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        
	$lengths = array("60","60","24","7","4.35","12","10"); 
	
 	$now = time();
	
	if(empty($unix_date))  
		return "Bad date";
		 
	if($now > $unix_date){
		$difference = $now - $unix_date;
		$tense = "ago";	 
	}else{
		$difference = $unix_date - $now;
		$tense = "from now";
	}
 
	for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
		$difference /= $lengths[$j];
		 
	$difference = round($difference);
 
	if($difference != 1 && !$short_val)    
		$periods[$j].= "s";
	$per = __($periods[$j]);
	
    if ( $short_val )
        return $difference.$per;    
        
	return $difference.' '.$per.' '.__($tense);    
}

function social_link_make_clickable($ret){
	
	$ret = ' ' . $ret;
	
	$has_url = preg_match_all('#(?<=[\s>])(\()?([\w]+?://(?:[\w\\x80-\\xff\#$%&~/\-=?@\[\](+]|[.,;:](?![\s<])|(?(1)\)(?![\s<])|\)))+)#is', $ret, $tmp);
	if($has_url){
		foreach($tmp[2] AS $aV){
			$url = esc_url($aV);
			$rpc = '<a href="'.$url.'" rel="nofollow" target="_blank">'.$url.'</a>';
			$ret = str_replace($aV, $rpc, $ret);
		}
	}
	$ret = preg_replace("#(<a( [^>]+?>|>))<a [^>]+?>([^>]+?)</a></a>#i", "$1$3</a>", $ret);
	$ret = trim($ret);
	return $ret;
}

/* End twitter functions */

function short_content($content,$sz = 500,$more = '...') {
	if (strlen($content)<$sz) return $content;
	$p = strpos($content, " ",$sz);
	if (!$p) return $content;
	$content = strip_tags($content);
	if (strlen($content)<$sz) return $content;
	$p = strpos($content, " ",$sz);
	if (!$p) return $content;
	return substr($content, 0, $p).$more;
}

add_filter('wp_list_categories', 'add_tag_to_cat_count');
function add_tag_to_cat_count($links) {
    $links = str_replace('</a> (', '</a> <i>', $links);
    $links = str_replace(')', '</i>', $links);
    return $links;
}

function get_post_cats ($pid) {
    $post_categories = wp_get_post_categories( $pid );
    $cats = array();
    	
    foreach($post_categories as $c){
    	$cat = get_category( $c );
    	$cats[] = $cat->name;
    }
    
    return $cats;
}