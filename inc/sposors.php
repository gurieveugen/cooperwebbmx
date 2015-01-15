<?php

add_action('init', 'sponsors_custom_init');
function sponsors_custom_init() 
{
  $labels = array(
    'name' => _x('Sponsors', 'post type general name'),
    'singular_name' => _x('Sponsor', 'post type singular name'),
    'add_new' => _x('Add New', 'Sponsor'),
    'add_new_item' => __('Add New Sponsor'),
    'edit_item' => __('Edit Sponsor'),
    'new_item' => __('New Sponsor'),
    'view_item' => __('View Sponsor'),
    'search_items' => __('Search Sponsor'),
    'not_found' =>  __('No Sponsor found'),
    'not_found_in_trash' => __('No Sponsor found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,    
    'rewrite' => array('slug' => 'sponsor', 'with_front' => FALSE),
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => null,
    'exclude_from_search' => true,
    'supports' => array('title', 'thumbnail', 'page-attributes')
  ); 
  register_post_type('sponsor',$args);
}


//add filter to insure the text Sponsor, or Sponsor, is displayed when user updates a Sponsor 
add_filter('post_updated_messages', 'sponsors_updated_messages');
function sponsors_updated_messages( $messages ) {

  $messages['Sponsor'] = array(
    0 => '', // Unused. Messages start at index 1.
    1 => sprintf( __('Sponsor updated. <a href="%s">View Sponsor</a>'), esc_url( get_permalink($post_ID) ) ),
    2 => __('Custom field updated.'),
    3 => __('Custom field deleted.'),
    4 => __('Sponsor updated.'),
    /* translators: %s: date and time of the revision */
    5 => isset($_GET['revision']) ? sprintf( __('Sponsor restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
    6 => sprintf( __('Sponsor published. <a href="%s">View Sponsor</a>'), esc_url( get_permalink($post_ID) ) ),
    7 => __('Sponsor saved.'),
    8 => sprintf( __('Sponsor submitted. <a target="_blank" href="%s">Preview Sponsor</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
    9 => sprintf( __('Sponsor scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Sponsor</a>'),
      // translators: Publish box date format, see http://php.net/date
      date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
    10 => sprintf( __('Sponsor draft updated. <a target="_blank" href="%s">Preview Sponsor</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
  );

  return $messages;
}

//display contextual help for Sponsor
add_action( 'contextual_help', 'aogr_sponsors_help_text', 10, 3 );

function aogr_sponsors_help_text($contextual_help, $screen_id, $screen) { 
  //$contextual_help = . var_dump($screen); // use this to help determine $screen->id
  if ('Sponsor' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a Sponsor:') . '</p>' .
      '<ul>' .
      '<li>' . __('Specify the correct genre such as Mystery, or Historic.') . '</li>' .
      '<li>' . __('Specify the correct writer of the Sponsor.  Remember that the Author module refers to you, the author of this Sponsor review.') . '</li>' .
      '</ul>' .
      '<p>' . __('If you want to schedule the Sponsor review to be published in the future:') . '</p>' .
      '<ul>' .
      '<li>' . __('Under the Publish module, click on the Edit link next to Publish.') . '</li>' .
      '<li>' . __('Change the date to the date to actual publish this article, then click on Ok.') . '</li>' .
      '</ul>' .
      '<p><strong>' . __('For more information:') . '</strong></p>' .
      '<p>' . __('<a href="http://codex.wordpress.org/Posts_Edit_SubPanel" target="_blank">Edit Posts Documentation</a>') . '</p>' .
      '<p>' . __('<a href="http://wordpress.org/support/" target="_blank">Support Forums</a>') . '</p>' ;
  } elseif ( 'edit-Sponsor' == $screen->id ) {
    $contextual_help = 
      '<p>' . __('This is the help screen displaying the table of Sponsor blah blah blah.') . '</p>' ;
  }
  return $contextual_help;
}

// Adds slide image and link to slides column view	
add_filter( 'manage_edit-sponsor_columns', 'sponsors_edit_columns' ); 
function sponsors_edit_columns( $columns ) {	
	$columns = array(		
		'cb'         => '<input type="checkbox" />',			
		'title'      => 'Sponsor Title',
		'sponsor-logo' => 'Sponsor Logo',
		'order'      => 'Sponsor Order'
	); 
	return $columns;  
}

add_action( 'manage_posts_custom_column', 'sponsor_custom_columns' );	
function sponsor_custom_columns( $column ) {
	global $post; 
	switch ( $column ) {		
		case 'sponsor-logo' :			
			echo get_the_post_thumbnail( $post->ID, 'full');			
		break;
		case 'order' :			
			echo $post->menu_order;			
		break;
	}		
}

add_filter('pre_get_posts', 'sponsor_admin_order');
function sponsor_admin_order($wp_query) {
  if (is_admin()) {

    // Get the post type from the query
    $post_type = $wp_query->query['post_type'];

    if ( $post_type == 'sponsor') {

      // 'orderby' value can be any column name
      $wp_query->set('orderby', 'menu_order');

      // 'order' value can be ASC or DESC
      $wp_query->set('order', 'ASC');
    }
  }
}

add_action( 'admin_menu', 'sponsor_meta_boxes');
function sponsor_meta_boxes(){
	add_meta_box("sponsor-options", "Sponsor Options", "sponsor_options_box", "sponsor", "normal", "high");
}

function sponsor_options_box(){
	global $post;
	echo '<input type="hidden" name="sponsor_noncename" id="sponsor_noncename" value="' . 
    wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
	$sponsor_site = get_post_meta($post->ID, 'sponsor_site', true);
?>
    <label for="sponsor_site">Site:</label>
	<input type="text" name="sponsor_site" value="<?php echo $sponsor_site; ?>" style="width:600px;" />
<?php
}

add_action('save_post', 'sponsor_save');
function sponsor_save($post_id){
	global $post;
	
	if ( !wp_verify_nonce( $_POST['sponsor_noncename'], plugin_basename(__FILE__) )) {
	    return $post_id;
	}
	
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;
	
	if($post->post_type == 'sponsor' && $_SERVER['REQUEST_METHOD'] == 'POST') {
		update_post_meta($post->ID, "sponsor_site", trim($_POST["sponsor_site"]));		
	}
}
?>