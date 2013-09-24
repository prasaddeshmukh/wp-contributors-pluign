<?php

/**
 *Contributors Plugin 
 *Settings/options page for contributors plugin 
 */


//default settings	
	register_activation_hook(__FILE__, 'contributors_defaults');
	function contributors_add_defaults() {
		$tmp = get_option('plugin_options');
		if(!is_array($tmp)){
		$arr = array("option_set_cbox" => "above", "option_set_author"=>"yes");
		update_option('plugin_options', $arr);
		}	
		}		

/**
 *Callbacks from 'admin_init' add_settings_field
 */

//Radio options for contributor box's position
	function contributors_box_section(){
		echo '<p>Choose option whether to display contributors box above the post content or below it</p>';	
		}

	function contributors_box_radio(){
		$options = get_option('plugin_options');
		$items = array("above", "below");	

		foreach($items as $item) {
			$checked = ($options['option_set_cbox']==$item) ? ' checked="checked" ' : '';
			echo "<label><input ".$checked." value='$item' name='plugin_options[option_set_cbox]' type='radio' /> $item</label><br />";
		
		}
		}
	
	
//Radio options for whether to display original author of the post or not.
	function original_author_display_section(){
		echo '<p>Choose option whether to display original author on meta box and contributors box</p>';
		}

	function original_author_radio(){
		$options = get_option('plugin_options');
		$items = array("yes", "no");	
		foreach($items as $item) {
			$checked = ($options['option_set_author']==$item) ? ' checked="checked" ' : '';
			echo "<label><input ".$checked." value='$item' name='plugin_options[option_set_author]' type='radio' /> $item</label><br />";
			
		}
		}

/**
*'admin_menu' hook for adding page
*/	
	function options_add_page(){
			add_options_page('contributors Plugin Page','Contributors Settings', 'administrator', __FILE__, 'contributors_plugin_options_page');
	}
	add_action('admin_menu','options_add_page');

//Callback from options_add_page to add setting fields to settings page		
	function contributors_plugin_options_page(){
		?>
		<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Contributors Plugin Settings</h2>
		<form action="options.php" method="post">
			<?php settings_fields('plugin_options');?>
			<?php do_settings_sections(__FILE__);?>				
			<p class="submit">
				<input name="submit" type="submit" class="button-primary" value="<?php esc_attr_e('Save Changes');?>"/>
			</p>
		</form>
		</div>
		<?php
		}

/**
*'admin_init' hook registering settings, add setting sections and add settings fields
*/	
		
add_action('admin_init','options_init');
function options_init(){
	register_setting('plugin_options', 'plugin_options', 'plugin_options_validate');
	add_settings_section('contributors_box_section','Contributors Box Section','contributors_box_section',__FILE__);
	add_settings_field('radio_buttons_contributors_box','Contributos Box Postion','contributors_box_radio',__FILE__,'contributors_box_section');
		
	add_settings_section('original_author_display_section','Original Author Display Section','original_author_display_section',__FILE__);
	add_settings_field('radio_buttons_original_author','Original Author Display','original_author_radio',__FILE__,'original_author_display_section');
}

?>