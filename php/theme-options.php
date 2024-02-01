<?php

if ( is_admin() ) : // Load only if we are viewing an admin page

/**
 * De Coöperatie Fabriek Tabbed Settings Page
 */

add_action( 'init', 'dcf_admin_init' );
add_action( 'admin_menu', 'dcf_settings_page_init' );

function dcf_admin_init() {
	$settings = get_option( "dcf_theme_settings" );
}

function dcf_settings_page_init() {
	$settings_page = add_menu_page( 'De Coöperatie Fabriek', 'De Coöperatie Fabriek', 'edit_theme_options', 'dcf-theme-settings', 'dcf_settings_page', plugin_dir_url( __FILE__ ) . '../images/factory.png' );
	
	add_action( "load-{$settings_page}", 'dcf_load_settings_page' );
}

function dcf_load_settings_page() {
	if ( isset($_POST["dcf-settings-submit"]) && $_POST["dcf-settings-submit"] == 'Y' ) {
		check_admin_referer( "dcf-settings-page" );
		dcf_save_theme_settings();
		$url_parameters = isset($_GET['tab'])? 'updated=true&tab='.$_GET['tab'] : 'updated=true';
		wp_redirect(admin_url('admin.php?page=dcf-theme-settings&'.$url_parameters));
		exit;
	}
}

function dcf_save_theme_settings() {
	global $pagenow;
	$settings = get_option( "dcf_theme_settings" );
	
	if ( $_GET['page'] == 'dcf-theme-settings' ){ 
		if ( isset ( $_GET['tab'] ) )
	        $tab = $_GET['tab']; 
	    else
	        $tab = 'homepage'; 
	    switch ( $tab ){ 
			case 'homepage' :
				$settings['dcf_slider_title']	  	  = $_POST['dcf_slider_title'];
				$settings['dcf_slider_subtitle']	  = $_POST['dcf_slider_subtitle'];
				$settings['dcf_slider_button_1']	  = $_POST['dcf_slider_button_1'];
				$settings['dcf_slider_button_1_title']	  = $_POST['dcf_slider_button_1_title'];
				$settings['dcf_slider_button_1_link']	  = $_POST['dcf_slider_button_1_link'];
				$settings['dcf_slider_button_2']	  = $_POST['dcf_slider_button_2'];
				$settings['dcf_slider_button_2_title']	  = $_POST['dcf_slider_button_2_title'];
				$settings['dcf_slider_button_2_link']	  = $_POST['dcf_slider_button_2_link'];
				$settings['dcf_home_video']	  		  = $_POST['dcf_home_video'];
				$settings['dcf_home_video_link']	  = $_POST['dcf_home_video_link'];
				$settings['dcf_newsletter']	  		= $_POST['dcf_newsletter'];
			break;
	        case 'footer' :
				$settings['dcf_contact_intro'] = $_POST['dcf_contact_intro'];
				$settings['dcf_contact_info'] = $_POST['dcf_contact_info'];
			break;
			case 'sidebar' :
				$settings['dcf_sidebar_title']	  	  = $_POST['dcf_sidebar_title'];
				$settings['dcf_sidebar_content']	  	  = $_POST['dcf_sidebar_content'];
				$settings['dcf_sidebar_button']	  	  = $_POST['dcf_sidebar_button'];
				$settings['dcf_sidebar_button_link']	  	  = $_POST['dcf_sidebar_button_link'];
			break;
			case 'contact' :
				$settings['dcf_contact_linkedin']	  	  = $_POST['dcf_contact_linkedin'];
				$settings['dcf_contact_maps']	  		  = $_POST['dcf_contact_maps'];
				$settings['dcf_contact_address']	  	  = $_POST['dcf_contact_address'];
				$settings['dcf_contact_slogan']	  	  	  = $_POST['dcf_contact_slogan'];
			break;
	    }
	}
	
	$updated = update_option( "dcf_theme_settings", $settings );
}

function dcf_admin_tabs( $current = 'homepage' ) { 
    $tabs = array('general' => 'General', 'homepage' => 'Home', 'footer' => 'Footer', 'sidebar' => 'Sidebar', 'contact' => 'Contact');
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='?page=dcf-theme-settings&tab=$tab'>$name</a>";
        
    }
    echo '</h2>';
}

function dcf_settings_page() {
	global $pagenow;
	$settings = get_option( "dcf_theme_settings" );
	?>
	<div class="wrap">
		<h2><?php echo 'De Coöperatie Fabriek' ?> Thema instellingen</h2>
		<?php
			if ( 'true' == esc_attr( isset($_GET['updated']) && $_GET['updated'] ) ) echo '<div class="updated" ><p>De instellingen zijn aangepast.</p></div>';
			
			if ( isset ( $_GET['tab'] ) ) dcf_admin_tabs($_GET['tab']); else dcf_admin_tabs('homepage');
		?>

		<div id="poststuff">
			<form method="post" action="<?php admin_url( 'admin.php?page=dcf-theme-settings' ); ?>">
				<?php
				wp_nonce_field( "dcf-settings-page" ); 
				
				if ( $_GET['page'] == 'dcf-theme-settings' ){ 
					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
					else $tab = 'homepage'; 
					
					echo '<table class="form-table">';
					switch ( $tab ){
						case 'footer' : 
							?>
							<tr>
								<th><label>Contact</label></th>
								<td>
									<textarea id="dcf_contact_intro" name="dcf_contact_intro" cols="40" rows="2"><?php echo stripslashes($settings["dcf_contact_intro"]); ?></textarea><br/>
									<p class="description">Vul hier de tekst in.</p>
									<input id="dcf_contact_info" name="dcf_contact_info" type="text" value="<?php esc_attr_e($settings['dcf_contact_info']); ?>" /> <br/>
									<p class="description">Vul hier de info in.</p>
								</td>
							</tr>
							<?php
						break;
						case 'homepage' : 
							?>
							<tr>
								<th><label>Slider</label></th>
								<td>
									<input id="dcf_slider_title" name="dcf_slider_title" type="text" value="<?php esc_attr_e($settings['dcf_slider_title']); ?>" />
									<p class="description">Vul hier de titel van de slider in.</p>
									<textarea id="dcf_slider_subtitle" name="dcf_slider_subtitle" rows="2" cols="30"><?php echo stripslashes($settings['dcf_slider_subtitle']); ?></textarea>
									<p class="description">Vul hier de subtitel van de slider in.</p><br/>
									
									<input id="dcf_slider_button_1" name="dcf_slider_button_1" type="checkbox" <?php if ( $settings["dcf_slider_button_1"] ) echo 'checked="checked"'; ?> value="true" />
									<input id="dcf_slider_button_1_title" name="dcf_slider_button_1_title" type="text" value="<?php  esc_attr_e($settings['dcf_slider_button_1_title']); ?>" />
									<p class="description">1e knop in de slider</p>
									<input id="dcf_slider_button_1_link" name="dcf_slider_button_1_link" type="text" value="<?php  esc_attr_e($settings['dcf_slider_button_1_link']); ?>" />
									<p class="description">De link van de knop</p>
									
									<input id="dcf_slider_button_2" name="dcf_slider_button_2" type="checkbox" <?php if ( $settings["dcf_slider_button_2"] ) echo 'checked="checked"'; ?> value="true" />
									<input id="dcf_slider_button_2_title" name="dcf_slider_button_2_title" type="text" value="<?php  esc_attr_e($settings['dcf_slider_button_2_title']); ?>" />
									<p class="description">1e knop in de slider</p>
									<input id="dcf_slider_button_2_link" name="dcf_slider_button_2_link" type="text" value="<?php  esc_attr_e($settings['dcf_slider_button_2_link']); ?>" />
									<p class="description">De link van de knop</p>
								</td>
							</tr>
														
							<tr>
								<th><label>Video op de homepage</label></th>
								<td>
									<input id="dcf_home_video" name="dcf_home_video" type="checkbox" <?php if ( $settings["dcf_home_video"] ) echo 'checked="checked"'; ?> value="true" />
									<input id="dcf_home_video_link" name="dcf_home_video_link" type="text" value="<?php esc_attr_e($settings['dcf_home_video_link']); ?>" /> 
									<span class="description">Een video op de homepagina? Klik de checkbox aan en vul hier de URL in van de video.</span>
								</td>
							</tr>
							
							<tr>
								<th><label>Nieuwsbrief</label></th>
								<td>
									<input id="dcf_newsletter" name="dcf_newsletter" type="text" value="<?php esc_attr_e($settings['dcf_newsletter']); ?>" />
									<p class="description">De tekst voor bij de nieuwsbrief</p>
								</td>
							</tr>
							<?php
						break;
						case 'sidebar':
						?>
							<tr>
								<th><label>Sidebar</label></th>
								<td>
									<input id="dcf_sidebar_title" name="dcf_sidebar_title" type="text" value="<?php esc_attr_e($settings['dcf_sidebar_title']); ?>" /> <br/>
									<p class="description">Vul hier de titel van de sidebar in.</p>
									<textarea id="dcf_sidebar_content" name="dcf_sidebar_content" cols="40" rows="2"><?php echo stripslashes($settings["dcf_sidebar_content"]); ?></textarea><br/>
									<p class="description">Vul hier de tekst van de sidebar in.</p>
									<input id="dcf_sidebar_button" name="dcf_sidebar_button" type="text" value="<?php esc_attr_e($settings['dcf_sidebar_button']); ?>" /> <br/>
									<p class="description">Vul hier de tekst van de knop in.</p>
									<input id="dcf_sidebar_button_link" name="dcf_sidebar_button_link" type="text" value="<?php esc_attr_e($settings['dcf_sidebar_button_link']); ?>" /> <br/>
									<p class="description">Vul hier de url van de knop in.</p>
								</td>
							</tr>
						<?php
						break;
						case 'contact':
						?>
							<tr>
								<th><label>Contactgegevens</label></th>
								<td>
									<input id="dcf_contact_linkedin" name="dcf_contact_linkedin" type="text" value="<?php echo esc_attr_e($settings["dcf_contact_linkedin"]); ?>" /> <br/>
									<p class="description">Vul hier de pagina van LinkedIn in. <br/><code>http://www.linkedin.com/company/3218216?trk=NUS_CMPY_FOL-pdctd</p>
									<!--<textarea id="dcf_contact_maps" name="dcf_contact_maps" cols="40" rows="3"><?php echo stripslashes($settings['dcf_contact_maps']); ?></textarea><br/>
									<p class="description">Vul hier het adres voor Google Maps in. <br/><code>Straat huisnummer<br/>Postcode stad<br/>Land</code></p>-->
									<input id="dcf_contact_slogan" name="dcf_contact_slogan" type="text" value="<?php echo esc_attr_e($settings["dcf_contact_slogan"]); ?>" /> <br/>
									<p class="description">Vul hier de slogan in.</p>
									<?php 
										$dcf_contact_address = stripslashes($settings["dcf_contact_address"]);
									    echo wp_editor($dcf_contact_address, 'dcf_contact_address', array('textarea_name' => 'dcf_contact_address', 'media_buttons' => false, 'textarea_rows' => 5)  ); ?>
									<p class="description">Vul hier de contactgegevens in.</p>
								</td>
							</tr>
						<?php
						break;
					}
					echo '</table>';
				}
				?>
				<p class="submit" style="clear: both;">
					<input type="submit" name="Submit"  class="button-primary" value="Update Settings" />
					<input type="hidden" name="dcf-settings-submit" value="Y" />
				</p>
			</form>
			
		</div>

	</div>
<?php
}

/* settings link in plugin management screen */
function decooperatiefabriek_settings_link($actions, $file) {
if(false !== strpos($file, 'decooperatiefabriek'))
 	$actions['settings'] = '<a href="options-general.php?page=decooperatiefabriek_settings">Settings</a>';
	return $actions; 
}
add_filter('plugin_action_links', 'decooperatiefabriek_settings_link', 2, 2);

endif;