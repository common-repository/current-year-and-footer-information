<?php
/*
Plugin Name: Current Year and Footer Information
Plugin URI:
Description: Add the current year, the copyright symbol, the Legal Notice and the Cookies Policy with easy shortcodes.
Version: 1.0.0
Author: Inaudit
Author URI: http://www.inaudit.io
Text Domain: wpcyfi
License: GPL2

Current Year and Footer Information is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Current Year and Footer Information is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Current Year and Footer Information . If not, see <http://www.gnu.org/licenses/>.
*/
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
* WPCYFI_Shortcodes Class
* Registers shortcodes together with a shortcodes editor.
*
* @since 1.0.0
*/
class WPCYFI_Settings {

  /**
   * __construct function.
   *
   */
   public function __construct() {
     // Register wpcyfi_options_page to the admin_menu action hook
     add_action( 'admin_menu', array($this, 'wpcyfi_options_page'));
     // Register our wpcyfi_settings_init to the admin_init action hook
     add_action( 'admin_init', array($this, 'wpcyfi_settings_init'));
   }


   /**
    * Include our section in the top level menu
    */
   public function wpcyfi_options_page() {
     // add top level menu page
     add_menu_page(__('Current year and footer information', 'wpcyfi' ), __('Current year and footer info', 'wpcyfi' ), 'manage_options', 'wpcyfi', array($this, 'wpcyfi_options_page_html'));
   }

   /**
    * Top level menu: callback functions
    */
   public function wpcyfi_options_page_html() {
     // Check user capabilities
     if ( ! current_user_can( 'manage_options' ) ) {
       return;
     }

     // Add error/update messages

     //add_settings_error( string $setting, string $code, string $message, string $type = 'error');

     // Check if the user have submitted the settings
     // wordpress will add the "settings-updated" $_GET parameter to the url
     if ( isset( $_GET['settings-updated'] ) ) {
       // Add settings saved message with the class of "updated"
       add_settings_error( 'wpcyfi_messages', 'wpcyfi_message', __( 'Settings saved successfully.', 'wpcyfi' ), 'updated' );
     }

     // Show error/update messages
     settings_errors( 'wpcyfi_messages' );
   ?>

     <div class="wrap">
       <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
       <form class="form-horizontal" role="form" name="product_form" method="post" accept-charset="UTF-8" enctype="multipart/form-data" action="options.php" id="wpcyfi-group-information-form-add">
         <?php
           // Output security fields for the registered setting "wpcyfi"
           settings_fields( 'wpcyfi' );
           // Output setting sections and their fields
           do_settings_sections( 'wpcyfi' );
           // Save settings button
           submit_button(  __( 'Save settings', 'wpcyfi' ) );
         ?>
       </form>
     </div>
   <?php
   }

   /**
    * Add custom option and settings
    */
   public function wpcyfi_settings_init() {
     // Register settings for "wpcyfi" page:
     // wpcyfi_legal_notice_name, wpcyfi_legal_notice_url, wpcyfi_legal_notice_target, wpcyfi_cookies_name, wpcyfi_cookies_url, wpcyfi_cookies_target
     register_setting('wpcyfi', 'wpcyfi_legal_notice_name', ['type' => 'string', 'sanitize_callback' => array($this, 'wpcyfi_sanitize_text_cb')]);
     register_setting('wpcyfi', 'wpcyfi_legal_notice_url', ['type' => 'string', 'sanitize_callback' => array($this, 'wpcyfi_sanitize_url_cb')]);
     register_setting('wpcyfi', 'wpcyfi_legal_notice_target', ['type' => 'number', 'sanitize_callback' => array($this, 'wpcyfi_sanitize_checkbox_cb')]);
     register_setting('wpcyfi', 'wpcyfi_cookies_name', ['type' => 'string', 'sanitize_callback' => array($this, 'wpcyfi_sanitize_text_cb')]);
     register_setting('wpcyfi', 'wpcyfi_cookies_url', ['type' => 'string', 'sanitize_callback' => array($this, 'wpcyfi_sanitize_url_cb')]);
     register_setting('wpcyfi', 'wpcyfi_cookies_target', ['type' => 'number', 'sanitize_callback' => array($this, 'wpcyfi_sanitize_checkbox_cb')]);

     // Register a new section in the "wpcyfi" page
     add_settings_section('wpcyfi_section', '', array($this, 'wpcyfi_section_cb'), 'wpcyfi');

     // Register a fields inside the "wpcyfi" page:
     // wpcyfi_legal_notice_name, wpcyfi_legal_notice_url, wpcyfi_legal_notice_target, wpcyfi_cookies_name, wpcyfi_cookies_url, wpcyfi_cookies_target
     add_settings_field( 'wpcyfi_legal_notice_name', __('Legal notice name', 'wpcyfi'), array($this, 'wpcyfi_legal_notice_name_cb'), 'wpcyfi', 'wpcyfi_section',
                         ['name' => 'wpcyfi_legal_notice_name']);
     add_settings_field( 'wpcyfi_legal_notice_url', __('Legal notice URL', 'wpcyfi'), array($this, 'wpcyfi_legal_notice_url_cb'), 'wpcyfi', 'wpcyfi_section',
                         ['name' => 'wpcyfi_legal_notice_url']);
     add_settings_field( 'wpcyfi_legal_notice_target', __('Show URL in a new page', 'wpcyfi'), array($this, 'wpcyfi_legal_notice_target_cb'), 'wpcyfi', 'wpcyfi_section',
                         ['name' => 'wpcyfi_legal_notice_target']);
     add_settings_field( 'wpcyfi_cookies_name', __('Cookies name', 'wpcyfi'), array($this, 'wpcyfi_cookies_name_cb'), 'wpcyfi', 'wpcyfi_section',
                         ['name' => 'wpcyfi_cookies_name']);
     add_settings_field( 'wpcyfi_cookies_url', __('Cookies URL', 'wpcyfi'), array($this, 'wpcyfi_cookies_url_cb'), 'wpcyfi', 'wpcyfi_section',
                         ['name' => 'wpcyfi_cookies_url']);
     add_settings_field( 'wpcyfi_cookies_target', __('Show URL in a new page', 'wpcyfi'), array($this, 'wpcyfi_cookies_target_cb'), 'wpcyfi', 'wpcyfi_section',
                         ['name' => 'wpcyfi_cookies_target']);
   }

   /**
    * Custom option and settings: callback functions
    */
   // Wpcyfi section cb
   public function wpcyfi_section_cb( $args ) {
   ?>
     <p><?php echo __('As easiest as:', 'wpcyfi' )?></p>
     <p><?php echo __('Add Current Year using this shortcode: [cy]', 'wpcyfi' )?></p>
     <p><?php echo __('Add Copyright symbol &copy; using this shortcode: [c]', 'wpcyfi' )?></p>
     <p><?php echo __('Add Legal Notice link using this shortcode: [legal_notice] (form below must be filled in).', 'wpcyfi' )?></p>
     <p><?php echo __('Add Cookies link using this shortcode: [cookies] (form below must be filled in).', 'wpcyfi' )?></p>
     <p><?php echo __('Legal Notice and Cookies policy must be configured in the plugin options with the name and the URL.', 'wpcyfi' )?></p>
   <?php
   }

   // Legal notice name field cb
   public function wpcyfi_legal_notice_name_cb( $args ) {
      // Get the value of the setting we've registered with register_setting()
      $value = get_option( 'wpcyfi_legal_notice_name' );
   ?>
     <input type="text" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['name']) ?>" autocomplete="off" value="<?php echo esc_html($value) ?>" placeholder="<?php echo esc_attr($args['placeholder']) ?>" size="75"/>
   <?php
   }

   // Legal notice url field cb
   public function wpcyfi_legal_notice_url_cb( $args ) {
     // Get the value of the setting we've registered with register_setting()
     $value = get_option( 'wpcyfi_legal_notice_url' );
   ?>
     <input type="text" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['name']) ?>" autocomplete="off" value="<?php echo esc_html($value) ?>" placeholder="<?php echo esc_attr($args['placeholder']) ?>" size="75"/>
   <?php
   }

   // Legal notice target field cb
   public function wpcyfi_legal_notice_target_cb( $args ) {
     // Get the value of the setting we've registered with register_setting()
     $value = get_option( 'wpcyfi_legal_notice_target' );
   ?>
     <input type="checkbox" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['name']); ?>" <?php echo checked( 1, $value, false ) ?> data-unchecked-value="no" />
   <?php
   }

   // Cookies name field cb
   public function wpcyfi_cookies_name_cb( $args ) {
      // Get the value of the setting we've registered with register_setting()
      $value = get_option( 'wpcyfi_cookies_name' );
   ?>
     <input type="text" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['name']) ?>" autocomplete="off" value="<?php echo esc_html($value) ?>" placeholder="<?php echo esc_attr($args['placeholder']) ?>" size="75"/>
   <?php
   }

   // Cookies url field cb
   public function wpcyfi_cookies_url_cb( $args ) {
     // Get the value of the setting we've registered with register_setting()
     $value = get_option( 'wpcyfi_cookies_url' );
   ?>
     <input type="text" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['name']) ?>" autocomplete="off" value="<?php echo esc_html($value) ?>" placeholder="<?php echo esc_attr($args['placeholder']) ?>" size="75"/>
   <?php
   }

   // Cookies target field cb
   public function wpcyfi_cookies_target_cb( $args ) {
     // Get the value of the setting we've registered with register_setting()
     $value = get_option( 'wpcyfi_cookies_target' );
   ?>
     <input type="checkbox" name="<?php echo esc_attr($args['name']); ?>" id="<?php echo esc_attr($args['name']); ?>" <?php echo checked( 1, $value, false ) ?> data-unchecked-value="no" />
   <?php
   }

   /**
    * Custom sanitize and validation: callback functions
    */

   // Legal notice and cookies name sanitize cb
   public function wpcyfi_sanitize_text_cb( $args ) {
     return sanitize_text_field($args);
   }

   // Legal notice and cookies url sanitize cb
   public function wpcyfi_sanitize_url_cb( $args ) {
     if(!empty($args) && $args != '#' && !preg_match("/([0-9a-z-]+\.)?[0-9a-z-]+\.[a-z]{2,7}/", $args)){
       add_settings_error( 'wpcyfi_messages', 'wpcyfi_message', __('Not valid URL', 'wpcyfi'), 'error');
       return '';
     }
     return esc_url_raw($args);
   }

   // Legal notice and cookies target sanitize cb
   public function wpcyfi_sanitize_checkbox_cb( $args ) {
     return (isset($args) && !empty($args)) ? 1 : 0;
   }

}

new WPCYFI_Settings;
