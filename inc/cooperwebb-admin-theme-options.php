<?php

define('TON', 'cooperwebb_theme_options');

add_action( 'admin_menu', 'theme_options_page_init' );
function theme_options_page_init() {
	$options_page = add_theme_page(
		'Cooper Webb Theme Options',
		'Cooper Webb Theme Options',
		8,
		'theme-options',
		'theme_options_page'
	);
	add_action( "load-{$options_page}", 'theme_options_load_page' );
}

function theme_options_load_page() {	
	if ( $_POST["theme-options-form-submit"] == 'save' ) {
		check_admin_referer( "theme-options-page" );
		save_theme_options();
		$redirect_url = isset( $_GET['tab'] ) ? '&updated=true&tab='. $_GET['tab'] : '&updated=true';
		wp_redirect(admin_url('themes.php?page=theme-options'.$redirect_url));
		exit;
	}
}

function save_theme_options() {
	global $pagenow;
	$theme_options = get_option( TON );
	
	if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ){ 
		if ( isset ( $_GET['tab'] ) )
	        $tab = $_GET['tab']; 
	    else
	        $tab = 'general';        
        $except_POST = array("_wpnonce", "_wp_http_referer", "Submit", "theme-options-form-submit"); 

	    switch ( $tab ){ 
			case 'general' :
				foreach($_POST as $post_key => $post_value) {
                    if ( !in_array($post_key, $except_POST) ) {                    
						$theme_options[$post_key] = stripcslashes($post_value);                        
                    }					
				}
			break;
            case 'social-networks' :
                foreach($_POST as $post_key => $post_value) {
                    if ( !in_array($post_key, $except_POST) ) {                    
						$theme_options[$post_key] = stripcslashes($post_value);                        
                    }					
				}
            break;
            case 'header' :
				foreach($_POST as $post_key => $post_value) {
                    if ( !in_array($post_key, $except_POST) ) {                    
						$theme_options[$post_key] = stripcslashes($post_value);                        
                    }					
				}
			break;
            case 'footer' :
				foreach($_POST as $post_key => $post_value) {
                    if ( !in_array($post_key, $except_POST) ) {                    
						$theme_options[$post_key] = stripcslashes($post_value);                        
                    }					
				}
			break;	
	    }
	}    
	update_option( TON, $theme_options );
}

function theme_options_admin_tabs( $current = 'general' ) {
    $tabs = array( 'general' => 'General', 'social-networks' => 'Social Networks', 'header' => 'Header', 'footer' => 'Footer' ); 
    //$links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
		if ( $tab == $current ) {
			echo "<a class='nav-tab$class' href='?page=theme-options'>$name</a>";
		} else {
			echo "<a class='nav-tab$class' href='?page=theme-options&tab=$tab'>$name</a>";
		}
    }
    echo '</h2>';
}

function theme_options_page() {
	global $pagenow;
	$theme_options = get_option( TON );
    $sitepages = get_pages();    
	?>
	
	<div class="wrap">
		<h2>Cooper Webb Theme Options</h2>
		
		<?php
			if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme options saved.</p></div>';			
			if ( isset ( $_GET['tab'] ) ) {
				$action_url = admin_url( 'themes.php?page=theme-options&tab='.$_GET['tab'] );
				theme_options_admin_tabs($_GET['tab']);
			} else {
				$action_url = admin_url( 'themes.php?page=theme-options' );
				theme_options_admin_tabs();
			}
		?>

		<div id="poststuff">
			<form method="post" action="<?php echo $action_url; ?>">				
				<?php
				wp_nonce_field( "theme-options-page" );                
				
				if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ){ 
				
					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
					else $tab = 'general'; 
					
					echo '<table class="form-table">';
					switch ( $tab ){						
						case 'general' :
							/* ?>                            
                            <tr>
								<th><label for="cooperwebb_events_page">Events Page:</label></th>
								<td>
                                    <select name="cooperwebb_events_page">
                                        <option value=""> - Select page - </option>
                						<?php
                                        foreach($sitepages as $sitepage) {
                                            $selected = '';
                                            if ($sitepage->ID == $theme_options['cooperwebb_events_page']) $selected = ' SELECTED';
                                            ?>
                							<option value="<?php echo $sitepage->ID; ?>"<?php echo $selected; ?>><?php if ($sitepage->post_parent) { echo '&nbsp;&nbsp;&nbsp;&nbsp;'; } ?><?php echo $sitepage->post_title; ?></option>
                						<?php } ?>
                					</select>
                                </td>
							</tr> */ ?>
                            <tr>
								<th><label for="cooperwebb_videos_per_page">Videos per page:</label></th>
								<td>
									<input id="cooperwebb_videos_per_page" name="cooperwebb_videos_per_page" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_videos_per_page']); ?>" style="width:30px;" /> 
									<span class="description">Default: 12</span>
								</td>
							</tr>
							<?php 
						break;
                        case 'social-networks' :
                            ?>
                            <tr>
								<th><label for="cooperwebb_email">Email:</label></th>
								<td>
									<input id="cooperwebb_email" name="cooperwebb_email" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_email']); ?>" style="width:200px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th>FACEBOOK OPTIONS</th>
								<td>&nbsp;</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_facebook_user_name">User Name:</label></th>
								<td>
									<input id="cooperwebb_facebook_user_name" name="cooperwebb_facebook_user_name" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_facebook_user_name']); ?>" style="width:200px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th>TWITTER OPTIONS</th>
                                <?php
                                if ( $theme_options['cooperwebb_twitter_consumer_key'] != '' && $theme_options['cooperwebb_twitter_consumer_secret'] != '' && $theme_options['cooperwebb_twitter_access_token'] != '' && $theme_options['cooperwebb_twitter_access_token_secret'] != '') :
                                    $connection = getConnectionWithAccessToken( $theme_options['cooperwebb_twitter_consumer_key'], $theme_options['cooperwebb_twitter_consumer_secret'], $theme_options['cooperwebb_twitter_access_token'], $theme_options['cooperwebb_twitter_access_token_secret'] );
                                    $user_info = get_twitter_profile_info( $connection );                                    
                                    if ( $user_info ) :
                                        echo '<td><span style="color:green;">You are currently connected as '. $user_info['scr_nme'] .'</span></td>'; 
                                    else :
                                        echo '<td><span style="color:red;">Twitter params are incorrect!</span></td>';
                                    endif;
                                else :
                                    echo '<td>&nbsp;</td>';
                                endif;
                                ?>								
							</tr>                            
                            <tr>
								<th><label for="cooperwebb_twitter_consumer_key">Consumer Key:</label></th>
								<td>
									<input id="cooperwebb_twitter_consumer_key" name="cooperwebb_twitter_consumer_key" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_twitter_consumer_key']); ?>" style="width:450px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_twitter_consumer_secret">Consumer Secret:</label></th>
								<td>
									<input id="cooperwebb_twitter_consumer_secret" name="cooperwebb_twitter_consumer_secret" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_twitter_consumer_secret']); ?>" style="width:450px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_twitter_access_token">Access Token:</label></th>
								<td>
									<input id="cooperwebb_twitter_access_token" name="cooperwebb_twitter_access_token" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_twitter_access_token']); ?>" style="width:450px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_twitter_access_token_secret">Access Token Secret:</label></th>
								<td>
									<input id="cooperwebb_twitter_access_token_secret" name="cooperwebb_twitter_access_token_secret" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_twitter_access_token_secret']); ?>" style="width:450px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_twitter_cache_time">Twitter Cache Time:</label></th>
								<td>
									<input id="cooperwebb_twitter_cache_time" name="cooperwebb_twitter_cache_time" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_twitter_cache_time']); ?>" style="width:40px;" /> 
									<span class="description">in minutes (default is 60 min)</span>
								</td>
							</tr>
                            <tr>
								<th>INSTAGRAM OPTIONS</th>
								<td>&nbsp;</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_instagram_user_name">User Name:</label></th>
								<td>
									<input id="cooperwebb_instagram_user_name" name="cooperwebb_instagram_user_name" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_instagram_user_name']); ?>" style="width:200px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_instagram_user_id">User Id:</label></th>
								<td>
									<input id="cooperwebb_instagram_user_id" name="cooperwebb_instagram_user_id" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_instagram_user_id']); ?>" style="width:100px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_instagram_access_token">Access Token:</label></th>
								<td>
									<input id="cooperwebb_instagram_access_token" name="cooperwebb_instagram_access_token" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_instagram_access_token']); ?>" style="width:450px;" /> 
									<span class="description"></span>
								</td>
							</tr>                            
                            <?php   
                        break;
                        case 'header' :
                            ?>
                            <tr>
								<th><label for="cooperwebb_header_facebook">Facebook:</label></th>
								<td>
									<input id="cooperwebb_header_facebook" name="cooperwebb_header_facebook" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_header_facebook']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_header_twitter">Twitter:</label></th>
								<td>
									<input id="cooperwebb_header_twitter" name="cooperwebb_header_twitter" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_header_twitter']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>
                            <tr>
								<th><label for="cooperwebb_header_instagram">Instagram:</label></th>
								<td>
									<input id="cooperwebb_header_instagram" name="cooperwebb_header_instagram" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_header_instagram']); ?>" style="width:400px;" /> 
									<span class="description"></span>
								</td>
							</tr>                            
                            <?php
                        break;
                        case 'footer' :
                            ?>                                                                                  
                            <tr>
								<th><label for="cooperwebb_footer_copyright">Copyright:</label></th>
								<td>
									<input id="cooperwebb_footer_copyright" name="cooperwebb_footer_copyright" type="text" value="<?php echo htmlspecialchars($theme_options['cooperwebb_footer_copyright']); ?>" style="width:400px;" /> 
									<span class="description">Footer copyright text</span>
								</td>
							</tr>
                            <?php
                        break;               						
					}
					echo '</table>';
				}
				?>
				<p class="submit" style="clear: both;">
					<input type="submit" name="Submit"  class="button-primary" value="Save" />
					<input type="hidden" name="theme-options-form-submit" value="save" />
				</p>
			</form>			
			
		</div>

	</div>
<?php } ?>